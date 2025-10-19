/**
 * NXO Performance Optimizations
 * Handles long tasks, debouncing, and performance monitoring
 */

// Debounce utility function
const debounce = (fn, ms = 150) => {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), ms);
    };
};

// Throttle utility function
const throttle = (fn, ms = 100) => {
    let lastCall = 0;
    return (...args) => {
        const now = Date.now();
        if (now - lastCall >= ms) {
            lastCall = now;
            fn(...args);
        }
    };
};

// RequestIdleCallback polyfill
const requestIdleCallback = window.requestIdleCallback || 
    ((callback) => setTimeout(callback, 1));

// Performance monitoring
const performanceMonitor = {
    longTasks: [],
    
    init() {
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.duration > 50) { // Tasks longer than 50ms
                        this.longTasks.push({
                            duration: entry.duration,
                            startTime: entry.startTime,
                            name: entry.name || 'Unknown'
                        });
                        
                        console.warn(`Long task detected: ${entry.duration.toFixed(2)}ms`);
                    }
                }
            });
            
            observer.observe({ entryTypes: ['longtask'] });
        }
    },
    
    getReport() {
        return {
            longTasks: this.longTasks,
            totalLongTasks: this.longTasks.length,
            averageLongTaskDuration: this.longTasks.reduce((sum, task) => sum + task.duration, 0) / this.longTasks.length || 0
        };
    }
};

// Optimized event listeners
const optimizedListeners = {
    // Debounced scroll listener
    scroll: debounce((event) => {
        // Handle scroll events efficiently
        document.querySelectorAll("[data-parallax]").forEach(element => {
            const speed = element.dataset.parallax || 0.5;
            const yPos = -(window.pageYOffset * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    }, 16), // ~60fps
    
    // Throttled resize listener
    resize: throttle((event) => {
        // Handle resize events
        window.dispatchEvent(new CustomEvent('optimized-resize'));
    }, 100),
    
    // Debounced message listener for Turnstile
    message: debounce((event) => {
        // Handle Turnstile messages efficiently
        if (event.origin === 'https://challenges.cloudflare.com') {
            // Process Turnstile messages
            if (window.turnstile && event.data && event.data.type) {
                // Handle Turnstile events
                console.log('Turnstile message:', event.data);
            }
        }
    }, 150)
};

// Lazy initialization for non-critical components
const lazyInit = {
    components: new Map(),
    
    register(name, initFunction, options = {}) {
        this.components.set(name, {
            init: initFunction,
            initialized: false,
            options: {
                threshold: 0.1,
                rootMargin: '50px',
                ...options
            }
        });
    },
    
    init() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const componentName = entry.target.dataset.lazyComponent;
                        const component = this.components.get(componentName);
                        
                        if (component && !component.initialized) {
                            requestIdleCallback(() => {
                                component.init(entry.target);
                                component.initialized = true;
                                observer.unobserve(entry.target);
                            });
                        }
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });
            
            // Observe all lazy components
            document.querySelectorAll('[data-lazy-component]').forEach(element => {
                observer.observe(element);
            });
        }
    }
};

// Batch DOM operations
const domBatcher = {
    reads: [],
    writes: [],
    
    read(callback) {
        this.reads.push(callback);
        this.scheduleFlush();
    },
    
    write(callback) {
        this.writes.push(callback);
        this.scheduleFlush();
    },
    
    scheduleFlush() {
        if (!this.scheduled) {
            this.scheduled = true;
            requestAnimationFrame(() => {
                // Batch all reads first
                this.reads.forEach(callback => callback());
                this.reads = [];
                
                // Then batch all writes
                this.writes.forEach(callback => callback());
                this.writes = [];
                
                this.scheduled = false;
            });
        }
    }
};

// Initialize performance optimizations
document.addEventListener('DOMContentLoaded', () => {
    // Initialize performance monitoring
    performanceMonitor.init();
    
    // Set up optimized event listeners
    window.addEventListener('scroll', optimizedListeners.scroll, { passive: true });
    window.addEventListener('resize', optimizedListeners.resize, { passive: true });
    window.addEventListener('message', optimizedListeners.message);
    
    // Initialize lazy loading
    lazyInit.init();
    
    // Defer non-critical initialization
    requestIdleCallback(() => {
        // Initialize non-critical components here
        console.log('NXO Performance optimizations initialized');
    });
});

// Export utilities for use in other scripts
window.NXOPerformance = {
    debounce,
    throttle,
    requestIdleCallback,
    performanceMonitor,
    lazyInit,
    domBatcher
};
