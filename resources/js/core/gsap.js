// resources/js/core/gsap.js

import { gsap } from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

// register مرة واحدة فقط
if (!gsap.core.globals().ScrollTrigger) {
    gsap.registerPlugin(ScrollTrigger);
}

// تحسين الأداء الافتراضي
gsap.config({
    force3D: true,
    nullTargetWarn: false,
});

// defaults عامة لكل الأنيميشن
gsap.defaults({
    ease: 'power2.out',
    duration: 0.6,
});

export { gsap, ScrollTrigger };