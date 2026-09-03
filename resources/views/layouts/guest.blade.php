<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'InternConnect') }} — {{ $title ?? 'Authentication' }}</title>

        {{-- Fonts: Sora (display) + DM Sans (body) — matching landing page --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:600,700,800|dm-sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet"/>

        {{-- Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --ics-dark:    #060D1F;
                --ics-dark-2:  #0D1A35;
                --ics-blue:    #2563EB;
                --ics-blue-2:  #1D4ED8;
                --ics-cyan:    #06B6D4;
                --ics-text:    #F1F5F9;
                --ics-muted:   #94A3B8;
                --ics-border:  rgba(255,255,255,0.08);
            }
            body { font-family: 'DM Sans', sans-serif; }

            .auth-bg {
                background-color: var(--ics-dark);
                background-image:
                    radial-gradient(ellipse 70% 50% at 15% 30%, rgba(37,99,235,0.18) 0%, transparent 70%),
                    radial-gradient(ellipse 50% 40% at 85% 80%, rgba(6,182,212,0.10) 0%, transparent 60%);
            }

            .auth-grid {
                background-image:
                    linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
                background-size: 60px 60px;
            }

            .glass-card {
                background: rgba(255,255,255,0.07);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255,255,255,0.12);
            }

            .auth-input {
                background: rgba(255,255,255,0.06) !important;
                border: 1.5px solid rgba(255,255,255,0.12) !important;
                color: #F1F5F9 !important;
                border-radius: 0.75rem !important;
                font-size: 0.875rem !important;
                transition: all 0.2s ease !important;
            }
            .auth-input:focus {
                border-color: #2563EB !important;
                box-shadow: 0 0 0 3px rgba(37,99,235,0.2) !important;
                outline: none !important;
            }
            .auth-input::placeholder {
                color: #64748B !important;
            }
            .auth-input:-webkit-autofill,
            .auth-input:-webkit-autofill:hover,
            .auth-input:-webkit-autofill:focus {
                -webkit-text-fill-color: #F1F5F9 !important;
                -webkit-box-shadow: 0 0 0px 1000px rgba(6,13,31,0.95) inset !important;
                transition: background-color 5000s ease-in-out 0s !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="auth-bg relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden">
            <div class="absolute inset-0 auth-grid pointer-events-none opacity-60"></div>

            <div class="relative z-10 w-full sm:max-w-md px-4">
                {{-- Logo --}}
                <div class="flex justify-center mb-6">
                    <a href="/" class="flex items-center gap-2.5 group">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-5.5 h-5.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="22" height="22">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="absolute -inset-0.5 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 opacity-0 group-hover:opacity-30 blur transition-opacity"></div>
                        </div>
                        <span class="text-lg font-display font-700 text-white tracking-tight" style="font-family: 'Sora', sans-serif;">{{ config('app.name', 'InternConnect') }}</span>
                    </a>
                </div>

                {{-- Auth Card --}}
                <div class="glass-card rounded-2xl px-6 py-6 sm:px-8 sm:py-8 shadow-2xl">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <p class="mt-6 text-center text-xs text-slate-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'InternConnect') }}. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
