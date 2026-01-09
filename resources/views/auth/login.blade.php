<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | OurLabz Portal</title>

    <!-- Bootstrap & MDB -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0095d9;
            --gradient-color: linear-gradient(135deg, #0095d9, #00c6ff);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-color);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            z-index: 5;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 1s ease both;
            max-width: 950px;
            width: 100%;
        }

        .illustration {
            background: linear-gradient(135deg, #e1f5fe, #b3e5fc);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            animation: slideInLeft 1.2s ease both;
        }

        .illustration img {
            max-width: 360px;
            width: 100%;
            animation: float 3s ease-in-out infinite;
        }

        .login-form {
            padding: 3rem;
            animation: slideInRight 1.2s ease both;
        }

        .brand-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .login-form h2 {
            color: #004a77;
            font-weight: 700;
            text-align: center;
            font-size: 1.5rem;
        }

        .role-badge {
            display: block;
            text-align: center;
            font-size: 0.9rem;
            background: #e3f2fd;
            color: var(--primary-color);
            border-radius: 8px;
            padding: 6px 12px;
            margin: 10px auto 20px;
            width: fit-content;
            font-weight: 500;
        }

        .btn-login {
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #007bb3;
            transform: scale(1.03);
            box-shadow: 0 4px 15px rgba(0, 149, 217, 0.4);
        }

        .form-control {
            border-radius: 10px !important;
            box-shadow: none !important;
            border: 1px solid #cfd8dc;
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #fff;
            font-size: 14px;
            opacity: 0.9;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive */
        @media (max-width: 767px) {
            .login-form {
                padding: 2rem;
            }

            .brand-name {
                font-size: 1.4rem;
            }

            .login-form h2 {
                font-size: 1.3rem;
            }
        }

        /* Particle Background */
        #particle-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            opacity: 0.8;
            animation: floatParticle 10s ease-in-out infinite;
        }

        /* Randomized sizes */
        .particle:nth-child(1) {
            width: 8px;
            height: 8px;
            top: 10%;
            left: 20%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 12px;
            height: 12px;
            top: 40%;
            left: 80%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 6px;
            height: 6px;
            top: 70%;
            left: 10%;
            animation-delay: 4s;
        }

        .particle:nth-child(4) {
            width: 15px;
            height: 15px;
            top: 30%;
            left: 50%;
            animation-delay: 1s;
        }

        .particle:nth-child(5) {
            width: 10px;
            height: 10px;
            top: 80%;
            left: 70%;
            animation-delay: 3s;
        }

        .particle:nth-child(6) {
            width: 7px;
            height: 7px;
            top: 55%;
            left: 35%;
            animation-delay: 5s;
        }

        .particle:nth-child(7) {
            width: 9px;
            height: 9px;
            top: 15%;
            left: 65%;
            animation-delay: 6s;
        }

        .particle:nth-child(8) {
            width: 11px;
            height: 11px;
            top: 75%;
            left: 45%;
            animation-delay: 7s;
        }

        .particle:nth-child(9) {
            width: 5px;
            height: 5px;
            top: 60%;
            left: 15%;
            animation-delay: 8s;
        }

        .particle:nth-child(10) {
            width: 13px;
            height: 13px;
            top: 25%;
            left: 85%;
            animation-delay: 9s;
        }

        @keyframes floatParticle {

            0%,
            100% {
                transform: translate(0, 0);
                opacity: 0.8;
            }

            50% {
                transform: translate(20px, -30px);
                opacity: 1;
            }
        }

        /* Fullscreen canvas behind content */
        #bg {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            display: block;
        }

        .reg-modal-content {
            background: #fff;
            box-shadow: 0 20px 50px rgba(0, 149, 217, 0.25);
            animation: scaleIn 0.4s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.85);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .reg-card {
            background: #f8faff;
            border-radius: 16px;
            padding: 20px 10px;
            text-align: center;
            transition: all 0.35s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .reg-card .icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--bs-primary);
            transition: all 0.3s ease;
        }

        .reg-card:hover {
            background: #0095d9;
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 149, 217, 0.3);
            border-color: #0095d9;
        }

        .reg-card:hover h6 {
            color: #fff;
        }

        .reg-card:hover .icon-wrapper {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: scale(1.1);
        }

        .reg-card h6 {
            font-size: 14px;
            margin-top: 10px;
            color: #333;
            transition: color 0.3s ease;
        }

        .text-primary {
            color: #0095d9 !important;
        }
    </style>
