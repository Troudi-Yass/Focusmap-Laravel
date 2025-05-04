<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FocusMap</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: radial-gradient(ellipse at bottom, #0a0e1a 0%, #050710 100%);
            overflow: hidden;
            height: 100vh;
            font-family: 'Nunito', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        /* Auth container */
        .auth-container {
            position: relative;
            z-index: 10;
            background: rgba(10, 14, 26, 0.8);
            padding: 2.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 20px rgba(0, 191, 255, 0.3);
            width: 100%;
            max-width: 28rem;
            backdrop-filter: blur(5px);
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: center;
            color: hsl(180, 100%, 85%);
        }

        .auth-subtitle {
            font-size: 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Form elements */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: hsl(180, 100%, 85%);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.25rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(5, 7, 16, 0.7);
            color: white;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: hsl(180, 100%, 60%);
            box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.1);
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }

        .auth-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .auth-link {
            font-size: 0.875rem;
            color: hsl(180, 100%, 85%);
            text-decoration: none;
            transition: color 0.2s;
        }

        .auth-link:hover {
            color: hsl(180, 100%, 60%);
            text-decoration: underline;
        }

        .submit-button {
            background-color: hsl(180, 100%, 40%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.25rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background-color: hsl(180, 100%, 30%);
        }

        .auth-switch {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .auth-switch a {
            color: hsl(180, 100%, 85%);
            text-decoration: none;
            margin-left: 0.25rem;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        /* Stars animation */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 120%;
            transform: rotate(-45deg);
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
            color: var(--star-color);
            background: linear-gradient(90deg, var(--star-color), transparent);
            border-radius: 50%;
            filter: drop-shadow(0 0 8px var(--star-color)) 
                   drop-shadow(0 0 15px var(--star-color));
            transform: translate3d(100vw, 0, 0);
            animation: fall var(--fall-duration) var(--fall-delay) linear infinite, 
                       tail-fade var(--tail-fade-duration) var(--fall-delay) ease-out infinite;
            opacity: 0.9;
            will-change: transform, opacity;
        }

        .stars-left, .stars-right {
            position: fixed;
            top: 0;
            height: 100%;
            width: 30%;
        }

        .stars-left {
            left: 0;
        }

        .stars-right {
            right: 0;
        }

        @keyframes fall {
            to {
                transform: translate3d(-100vw, 0, 0);
            }
        }

        @keyframes tail-fade {
            0%, 50% {
                width: var(--star-tail-length);
                opacity: 0.9;
            }
            70%, 80% {
                width: 0;
                opacity: 0.5;
            }
            100% {
                width: 0;
                opacity: 0;
            }
        }

        /* Error messages */
        .error-messages {
            margin-bottom: 1.5rem;
            color: #fca5a5;
            font-size: 0.875rem;
        }

        /* Password requirements */
        .password-requirements {
            margin-top: -0.75rem;
            margin-bottom: 1rem;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Fallback if the operating system prefers reduced motion */
        @media (prefers-reduced-motion) {
            .star {
                animation: none;
            }
        }
    </style>
</head>
<body>
    <!-- Stars background -->
    <div class="stars">
        <!-- Center stars -->
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <!-- Left side stars -->
    <div class="stars stars-left">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <!-- Right side stars -->
    <div class="stars stars-right">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <!-- Registration Form -->
    <div class="auth-container">
        <h1 class="auth-title">Welcome to FocusMap</h1>
        <p class="auth-subtitle">Create your account to get started</p>
        
        @if ($errors->any())
            <div class="error-messages">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
               
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required />
            </div>

            <div class="form-footer">
                <div class="auth-links">
                    @if (Route::has('login'))
                        <a class="auth-link" href="{{ route('login') }}">
                            Already have an account?
                        </a>
                    @endif
                </div>

                <button type="submit" class="submit-button">
                    Register
                </button>
            </div>
        </form>

    
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
            
            stars.forEach((star) => {
                // Random values
                const tailLength = Math.random() * 4 + 3; // 3-7em
                const topOffset = Math.random() * 120 - 10; // -10% to 110%
                const fallDuration = Math.random() * 3 + 4; // 4-7s (faster appearance)
                const fallDelay = Math.random() * -5; // Negative delay for immediate start
                const hueVariation = Math.random() * 20 - 10;
                const saturation = 90 + Math.random() * 10;
                const lightness = 80 + Math.random() * 15;
                
                // Apply values
                star.style.setProperty('--star-tail-length', `${tailLength}em`);
                star.style.setProperty('--top-offset', `${topOffset}%`);
                star.style.setProperty('--fall-duration', `${fallDuration}s`);
                star.style.setProperty('--fall-delay', `${fallDelay}s`);
                star.style.setProperty('--star-color', 
                    `hsl(${180 + hueVariation}, ${saturation}%, ${lightness}%)`);
            });
        });
    </script>
</body>
</html>