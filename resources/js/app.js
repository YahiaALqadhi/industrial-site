import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import { ScrollTrigger } from './core/gsap';
import { initLenis } from './core/lenis';
import { initScrollAnimations } from './animations/scroll';
import { initMouseMovement } from './animations/mouse';
import { initIndustrialScene } from './three/industrial-scene';

// ✅ phone input
import 'intl-tel-input/build/css/intlTelInput.css';
import { initPhoneInputs } from './components/phone-input';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

window.addEventListener('DOMContentLoaded', () => {
    initLenis();
    initIndustrialScene();
    initScrollAnimations();
    initMouseMovement();

    // ✅ initialize phone inputs
    initPhoneInputs();

    requestAnimationFrame(() => {
        ScrollTrigger.refresh();
    });
});