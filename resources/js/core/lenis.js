import Lenis from 'lenis';
import { gsap, ScrollTrigger } from './gsap';

let lenisInstance = null;

export function initLenis() {
    if (lenisInstance) {
        return lenisInstance;
    }

    const lenis = new Lenis({
        duration: 1.15,
        smoothWheel: true,
        wheelMultiplier: 1,
        touchMultiplier: 1.4,
        lerp: 0.085,
    });

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);

    window.addEventListener('resize', () => {
        ScrollTrigger.refresh();
    });

    lenisInstance = lenis;

    return lenis;
}