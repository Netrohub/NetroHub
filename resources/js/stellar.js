/**
 * Stellar Frontend Template Scripts
 */

import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Initialize AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        once: true,
        disable: 'phone',
        duration: 1000,
        easing: 'ease-out-cubic',
    });
});

// Mobile menu toggle
window.initMobileMenu = () => {
    return {
        mobileMenuOpen: false,
        toggle() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
        },
        close() {
            this.mobileMenuOpen = false;
        }
    };
};

// Particles animation for hero section
window.initParticles = () => {
    const canvas = document.getElementById('particles');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];
    const particleCount = 100;

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.vx = (Math.random() - 0.5) * 0.5;
            this.vy = (Math.random() - 0.5) * 0.5;
            this.radius = Math.random() * 1.5;
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(147, 51, 234, 0.5)';
            ctx.fill();
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
            if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
        }
    }

    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(particle => {
            particle.update();
            particle.draw();
        });
        requestAnimationFrame(animate);
    }

    animate();

    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
};

// Smooth scroll to anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href && href !== '#' && href !== '#0') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Testimonials carousel
window.initTestimonialsCarousel = () => {
    return {
        currentIndex: 0,
        testimonials: [],
        init() {
            this.testimonials = Array.from(this.$el.querySelectorAll('[data-testimonial]'));
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.testimonials.length;
            this.updateCarousel();
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.testimonials.length) % this.testimonials.length;
            this.updateCarousel();
        },
        updateCarousel() {
            this.testimonials.forEach((testimonial, index) => {
                testimonial.style.display = index === this.currentIndex ? 'block' : 'none';
            });
        }
    };
};

// Price toggle (monthly/yearly)
window.initPriceToggle = () => {
    return {
        annual: false,
        toggle() {
            this.annual = !this.annual;
        }
    };
};

