/**
 * NetroHub Animations & Interactions
 * Smooth scroll animations, micro-interactions, and UI enhancements
 */

// Intersection Observer for scroll animations
const observeElements = () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Optionally unobserve after animation
                if (!entry.target.dataset.keepObserving) {
                    observer.unobserve(entry.target);
                }
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-fade-in class
    document.querySelectorAll('.scroll-fade-in').forEach(el => {
        observer.observe(el);
    });

    // Observe staggered animations
    document.querySelectorAll('.scroll-stagger').forEach((container, index) => {
        const children = container.children;
        Array.from(children).forEach((child, childIndex) => {
            child.style.transitionDelay = `${childIndex * 100}ms`;
            child.classList.add('scroll-fade-in');
            observer.observe(child);
        });
    });
};

// Smooth scroll to anchor links
const setupSmoothScroll = () => {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '#!') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
};

// Add ripple effect to buttons
const addRippleEffect = () => {
    document.querySelectorAll('.btn-primary, .btn-secondary, .btn-success').forEach(button => {
        button.addEventListener('click', function(e) {
            // Don't add multiple ripples
            if (this.querySelector('.ripple')) return;
            
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            setTimeout(() => ripple.remove(), 600);
        });
    });
};

// Parallax effect for background elements
const setupParallax = () => {
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    
    if (parallaxElements.length === 0) return;

    let ticking = false;

    const updateParallax = () => {
        const scrolled = window.pageYOffset;

        parallaxElements.forEach(el => {
            const speed = parseFloat(el.dataset.parallax) || 0.5;
            const yPos = -(scrolled * speed);
            el.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });

        ticking = false;
    };

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });
};

// Lazy load images
const setupLazyLoading = () => {
    if ('loading' in HTMLImageElement.prototype) {
        // Browser supports native lazy loading
        const images = document.querySelectorAll('img[data-src]');
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    } else {
        // Fallback for older browsers
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
};

// Card hover tilt effect
const setupCardTilt = () => {
    document.querySelectorAll('.card-hover').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
        });
    });
};

// Number counter animation
const animateCounters = () => {
    const counters = document.querySelectorAll('[data-count]');
    
    const countObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseFloat(counter.dataset.count);
                const duration = parseInt(counter.dataset.duration) || 2000;
                const start = 0;
                const increment = target / (duration / 16);
                let current = start;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                };

                updateCounter();
                countObserver.unobserve(counter);
            }
        });
    });

    counters.forEach(counter => countObserver.observe(counter));
};

// Toast notifications
window.showToast = (message, type = 'success', duration = 3000) => {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type} animate-slide-down`;
    
    const icons = {
        success: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
        error: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
        warning: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
        info: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
    };
    
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            ${icons[type] || icons.info}
            <span>${message}</span>
        </div>
    `;
    
    // Add toast container if it doesn't exist
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
    }
    
    container.appendChild(toast);
    
    // Auto remove
    setTimeout(() => {
        toast.classList.add('animate-fade-out');
        setTimeout(() => toast.remove(), 300);
    }, duration);
    
    // Click to dismiss
    toast.addEventListener('click', () => {
        toast.classList.add('animate-fade-out');
        setTimeout(() => toast.remove(), 300);
    });
};

// Loading bar for page transitions
const setupLoadingBar = () => {
    const loadingBar = document.createElement('div');
    loadingBar.id = 'loading-bar';
    loadingBar.className = 'fixed top-0 left-0 h-1 bg-gaming-gradient z-50 transition-all duration-300';
    loadingBar.style.width = '0%';
    document.body.appendChild(loadingBar);

    // Show on link clicks
    document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])').forEach(link => {
        link.addEventListener('click', (e) => {
            loadingBar.style.width = '70%';
        });
    });

    // Complete on page load
    window.addEventListener('load', () => {
        loadingBar.style.width = '100%';
        setTimeout(() => {
            loadingBar.style.opacity = '0';
            setTimeout(() => loadingBar.style.width = '0%', 300);
            setTimeout(() => loadingBar.style.opacity = '1', 400);
        }, 200);
    });
};

// Copy to clipboard with animation
window.copyToClipboard = async (text, button) => {
    try {
        await navigator.clipboard.writeText(text);
        
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Copied!';
        button.classList.add('bg-neon-green', 'text-dark-900');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-neon-green', 'text-dark-900');
        }, 2000);
    } catch (err) {
        console.error('Failed to copy:', err);
        showToast('Failed to copy to clipboard', 'error');
    }
};

// Initialize all animations on DOM ready
const initAnimations = () => {
    observeElements();
    setupSmoothScroll();
    addRippleEffect();
    setupParallax();
    setupLazyLoading();
    setupCardTilt();
    animateCounters();
    setupLoadingBar();
    
    console.log('✨ NetroHub animations initialized');
};

// Run on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAnimations);
} else {
    initAnimations();
}

// Export for manual initialization
export { initAnimations, showToast, copyToClipboard };


