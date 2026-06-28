import { gsap, ScrollTrigger } from '../core/gsap';

export function initScrollAnimations() {
    initRevealAnimations();
    initParallaxAnimations();
    initImageZoomAnimations();

    ScrollTrigger.refresh();
}

function initRevealAnimations() {
    const elements = gsap.utils.toArray('[data-reveal]:not([data-animated])');

    elements.forEach((el) => {
        el.dataset.animated = 'true';

        gsap.from(el, {
            y: 56,
            opacity: 0,
            duration: 0.85,
            ease: 'power3.out',
            overwrite: true,
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
                toggleActions: 'play none none none',
            },
        });
    });
}

function initParallaxAnimations() {
    const elements = gsap.utils.toArray('[data-parallax]:not([data-parallax-ready])');

    elements.forEach((el) => {
        el.dataset.parallaxReady = 'true';

        const speed = Number(el.dataset.parallax || 70);

        gsap.to(el, {
            y: -speed,
            ease: 'none',
            overwrite: true,
            scrollTrigger: {
                trigger: el.closest('section') || el,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.8,
            },
        });
    });
}

function initImageZoomAnimations() {
    const images = gsap.utils.toArray('.group img:not([data-zoom-ready])');

    images.forEach((img) => {
        img.dataset.zoomReady = 'true';

        gsap.from(img, {
            scale: 1.06,
            duration: 1.1,
            ease: 'power2.out',
            overwrite: true,
            scrollTrigger: {
                trigger: img,
                start: 'top 90%',
                toggleActions: 'play none none none',
            },
        });
    });
}