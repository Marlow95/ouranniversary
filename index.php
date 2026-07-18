<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Happy Anniversary and Birthday</title>
    <style>
        body { margin: 0; overflow-x: hidden; background: #01050a; font-family: sans-serif; }
        canvas { display: block; position: fixed; top: 0; left: 0; z-index: 1; }
        
        #main-container { height: 300vh; position: relative; z-index: 2; }
        
        #message-box { 
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            visibility: hidden; /* Prevent flash on load */
            color: rgba(255, 255, 255, 0); 
            text-align: center; 
            pointer-events: none;
            text-shadow: 0 0 0px #fff;
            width: 80%;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>
<body>

    <div id="main-container">
        <div id="message-box">
            <h1>Hello My Love</h1>
            <p>The day that we first met is extra special.<br>
            It's both your birthday and the day we first met.<br>
            It is a day I will always hold in my heart.<br><br>
            Because it is a rememberance. A remeberance of both you and me.<br>
            I remember your cheerful laughter when we first met. And your playfulness.<br>
            I was drawn to your smile and energy.<br><br>
            As well as your beauty. You showed me you are a person full of both inner and outer beauty.<br>
            Cheerfulness and laughter. Wholistic beauty and creative genius.<br>
            Seeing all of these wonderful sides of you has been the greatest romantic experience of my life.<br><br>
            You are the woman I love, adore, and cherish. The beacon of my hapinesss.<br>
            And I love you, very much. And I smile when you call me your Marlow.<br><br>
            You are in my heart now and forevermore.<br>
            Happy Anniversary and Birthday. Sweet Darling.
            </p>
        </div>
    </div>

    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
            }
        }
    </script>
    <script type="module">
        import * as THREE from 'three';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
        import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
        import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
        import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';

        // 1. Setup
        const scene = new THREE.Scene();
        scene.fog = new THREE.Fog(0x01050a, 15, 80);
        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0, 5, 20);
        
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        const controls = new OrbitControls(camera, renderer.domElement);
        const composer = new EffectComposer(renderer);
        composer.addPass(new RenderPass(scene, camera));
        composer.addPass(new UnrealBloomPass(new THREE.Vector2(window.innerWidth, window.innerHeight), 1.0, 0.4, 0.8));

        // 2. Stars (Warm yellow, subtle, forced to back)
        const starGeo = new THREE.BufferGeometry();
        const starVertices = [];
        for (let i = 0; i < 5000; i++) {
            // Spread further out so they feel more like a background sky
            starVertices.push((Math.random() - 0.5) * 2000, (Math.random() - 0.5) * 2000, (Math.random() - 0.5) * 2000);
        }
        starGeo.setAttribute('position', new THREE.Float32BufferAttribute(starVertices, 3));

        const starMaterial = new THREE.PointsMaterial({ 
            color: 0xfff5cc, // Warm yellow color
            size: 0.7, 
            transparent: true, 
            opacity: 0.8, 
            depthWrite: false // Ensures they don't block objects in front
        });

        const stars = new THREE.Points(starGeo, starMaterial);
        stars.renderOrder = -1; // Forces the renderer to draw stars first
        scene.add(stars);

        // 3. Models
        const loader = new GLTFLoader();
        loader.load('Tent.glb', (gltf) => {
            gltf.scene.traverse((c) => { if (c.isMesh) c.material.color.set(0xf26a8d); });
            gltf.scene.position.set(-4, 0, 0);
            gltf.scene.scale.set(3, 3, 3);
            scene.add(gltf.scene);
        });
        loader.load('Campfire.glb', (gltf) => {
            gltf.scene.position.set(4, 0, 0);
            gltf.scene.scale.set(0.2, 0.2, 0.2); 
            scene.add(gltf.scene);
        });

        // 4. Lighting & Environment
        const ambLight = new THREE.AmbientLight(0x050a20, 0.5);
        scene.add(ambLight);
        const fireLight = new THREE.PointLight(0xffa500, 20, 20);
        fireLight.position.set(4, 1.5, 0);
        scene.add(fireLight);

        const ground = new THREE.Mesh(new THREE.PlaneGeometry(100, 100, 64, 64), new THREE.MeshStandardMaterial({ color: 0x224422, roughness: 0.9 }));
        ground.rotation.x = -Math.PI / 2;
        const pos = ground.geometry.attributes.position;
        for (let i = 0; i < pos.count; i++) pos.setZ(i, pos.getZ(i) + (Math.random() * 0.3));
        pos.needsUpdate = true;
        scene.add(ground);

        const lake = new THREE.Mesh(new THREE.PlaneGeometry(200, 100), new THREE.MeshStandardMaterial({ color: 0x051a36, roughness: 0.1 }));
        lake.rotation.x = -Math.PI / 2;
        lake.position.set(0, -0.2, -40);
        scene.add(lake);

        const treeMaterial = new THREE.MeshStandardMaterial({ color: 0x2d5a27 });
        for (let i = 0; i < 40; i++) {
            const tree = new THREE.Mesh(new THREE.CylinderGeometry(0, 2, 8, 3), treeMaterial);
            tree.position.set((Math.random() - 0.5) * 150, 4, -25 - (Math.random() * 20));
            scene.add(tree);
        }

        const moonLight = new THREE.DirectionalLight(0xadd8e6, 0.5);
        moonLight.position.set(10, 20, 10);
        scene.add(moonLight);

        // 5. GSAP Scroll Animation
        gsap.registerPlugin(ScrollTrigger);
        gsap.timeline({ 
            scrollTrigger: { trigger: "#main-container", start: "top top", end: "bottom bottom", scrub: 1, pin: true } 
        })
        .set("#message-box", { visibility: "visible" }) // Reveal only on scroll
        .to(camera.position, { z: 10, duration: 2 }, 0)
        .to(ambLight, { intensity: 2.0, duration: 1 }, 0)
        .to("#message-box", { color: "rgba(255,255,255,1)", textShadow: "0 0 20px #fff", duration: 1 }, 0.5);

        function animate() {
            requestAnimationFrame(animate);
            fireLight.intensity = 15 + Math.random() * 5;
            controls.update();
            composer.render();
        }
        animate();
    </script>
</body>
</html>