</head>

<body>
    <!-- <div id="particle-container">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div> -->
    <canvas id="bg"></canvas>
    <div class="login-wrapper">
        <div class="card login-card">
            <div class="row g-0">

                <!-- Left Illustration -->
                <div class="col-md-6 illustration d-none d-md-flex">
                    <img src="{{ asset('backend/assets/img/login.webp') }}" alt="OurLabz Login Illustration">
                </div>

                <!-- Right Form -->
                <div class="col-md-6 login-form bg-white">
                    <div class="brand-name"><img src="{{asset('assets/img/logo/logo.png')}}" alt="logo" height="100"></div>
                    <h2>Login to Your Account</h2>
                    <span class="role-badge">Labs | Doctors | Corporate | Vendors</span>

                    @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">
                                <i class="fa-solid fa-user text-primary me-2"></i> Username
                            </label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" value="{{ old('username') }}" required>
                            @error('username')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fa-solid fa-lock text-primary me-2"></i> Password
                            </label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label small" for="remember_me">Remember me</label>
                            </div>
                            <a href="#" class="text-decoration-none small text-primary">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-login w-100 py-2 fw-semibold">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Log In
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            Need an account?
                            <a href="javascript:void(0);" id="openRegisterModal" class="text-primary fw-semibold">
                                Click Here
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>© {{ date('Y') }} <a href="{{url('/')}}" class="text-white">OurLabz</a>. All rights reserved.</footer>

    <!-- ===== Modal ===== -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content reg-modal-content p-4 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title w-100 text-center fw-bold" id="registerModalLabel">
                        Choose Your Registration Type
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row g-4 justify-content-center">
                        <!-- Lab -->
                        <div class="col-6 col-md-3">
                            <div class="reg-card" data-type="Lab">
                                <div class="icon-wrapper bg-primary bg-opacity-10">
                                    <i class="fas fa-vials text-white"></i>
                                </div>
                                <h6>Lab</h6>
                            </div>
                        </div>
                        <!-- Doctor -->
                        <div class="col-6 col-md-3">
                            <div class="reg-card" data-type="Doctor">
                                <div class="icon-wrapper bg-success bg-opacity-10">
                                    <i class="fas fa-user-md text-white"></i>
                                </div>
                                <h6>Doctor</h6>
                            </div>
                        </div>
                        <!-- Corporate -->
                        <div class="col-6 col-md-3">
                            <div class="reg-card" data-type="Corporate">
                                <div class="icon-wrapper bg-warning bg-opacity-10">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <h6>Corporate</h6>
                            </div>
                        </div>
                        <!-- Vendor -->
                        <div class="col-6 col-md-3">
                            <div class="reg-card" data-type="Vendor">
                                <div class="icon-wrapper bg-info bg-opacity-10">
                                    <i class="fas fa-store text-white"></i>
                                </div>
                                <h6>Vendor</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const container = document.getElementById('particle-container');
        document.addEventListener('mousemove', (e) => {
            const particles = container.querySelectorAll('.particle');
            particles.forEach((p, i) => {
                const speed = 0.02 * (i + 1);
                const x = (window.innerWidth / 2 - e.pageX) * speed;
                const y = (window.innerHeight / 2 - e.pageY) * speed;
                p.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    </script>
    <script>
        // ====== Config ======
        const CONFIG = {
            baseDensity: 0.12, // particule per 10,000 px^2 (se scalează cu dimensiunea ecranului)
            maxSpeed: 0.6, // px / frame
            radius: [2.5, 5.0], // min, max radius
            linkDist: 110, // distanța maximă pentru a desena linie între particule
            linkAlpha: 0.16, // opacitatea de bază a liniilor
            mouseInfluence: 110, // rază de influență la mouse
            repelStrength: 0.35, // cât de puternic e efectul de respingere
            attractStrength: 0.2, // alternativ: setat pozitiv pentru atracție
            clickBurst: 120, // impuls la click
            colorParticle: "#ffffff",
            colorLink: "#ffffff"
        };

        // ====== Setup canvas (DPR aware) ======
        const canvas = document.getElementById("bg");
        const ctx = canvas.getContext("2d", {
            alpha: true
        });
        let DPR = Math.max(1, Math.min(2, window.devicePixelRatio || 1)); // clamp pentru perf
        let W = 0,
            H = 0;

        function resize() {
            DPR = Math.max(1, Math.min(2, window.devicePixelRatio || 1));
            W = canvas.width = Math.floor(window.innerWidth * DPR);
            H = canvas.height = Math.floor(window.innerHeight * DPR);
            canvas.style.width = window.innerWidth + "px";
            canvas.style.height = window.innerHeight + "px";
            computeParticlesCount();
        }
        window.addEventListener("resize", resize, {
            passive: true
        });

        // ====== Particles ======
        let particles = [];
        let targetCount = 0;

        function rand(min, max) {
            return Math.random() * (max - min) + min;
        }

        function clamp(v, a, b) {
            return Math.max(a, Math.min(b, v));
        }

        class Particle {
            constructor() {
                this.reset(true);
            }
            reset(randomPos = false) {
                this.x = randomPos ? rand(0, W) : Math.random() < 0.5 ? 0 : W;
                this.y = randomPos ? rand(0, H) : rand(0, H);
                const ang = rand(0, Math.PI * 2);
                const speed = rand(0.05, CONFIG.maxSpeed);
                this.vx = Math.cos(ang) * speed;
                this.vy = Math.sin(ang) * speed;
                this.r = rand(CONFIG.radius[0], CONFIG.radius[1]) * DPR;
            }
            step(mx, my) {
                // Mouse influence (repel by default)
                if (mx !== null && my !== null) {
                    const dx = this.x - mx,
                        dy = this.y - my;
                    const d2 = dx * dx + dy * dy;
                    const r = CONFIG.mouseInfluence * DPR;
                    if (d2 < r * r) {
                        const d = Math.sqrt(d2) || 0.001;
                        const ux = dx / d,
                            uy = dy / d;
                        // Repel (positive), attract (negative)
                        const strength = CONFIG.repelStrength; // sau -CONFIG.attractStrength
                        this.vx += ux * strength * (1 - d / r);
                        this.vy += uy * strength * (1 - d / r);
                    }
                }

                // Velocity clamp
                const sp = Math.hypot(this.vx, this.vy);
                const maxSp = CONFIG.maxSpeed;
                if (sp > maxSp) {
                    this.vx *= maxSp / sp;
                    this.vy *= maxSp / sp;
                }

                // Move
                this.x += this.vx * DPR;
                this.y += this.vy * DPR;

                // Wrap around edges (spațiu infinit)
                if (this.x < -50) this.x = W + 50;
                if (this.x > W + 50) this.x = -50;
                if (this.y < -50) this.y = H + 50;
                if (this.y > H + 50) this.y = -50;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
                ctx.fillStyle = CONFIG.colorParticle;
                ctx.globalAlpha = 0.9;
                ctx.fill();
            }
        }

        function computeParticlesCount() {
            // scalează numărul în funcție de aria vizibilă
            const area = (W * H) / (DPR * DPR);
            const per10k = CONFIG.baseDensity; // per 10,000 px^2
            targetCount = Math.round(per10k * (area / 10000));
            // soft cap pentru mobile
            targetCount = clamp(targetCount, 40, 220);
            if (particles.length < targetCount) {
                const add = targetCount - particles.length;
                for (let i = 0; i < add; i++) particles.push(new Particle());
            } else if (particles.length > targetCount) {
                particles.length = targetCount;
            }
        }

        // ====== Mouse ======
        const mouse = {
            x: null,
            y: null,
            down: false
        };
        window.addEventListener(
            "mousemove",
            (e) => {
                mouse.x = e.clientX * DPR;
                mouse.y = e.clientY * DPR;
            }, {
                passive: true
            }
        );
        window.addEventListener("mouseleave", () => {
            mouse.x = mouse.y = null;
        });

        window.addEventListener("mousedown", () => {
            mouse.down = true;
        });
        window.addEventListener("mouseup", () => {
            mouse.down = false;
        });

        // click = mic „burst” de energie
        window.addEventListener("click", (e) => {
            const mx = e.clientX * DPR,
                my = e.clientY * DPR;
            for (let i = 0; i < particles.length; i++) {
                const p = particles[i];
                const dx = p.x - mx,
                    dy = p.y - my;
                const d2 = dx * dx + dy * dy;
                const r = CONFIG.mouseInfluence * DPR;
                if (d2 < r * r) {
                    const d = Math.sqrt(d2) || 0.001;
                    const ux = dx / d,
                        uy = dy / d;
                    p.vx += ux * (CONFIG.clickBurst / 100);
                    p.vy += uy * (CONFIG.clickBurst / 100);
                }
            }
        });

        // ====== Links between neighbors ======
        function drawLinks() {
            ctx.lineWidth = 3 * DPR;
            ctx.strokeStyle = CONFIG.colorLink;
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const a = particles[i],
                        b = particles[j];
                    const dx = a.x - b.x,
                        dy = a.y - b.y;
                    const dist = Math.hypot(dx, dy);
                    if (dist < CONFIG.linkDist * DPR) {
                        const alpha = CONFIG.linkAlpha * (1 - dist / (CONFIG.linkDist * DPR));
                        ctx.globalAlpha = alpha;
                        ctx.beginPath();
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.stroke();
                    }
                }
            }
            ctx.globalAlpha = 1;
        }

        // ====== Loop ======
        function loop() {
            ctx.clearRect(0, 0, W, H);

            // Step + draw
            for (let i = 0; i < particles.length; i++) {
                particles[i].step(mouse.x, mouse.y);
            }

            drawLinks();

            for (let i = 0; i < particles.length; i++) {
                particles[i].draw();
            }

            requestAnimationFrame(loop);
        }

        // Init
        resize();
        for (let i = 0; i < 120; i++) particles.push(new Particle()); // seed; va fi ajustat la resize
        computeParticlesCount();
        loop();
    </script>
    <script>
        document.getElementById("openRegisterModal").addEventListener("click", function() {
            const modal = new bootstrap.Modal(document.getElementById("registerModal"));
            modal.show();
        });

        // handle registration selection
        document.querySelectorAll(".reg-card").forEach((card) => {
            card.addEventListener("click", () => {
                const type = card.getAttribute("data-type").toLowerCase(); // 🔹 Convert to lowercase

                // Optional click animation
                card.classList.add("clicked");
                setTimeout(() => card.classList.remove("clicked"), 400);

                // Redirect based on type
                switch (type) {
                    case "lab":
                        window.location.href = "{{ route('lab.registration') }}";
                        break;
                    case "doctor":
                        window.location.href = "{{ route('doctor.registration') }}";
                        break;
                    case "corporate":
                        window.location.href = "{{ route('corporate.registration') }}";
                        break;
                    case "vendor":
                        window.location.href = "{{ route('vendor.registration') }}";
                        break;
                    default:
                        alert("Unknown registration type!");
                }
            });
        });
    </script>

</body>

</html>