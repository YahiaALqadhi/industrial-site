import * as THREE from 'three';

let sceneInstance = null;

export function initIndustrialScene() {
    if (sceneInstance) return;

    const canvas = document.querySelector('[data-industrial-scene]');
    if (!canvas) return;

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    camera.position.set(0, 0, 6);

    const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true,
    });

    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    const group = new THREE.Group();
    scene.add(group);

    /*
    =====================================
    Logo
    =====================================
    */

    const textureLoader = new THREE.TextureLoader();

    textureLoader.load('/assets/images/logo.jpg', (texture) => {
        texture.colorSpace = THREE.SRGBColorSpace;

        const geometry = new THREE.PlaneGeometry(3.6, 3.6);
        const material = new THREE.MeshBasicMaterial({
            map: texture,
        });

        const logo = new THREE.Mesh(geometry, material);
        group.add(logo);
    });

    /*
    =====================================
    Mouse interaction (optimized)
    =====================================
    */

    const mouse = { x: 0, y: 0 };

    const onMouseMove = (event) => {
        mouse.x = (event.clientX / window.innerWidth - 0.5) * 2;
        mouse.y = (event.clientY / window.innerHeight - 0.5) * 2;
    };

    window.addEventListener('mousemove', onMouseMove, { passive: true });

    /*
    =====================================
    Resize (clean)
    =====================================
    */

    function resize() {
        const width = canvas.clientWidth || canvas.parentElement.clientWidth;
        const height = canvas.clientHeight || canvas.parentElement.clientHeight;

        if (!width || !height) return;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();

        renderer.setSize(width, height, false);
    }

    resize();

    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(canvas.parentElement);

    /*
    =====================================
    Animation Loop (optimized)
    =====================================
    */

    let lastTime = 0;

    function animate(time = 0) {
        const delta = time - lastTime;
        lastTime = time;

        group.rotation.y += (mouse.x * 0.18 - group.rotation.y) * 0.05;
        group.rotation.x += (-mouse.y * 0.12 - group.rotation.x) * 0.05;

        group.position.y = Math.sin(time * 0.0012) * 0.05;

        renderer.render(scene, camera);

        requestAnimationFrame(animate);
    }

    animate();

    /*
    =====================================
    Save instance
    =====================================
    */

    sceneInstance = {
        renderer,
        scene,
        camera,
        resizeObserver,
    };
}