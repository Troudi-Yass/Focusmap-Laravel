<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Auth' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: radial-gradient(ellipse at bottom, #0a0e1a 0%, #050710 100%);
            overflow: hidden;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 120%;
            transform: rotate(-45deg);
            z-index: -1;
        }

        .star {
            --star-color: hsl(180, 100%, 85%);
            --star-tail-length: 8em;
            --star-tail-height: 1.5px;
            --star-width: calc(var(--star-tail-length) / 4);
            --fall-duration: 6s;
            --tail-fade-duration: var(--fall-duration);

            position: absolute;
            top: var(--top-offset);
            left: 0;
            width: var(--star-tail-length);
            height: var(--star-tail-height);
            background: linear-gradient(90deg, var(--star-color), transparent);
            border-radius: 50%;
            filter: drop-shadow(0 0 8px var(--star-color)) drop-shadow(0 0 15px var(--star-color));
            transform: translate3d(100vw, 0, 0);
            animation: fall var(--fall-duration) var(--fall-delay) linear infinite,
                       tail-fade var(--tail-fade-duration) var(--fall-delay) ease-out infinite;
            opacity: 0.9;
        }

        .stars-left, .stars-right {
            position: fixed;
            top: 0;
            height: 100%;
            width: 30%;
            z-index: -1;
        }

        .stars-left { left: 0; }
        .stars-right { right: 0; }

        @keyframes fall {
            to { transform: translate3d(-100vw, 0, 0); }
        }

        @keyframes tail-fade {
            0%, 50% { width: var(--star-tail-length); opacity: 0.9; }
            70%, 80% { width: 0; opacity: 0.5; }
            100% { width: 0; opacity: 0; }
        }

        @media (prefers-reduced-motion) {
            .star { animation: none; }
        }

        .auth-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            z-index: 1;
            position: relative;
        }

    </style>
</head>
<body>
    <!-- Stars -->
    <div class="stars">
        @for ($i = 0; $i < 15; $i++)
            <div class="star"></div>
        @endfor
    </div>
    <div class="stars stars-left">
        @for ($i = 0; $i < 8; $i++)
            <div class="star"></div>
        @endfor
    </div>
    <div class="stars stars-right">
        @for ($i = 0; $i < 8; $i++)
            <div class="star"></div>
        @endfor
    </div>

    <div class="auth-content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);

            stars.forEach((star) => {
                const tailLength = Math.random() * 4 + 3;
                const topOffset = Math.random() * 120 - 10;
                const fallDuration = Math.random() * 3 + 4;
                const fallDelay = Math.random() * -5;
                const hueVariation = Math.random() * 20 - 10;
                const saturation = 90 + Math.random() * 10;
                const lightness = 80 + Math.random() * 15;

                star.style.setProperty('--star-tail-length', `${tailLength}em`);
                star.style.setProperty('--top-offset', `${topOffset}%`);
                star.style.setProperty('--fall-duration', `${fallDuration}s`);
                star.style.setProperty('--fall-delay', `${fallDelay}s`);
                star.style.setProperty('--star-color', `hsl(${180 + hueVariation}, ${saturation}%, ${lightness}%)`);
            });
        });
    </script>
</body>
</html>
