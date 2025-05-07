{{-- resources/views/dashboard.blade.php --}}

{{-- Check if this line is causing the error --}}
<x-app-layout>
    {{-- ... --}}
</x-app-layout>

{{-- If the above line is not causing the error, try adding this line --}}
@php
    // Add some debug code here to see if it's executed
    echo 'Hello World!';
@endphp

{{-- If the above line is not causing the error, try wrapping your code in a section --}}
@section('content')
    {{-- ... --}}
@endsection{{-- resources/views/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <!-- Removed the old header for a cleaner look -->
    </x-slot>

    <style>
        /* Cosmic background styles */

        .cosmic-bg {
            margin: 0;

            padding: 0;

            background: radial-gradient(ellipse at bottom, #0a0e1a 0%, #050710 100%);

            min-height: 100vh;

            overflow: hidden;

            color: white;

            font-family: 'Nunito', sans-serif;

        }

        /* Remove white bar at the top */

        body, html {
            margin: 0;

            padding: 0;

            background: none;

        }

        .min-h-screen.bg-gray-100 {
            background: none !important;

            min-height: 0 !important;

        }

        header, .min-h-screen > header, .min-h-screen > nav {
            display: none !important;

        }
    </style>
{{-- resources/views/dashboard.blade.php --}}

<x-app-layout>
    <!-- ... -->
</x-app-layout>

{{-- Add this line at the very end of the file --}}
@endsection<x-app-layout>

    <x-slot name="header">
        <!-- Removed the old header for a cleaner look -->
    </x-slot>

    <style>
        /* Cosmic background styles */

        .cosmic-bg {
            margin: 0;

            padding: 0;

            background: radial-gradient(ellipse at bottom, #0a0e1a 0%, #050710 100%);

            min-height: 100vh;

            overflow: hidden;

            color: white;

            font-family: 'Nunito', sans-serif;

        }

        /* Remove white bar at the top */

        body, html {
            margin: 0;

            padding: 0;

            background: none;

        }

        .min-h-screen.bg-gray-100 {
            background: none !important;

            min-height: 0 !important;

        }

        header, .min-h-screen > header, .min-h-screen > nav {
            display: none !important;

        }
    </style> <!-- Add this closing tag -->
</x-app-layout>
    {{-- Add this section to wrap your content --}}
    @section('content')
        {{-- Your content goes here --}}
    @endsection
</x-app-layout><x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
