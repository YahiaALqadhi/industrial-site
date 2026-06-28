import { gsap } from '../core/gsap';

export function initMouseMovement() {
    const targets = document.querySelectorAll('[data-mouse-depth]');
    if (!targets.length) return;

    const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    if (!canHover) return;

    targets.forEach((target) => {
        const depth = Number(target.dataset.mouseDepth || 2);

        gsap.set(target, {
            transformPerspective: 1200,
            transformStyle: 'preserve-3d',
            willChange: 'transform',
        });

        const moveTo = gsap.quickTo(target, 'rotateY', {
            duration: 0.45,
            ease: 'power3.out',
        });

        const tiltTo = gsap.quickTo(target, 'rotateX', {
            duration: 0.45,
            ease: 'power3.out',
        });

        const liftTo = gsap.quickTo(target, 'y', {
            duration: 0.45,
            ease: 'power3.out',
        });

        target.addEventListener('mousemove', (event) => {
            const rect = target.getBoundingClientRect();

            const x = (event.clientX - rect.left) / rect.width - 0.5;
            const y = (event.clientY - rect.top) / rect.height - 0.5;

            moveTo(x * depth);
            tiltTo(-y * depth);
            liftTo(-2);
        });

        target.addEventListener('mouseleave', () => {
            moveTo(0);
            tiltTo(0);
            liftTo(0);
        });
    });
}