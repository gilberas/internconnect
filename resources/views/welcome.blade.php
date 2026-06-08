<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tanzania's most trusted internship management platform — connecting graduates with verified organisations.">
    <title>InternConnect — Tanzania's Premier Internship Platform</title>

    {{-- Fonts: Sora (display) + DM Sans (body) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=sora:600,700,800|dm-sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ═══ Global ═══════════════════════════════════════════════════════ */
        :root {
            --ics-dark:    #060D1F;
            --ics-dark-2:  #0D1A35;
            --ics-dark-3:  #112040;
            --ics-blue:    #2563EB;
            --ics-blue-2:  #1D4ED8;
            --ics-cyan:    #06B6D4;
            --ics-gold:    #F59E0B;
            --ics-text:    #F1F5F9;
            --ics-muted:   #94A3B8;
            --ics-border:  rgba(255,255,255,0.08);
        }
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, h4, .font-display { font-family: 'Sora', sans-serif; }

        /* ═══ Keyframes ═════════════════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(40px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity:0; } to { opacity:1; }
        }
        @keyframes floatA {
            0%,100% { transform: translateY(0px) rotate(0deg); }
            50%      { transform: translateY(-18px) rotate(1deg); }
        }
        @keyframes floatB {
            0%,100% { transform: translateY(0px) rotate(0deg); }
            50%      { transform: translateY(-12px) rotate(-1.5deg); }
        }
        @keyframes floatC {
            0%,100% { transform: translateY(0px); }
            33%      { transform: translateY(-8px); }
            66%      { transform: translateY(6px); }
        }
        @keyframes pulse-ring {
            0%   { transform:scale(1);   opacity:1; }
            100% { transform:scale(2.2); opacity:0; }
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes marqueeScroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position:  200% 0; }
        }
        @keyframes blob {
            0%,100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50%      { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        @keyframes slideDown {
            from { opacity:0; transform:translateY(-10px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ═══ Hero ══════════════════════════════════════════════════════════ */
        .hero-bg {
            background-color: var(--ics-dark);
            background-image:
                radial-gradient(ellipse 80% 60% at 15% 40%, rgba(37,99,235,0.20) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 85% 15%, rgba(6,182,212,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 70% 80%, rgba(37,99,235,0.08) 0%, transparent 60%);
        }
        .hero-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .hero-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        }

        /* ═══ Hero text animations ═══════════════════════════════════════════ */
        .hero-badge    { animation: fadeUp 0.6s ease both 0.1s; }
        .hero-h1       { animation: fadeUp 0.7s ease both 0.25s; }
        .hero-sub      { animation: fadeUp 0.7s ease both 0.4s; }
        .hero-ctas     { animation: fadeUp 0.7s ease both 0.55s; }
        .hero-trust    { animation: fadeUp 0.7s ease both 0.7s; }
        .hero-cards    { animation: fadeIn 1s ease both 0.9s; }

        /* ═══ Gradient text ═══════════════════════════════════════════════════ */
        .gradient-text {
            background: linear-gradient(135deg, #60A5FA 0%, #06B6D4 40%, #A78BFA 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 5s linear infinite;
        }
        .gradient-text-gold {
            background: linear-gradient(135deg, #F59E0B 0%, #FCD34D 50%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ═══ Cards ═══════════════════════════════════════════════════════════ */
        .glass-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .float-a { animation: floatA 6s ease-in-out infinite; }
        .float-b { animation: floatB 8s ease-in-out infinite 1s; }
        .float-c { animation: floatC 7s ease-in-out infinite 2s; }

        /* ═══ Pulse dot ═══════════════════════════════════════════════════════ */
        .pulse-dot {
            position: relative;
            display: inline-flex;
        }
        .pulse-dot::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: currentColor;
            animation: pulse-ring 1.5s ease-out infinite;
        }

        /* ═══ Scroll reveal ═══════════════════════════════════════════════════ */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.65s cubic-bezier(0.16,1,0.3,1),
                        transform 0.65s cubic-bezier(0.16,1,0.3,1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }
        .reveal-delay-5 { transition-delay: 0.5s; }

        /* ═══ Marquee ═══════════════════════════════════════════════════════ */
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeScroll 24s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }

        /* ═══ Feature card ═══════════════════════════════════════════════════ */
        .feature-card {
            transition: transform 0.3s cubic-bezier(0.16,1,0.3,1),
                        box-shadow 0.3s cubic-bezier(0.16,1,0.3,1);
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(37,99,235,0.12), 0 4px 16px rgba(0,0,0,0.08);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-3deg);
            transition: transform 0.3s cubic-bezier(0.16,1,0.3,1);
        }
        .feature-icon { transition: transform 0.3s ease; }

        /* ═══ Step connector ═════════════════════════════════════════════════ */
        .step-line {
            position: absolute;
            top: 28px; left: 50%;
            width: 100%; height: 2px;
            background: linear-gradient(90deg, #2563EB, rgba(37,99,235,0.1));
            transform-origin: left;
        }

        /* ═══ Nav ═══════════════════════════════════════════════════════════ */
        .nav-scrolled {
            background: rgba(6,13,31,0.96) !important;
            backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
        }

        /* ═══ Testimonial ═══════════════════════════════════════════════════ */
        .testimonial-slide {
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        /* ═══ Internship card shimmer ═══════════════════════════════════════ */
        .skeleton {
            background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.10) 37%, rgba(255,255,255,0.05) 63%);
            background-size: 400% 100%;
            animation: shimmer 1.4s ease infinite;
        }

        /* ═══ Blob bg ═══════════════════════════════════════════════════════ */
        .blob {
            animation: blob 8s ease-in-out infinite;
            filter: blur(60px);
        }

        /* ═══ Button ═════════════════════════════════════════════════════════ */
        .btn-primary {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            box-shadow: 0 4px 20px rgba(37,99,235,0.4), inset 0 1px 0 rgba(255,255,255,0.15);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            box-shadow: 0 6px 28px rgba(37,99,235,0.5), inset 0 1px 0 rgba(255,255,255,0.15);
            transform: translateY(-1px);
        }
        .btn-outline {
            border: 1.5px solid rgba(255,255,255,0.25);
            transition: all 0.2s ease;
        }
        .btn-outline:hover {
            border-color: rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.08);
            transform: translateY(-1px);
        }

        /* ═══ Mobile menu ═══════════════════════════════════════════════════ */
        .mobile-menu { animation: slideDown 0.2s ease both; }
    </style>
</head>

{{-- ══════════════════════════════════════════════════════════════════════════
     BODY — Alpine root: tracks scroll position
══════════════════════════════════════════════════════════════════════════ --}}
<body class="antialiased overflow-x-hidden"
      x-data="{ scrolled: false, mobileOpen: false }"
      @scroll.window="scrolled = (window.scrollY > 40)">

{{-- ══════════════════════════════════════════════════════════════════════════
     ① NAVIGATION
══════════════════════════════════════════════════════════════════════════ --}}
<nav class="fixed top-0 w-full z-50 transition-all duration-300"
     :class="scrolled ? 'nav-scrolled' : 'bg-transparent'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-18">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="relative">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="absolute -inset-0.5 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 opacity-0 group-hover:opacity-30 blur transition-opacity"></div>
                </div>
                <span class="text-base font-display font-700 text-white tracking-tight">InternConnect</span>
            </a>

            {{-- Desktop Links --}}
            <div class="hidden lg:flex items-center gap-7 text-sm font-medium text-slate-300">
                <a href="#how-it-works" class="hover:text-white transition-colors relative group">
                    How It Works
                    <span class="absolute -bottom-0.5 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#features" class="hover:text-white transition-colors relative group">
                    Features
                    <span class="absolute -bottom-0.5 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#for-companies" class="hover:text-white transition-colors relative group">
                    For Companies
                    <span class="absolute -bottom-0.5 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contact" class="hover:text-white transition-colors relative group">
                    Contact
                    <span class="absolute -bottom-0.5 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="btn-primary inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-slate-300 hover:text-white transition-colors px-4 py-2.5 rounded-xl hover:bg-white/5">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn-primary inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl">
                        Get Started Free
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                @endauth
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden w-9 h-9 flex flex-col items-center justify-center gap-1.5 text-white">
                <span class="w-5 h-px bg-current transition-all" :class="mobileOpen ? 'rotate-45 translate-y-2' : ''"></span>
                <span class="w-5 h-px bg-current transition-opacity" :class="mobileOpen ? 'opacity-0' : ''"></span>
                <span class="w-5 h-px bg-current transition-all" :class="mobileOpen ? '-rotate-45 -translate-y-2' : ''"></span>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" class="mobile-menu lg:hidden bg-slate-900/98 backdrop-blur-xl border-t border-white/8 px-4 py-5 space-y-1">
        @foreach(['#how-it-works' => 'How It Works', '#features' => 'Features', '#for-companies' => 'For Companies', '#contact' => 'Contact'] as $href => $label)
        <a href="{{ $href }}" @click="mobileOpen=false"
           class="flex items-center text-slate-300 hover:text-white text-sm font-medium py-3 border-b border-white/5">
            {{ $label }}
        </a>
        @endforeach
        <div class="pt-4 flex flex-col gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary text-center text-white text-sm font-semibold py-3 rounded-xl">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-center text-slate-300 text-sm font-medium py-3 rounded-xl border border-white/15">Sign In</a>
                <a href="{{ route('register') }}" class="btn-primary text-center text-white text-sm font-semibold py-3 rounded-xl">Get Started Free</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════════════════════════════════════
     ② HERO
══════════════════════════════════════════════════════════════════════════ --}}
<section class="relative hero-bg overflow-hidden min-h-screen flex items-center pt-16">

    {{-- Grid overlay --}}
    <div class="absolute inset-0 hero-grid opacity-60 pointer-events-none"></div>
    <div class="absolute inset-0 hero-noise pointer-events-none"></div>

    {{-- Animated blobs --}}
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blob pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/3 w-64 h-64 bg-cyan-600/8 rounded-full blob pointer-events-none" style="animation-delay:3s"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left: Text --}}
            <div class="text-center lg:text-left">

                {{-- Badge --}}
                <div class="hero-badge inline-flex items-center gap-2 bg-blue-500/10 border border-blue-400/25 text-blue-300 rounded-full px-4 py-1.5 text-xs font-semibold mb-8 backdrop-blur-sm">
                    <span class="pulse-dot w-2 h-2 rounded-full bg-blue-400 text-blue-400 flex-shrink-0"></span>
                    🇹🇿 Tanzania's #1 Internship Platform
                </div>

                {{-- Headline --}}
                <h1 class="hero-h1 font-display text-5xl sm:text-6xl lg:text-6xl xl:text-7xl font-800 text-white leading-[1.05] tracking-tight mb-6">
                    Find Your<br>
                    <span class="gradient-text">Perfect</span>
                    <br>Internship.
                </h1>

                {{-- Sub --}}
                <p class="hero-sub text-slate-400 text-lg leading-relaxed mb-10 max-w-md mx-auto lg:mx-0">
                    Connecting Tanzania's brightest graduates with verified organisations.
                    Apply, track, and land your dream placement — all in one place.
                </p>

                {{-- CTAs --}}
                <div class="hero-ctas flex flex-col sm:flex-row gap-3 justify-center lg:justify-start mb-12">
                    <a href="{{ route('register') }}"
                       class="btn-primary inline-flex items-center justify-center gap-2 text-white font-semibold px-7 py-4 rounded-2xl text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Find Internships
                    </a>
                    <a href="{{ route('register') }}?type=company"
                       class="btn-outline inline-flex items-center justify-center gap-2 text-white font-semibold px-7 py-4 rounded-2xl text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Post Internships
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="hero-trust flex flex-wrap items-center gap-6 justify-center lg:justify-start text-xs text-slate-500">
                    @foreach(['500+ Graduates Placed', '120+ Verified Companies', 'Free to Register'] as $t)
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $t }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Floating UI Mockups --}}
            <div class="hero-cards relative hidden lg:block h-[520px]">

                {{-- Main internship card --}}
                <div class="float-a absolute top-6 right-8 w-80 glass-card rounded-2xl p-5 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white text-sm font-semibold leading-tight">Software Developer Intern</p>
                                <p class="text-slate-400 text-xs">TechCorp Tanzania · DSM</p>
                            </div>
                        </div>
                        <span class="text-xs bg-emerald-500/15 text-emerald-400 border border-emerald-400/20 px-2 py-0.5 rounded-full">Open</span>
                    </div>
                    <div class="flex gap-2 mb-4">
                        <span class="bg-blue-500/15 text-blue-400 border border-blue-400/20 text-xs px-2.5 py-0.5 rounded-full">ICT</span>
                        <span class="bg-white/5 text-slate-400 border border-white/10 text-xs px-2.5 py-0.5 rounded-full">Full-time</span>
                        <span class="bg-white/5 text-slate-400 border border-white/10 text-xs px-2.5 py-0.5 rounded-full">3 months</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            @foreach(['#60A5FA','#34D399','#F472B6','#FBBF24'] as $c)
                            <div class="w-6 h-6 rounded-full border border-slate-800 flex items-center justify-center text-xs font-bold text-white"
                                 style="background:{{ $c }}">
                            </div>
                            @endforeach
                            <div class="w-6 h-6 rounded-full bg-white/10 border border-slate-800 flex items-center justify-center text-xs text-slate-400">+8</div>
                        </div>
                        <button class="btn-primary text-white text-xs font-semibold px-3.5 py-1.5 rounded-lg">Apply Now</button>
                    </div>
                </div>

                {{-- Stats widget --}}
                <div class="float-b absolute top-52 left-0 w-52 glass-card rounded-2xl p-4 shadow-2xl">
                    <p class="text-slate-400 text-xs font-medium mb-3">This Week</p>
                    <div class="space-y-3">
                        @foreach([['New Listings','24','text-blue-400'],['Applications','156','text-purple-400'],['Hired','12','text-emerald-400']] as [$l,$v,$c])
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-xs">{{ $l }}</span>
                            <span class="font-display font-700 text-sm {{ $c }}">{{ $v }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/5">
                        <div class="flex gap-1">
                            @foreach([40,65,45,80,55,90,70] as $h)
                            <div class="flex-1 bg-blue-500/30 rounded-sm" style="height:{{ $h/4 }}px"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Notification card --}}
                <div class="float-c absolute bottom-16 right-6 w-72 glass-card rounded-xl px-4 py-3 shadow-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-xs font-semibold">Interview Scheduled! 🎉</p>
                            <p class="text-slate-400 text-xs">Vodacom Tanzania — Tomorrow, 10:00 AM</p>
                        </div>
                    </div>
                </div>

                {{-- Verified badge --}}
                <div class="float-a absolute bottom-36 left-12 glass-card rounded-xl px-3 py-2 shadow-xl"
                     style="animation-delay:2s;">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-white text-xs font-medium">BRELA Verified</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-16 md:h-20">
            <path fill="#F8FAFC" d="M0,80 L1440,80 L1440,20 C1080,72 720,0 360,52 C240,64 120,72 0,40 Z"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ③ MARQUEE — Trusted by
══════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-slate-50 py-10 border-b border-slate-100 overflow-hidden">
    <p class="text-center text-xs font-semibold text-slate-400 uppercase tracking-widest mb-6">
        Trusted by graduates from
    </p>
    <div class="relative">
        <div class="marquee-track gap-12 items-center">
            @php
            $unis = ['University of Dar es Salaam','Muhimbili University','Sokoine University','UDSM','Nelson Mandela African Institute','Ardhi University','Open University of Tanzania','IFM','SJUT','Mzumbe University'];
            @endphp
            @foreach(array_merge($unis, $unis) as $uni)
            <div class="flex-shrink-0 px-8 py-2 rounded-full bg-white border border-slate-200 shadow-sm">
                <span class="text-sm font-medium text-slate-500 whitespace-nowrap">{{ $uni }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ④ STATS
══════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20" id="stats">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6"
             x-data="{
                stats: [
                    { target:500,  suffix:'+', label:'Graduates Placed',   color:'text-blue-600',   icon:'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z' },
                    { target:120,  suffix:'+', label:'Verified Companies', color:'text-emerald-600', icon:'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z' },
                    { target:1200, suffix:'+', label:'Internships Posted', color:'text-indigo-600',  icon:'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
                    { target:98,   suffix:'%', label:'Satisfaction Rate',  color:'text-amber-600',  icon:'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' },
                ],
                counts: [0,0,0,0],
                started: false,
                start() {
                    if (this.started) return;
                    this.started = true;
                    this.stats.forEach((s,i) => {
                        const dur = 1800 + i * 200;
                        const begin = performance.now();
                        const ease = t => 1 - Math.pow(1-t, 4);
                        const tick = (now) => {
                            const p = Math.min((now-begin)/dur, 1);
                            this.counts[i] = Math.round(ease(p) * s.target);
                            if (p < 1) requestAnimationFrame(tick);
                        };
                        requestAnimationFrame(tick);
                    });
                }
             }"
             x-intersect.once="start()">
            <template x-for="(s, i) in stats" :key="i">
                <div class="reveal feature-card bg-white border border-slate-100 rounded-2xl p-7 text-center shadow-sm cursor-default">
                    <div class="w-12 h-12 mx-auto rounded-2xl mb-4 flex items-center justify-center"
                         :class="[
                           i===0 ? 'bg-blue-50'   : '',
                           i===1 ? 'bg-emerald-50' : '',
                           i===2 ? 'bg-indigo-50'  : '',
                           i===3 ? 'bg-amber-50'   : '',
                         ]">
                        <svg class="w-6 h-6" :class="s.color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="s.icon"/>
                        </svg>
                    </div>
                    <p class="font-display text-4xl font-800 mb-1" :class="s.color">
                        <span x-text="counts[i].toLocaleString()"></span><span x-text="s.suffix"></span>
                    </p>
                    <p class="text-sm text-slate-500 font-medium" x-text="s.label"></p>
                </div>
            </template>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑤ HOW IT WORKS
══════════════════════════════════════════════════════════════════════════ --}}
<section id="how-it-works" class="bg-slate-50 py-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         x-data="{ tab: 'student' }">

        {{-- Section header --}}
        <div class="text-center mb-14 reveal">
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 border border-blue-100">
                How It Works
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-700 text-slate-900 leading-tight">
                Simple process,<br><span class="text-blue-600">big results.</span>
            </h2>
            <p class="text-slate-500 mt-4 max-w-lg mx-auto leading-relaxed">
                Get from sign-up to placement in just a few steps — whether you're a student or an organisation.
            </p>
        </div>

        {{-- Tab Toggle --}}
        <div class="flex justify-center mb-14 reveal reveal-delay-1">
            <div class="inline-flex bg-white border border-slate-200 rounded-2xl p-1.5 shadow-sm gap-1">
                <button @click="tab='student'"
                        :class="tab==='student' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-500 hover:text-slate-700'"
                        class="px-7 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    For Students
                </button>
                <button @click="tab='company'"
                        :class="tab==='company' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-500 hover:text-slate-700'"
                        class="px-7 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    For Companies
                </button>
            </div>
        </div>

        {{-- Steps: Student --}}
        <div x-show="tab==='student'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $studentSteps = [
                    ['01','Create Your Profile','Upload your CV, add your skills, and build a profile that stands out to employers.','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','blue'],
                    ['02','Discover Listings','Search hundreds of verified internships filtered by category, location, and type.','M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z','indigo'],
                    ['03','Apply Online','Submit your application with your CV and cover letter in under 2 minutes.','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','purple'],
                    ['04','Get Hired','Track your applications, attend interviews, and accept your offer.','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','emerald'],
                ];
                @endphp
                @foreach($studentSteps as $idx => [$num, $title, $desc, $icon, $color])
                <div class="relative">
                    @if($idx < 3)
                    <div class="hidden lg:block absolute top-10 left-full w-full h-px z-0"
                         style="background:linear-gradient(90deg,rgba(37,99,235,0.4),rgba(37,99,235,0.05));margin-left:0px;width:calc(100% - 80px);left:80px;"></div>
                    @endif
                    <div class="relative z-10 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-100 transition-all group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-{{ $color }}-50 border border-{{ $color }}-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                                </svg>
                            </div>
                            <span class="font-display text-3xl font-800 text-{{ $color }}-100 select-none">{{ $num }}</span>
                        </div>
                        <h3 class="font-display text-base font-700 text-slate-900 mb-2">{{ $title }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Steps: Company --}}
        <div x-show="tab==='company'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $companySteps = [
                    ['01','Register & Submit Docs','Sign up and upload your BRELA certificate and company documents for verification.','M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','amber'],
                    ['02','Get Verified','Our admin team reviews your documents. Approval typically takes 24 hours.','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','blue'],
                    ['03','Post Internships','Create internship listings with role details, requirements, and deadlines.','M12 6v6m0 0v6m0-6h6m-6 0H6','indigo'],
                    ['04','Hire Top Talent','Review applications, schedule interviews, and select your ideal intern.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z','emerald'],
                ];
                @endphp
                @foreach($companySteps as $idx => [$num, $title, $desc, $icon, $color])
                <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-100 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-{{ $color }}-50 border border-{{ $color }}-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                            </svg>
                        </div>
                        <span class="font-display text-3xl font-800 text-{{ $color }}-100 select-none">{{ $num }}</span>
                    </div>
                    <h3 class="font-display text-base font-700 text-slate-900 mb-2">{{ $title }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑥ FEATURES
══════════════════════════════════════════════════════════════════════════ --}}
<section id="features" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 border border-indigo-100">
                Platform Features
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-700 text-slate-900 leading-tight">
                Everything you need<br>to succeed.
            </h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $features = [
                ['Verified Organisations Only', 'Every company undergoes BRELA document review before posting. No fraudulent listings, ever.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'from-emerald-400 to-teal-500', 'bg-emerald-50'],
                ['Full Application Tracking', 'Watch every step of your application from submission to acceptance with real-time status updates.', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'from-blue-400 to-blue-600', 'bg-blue-50'],
                ['Smart Interview Scheduling', 'Physical, online, or phone interviews with automated notifications and one-click rescheduling.', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'from-purple-400 to-purple-600', 'bg-purple-50'],
                ['Secure Document Vault', 'CVs and company documents stored outside the web root, accessible only via time-limited signed URLs.', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'from-amber-400 to-orange-500', 'bg-amber-50'],
                ['Real-Time Notifications', 'In-app and email alerts for every key event — from application updates to interview invitations.', 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'from-rose-400 to-pink-500', 'bg-rose-50'],
                ['Admin Analytics & Reports', 'Powerful dashboards with exportable PDF and Excel reports on students, companies, and placements.', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'from-cyan-400 to-blue-500', 'bg-cyan-50'],
            ];
            @endphp
            @foreach($features as $i => [$title, $desc, $icon, $grad, $bg])
            <div class="feature-card reveal reveal-delay-{{ ($i % 3) + 1 }} {{ $bg }} rounded-2xl p-7 border border-slate-100/80 cursor-default">
                <div class="feature-icon w-12 h-12 rounded-xl bg-gradient-to-br {{ $grad }} flex items-center justify-center mb-5 shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                    </svg>
                </div>
                <h3 class="font-display text-base font-700 text-slate-900 mb-2">{{ $title }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑦ TESTIMONIALS
══════════════════════════════════════════════════════════════════════════ --}}
<section class="py-24 hero-bg relative overflow-hidden">
    <div class="absolute inset-0 hero-grid opacity-40"></div>
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 reveal">
            <span class="inline-block bg-white/10 text-blue-300 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 border border-white/15">
                Success Stories
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-700 text-white leading-tight">
                Real results,<br><span class="gradient-text">real graduates.</span>
            </h2>
        </div>

        <div x-data="{
                current: 0,
                testimonials: [
                    { name: 'Amina Rashid', role: 'Software Developer Intern', company: 'TechCorp Tanzania', uni: 'University of Dar es Salaam', quote: 'InternConnect made finding a verified, quality internship incredibly easy. I applied to 3 positions and landed my dream role within two weeks. The tracking system kept me informed at every step.' },
                    { name: 'Brian Mwamba', role: 'Finance Intern', company: 'CRDB Bank', uni: 'Institute of Finance Management', quote: 'As a finance student, I was overwhelmed by fake listings on other platforms. InternConnect only shows verified companies, which gave me complete confidence. I start my internship next month!' },
                    { name: 'Zawadi Kiungo', role: 'Marketing Intern', company: 'Vodacom Tanzania', uni: 'Mzumbe University', quote: 'The interview scheduling feature is a game-changer. I got notified instantly when Vodacom booked my interview slot, and all the details were right there in the app. Absolutely seamless experience.' },
                ],
                next() { this.current = (this.current + 1) % this.testimonials.length; },
                prev() { this.current = (this.current - 1 + this.testimonials.length) % this.testimonials.length; },
                init() { setInterval(() => this.next(), 5000); }
             }">

            <div class="glass-card rounded-3xl p-8 md:p-12 relative min-h-64">
                {{-- Quote icon --}}
                <svg class="absolute top-8 right-8 w-12 h-12 text-white/5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>

                <template x-for="(t, i) in testimonials" :key="i">
                    <div x-show="current === i"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        <p class="text-slate-200 text-lg md:text-xl leading-relaxed mb-8 italic" x-text='"&ldquo;" + t.quote + "&rdquo;"'></p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-display font-700 text-lg flex-shrink-0"
                                 x-text="t.name.charAt(0)"></div>
                            <div>
                                <p class="text-white font-semibold text-sm" x-text="t.name"></p>
                                <p class="text-slate-400 text-xs" x-text="t.role + ' · ' + t.company"></p>
                                <p class="text-slate-500 text-xs" x-text="t.uni"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Navigation --}}
            <div class="flex items-center justify-center gap-5 mt-8">
                <button @click="prev()"
                        class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-white hover:bg-white/15 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <div class="flex gap-2">
                    <template x-for="(t, i) in testimonials" :key="i">
                        <button @click="current = i"
                                class="rounded-full transition-all duration-300"
                                :class="current === i ? 'w-6 h-2.5 bg-blue-400' : 'w-2.5 h-2.5 bg-white/25 hover:bg-white/40'">
                        </button>
                    </template>
                </div>
                <button @click="next()"
                        class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-white hover:bg-white/15 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑧ FOR COMPANIES
══════════════════════════════════════════════════════════════════════════ --}}
<section id="for-companies" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left --}}
            <div class="reveal">
                <span class="inline-block bg-emerald-50 text-emerald-600 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-5 border border-emerald-100">
                    For Organisations
                </span>
                <h2 class="font-display text-4xl md:text-5xl font-700 text-slate-900 leading-tight mb-6">
                    Find Tanzania's<br><span class="text-emerald-600">brightest interns</span><br>effortlessly.
                </h2>
                <p class="text-slate-500 leading-relaxed mb-8">
                    Post verified internship listings, manage applications end-to-end, and schedule interviews — all from one powerful dashboard. Only verified companies can post, ensuring mutual trust.
                </p>
                <div class="space-y-4 mb-10">
                    @foreach(['Simple BRELA-based verification process (24hr)','Full applicant management with CV viewer','Automated interview scheduling & notifications','Real-time analytics on your postings'] as $benefit)
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-slate-600 text-sm">{{ $benefit }}</p>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('register') }}?type=company"
                   class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold px-7 py-4 rounded-2xl text-sm transition-all hover:-translate-y-0.5 shadow-lg shadow-slate-900/20">
                    Register Your Company
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            {{-- Right: Company Dashboard Mockup --}}
            <div class="reveal reveal-delay-2 relative">
                <div class="bg-slate-900 rounded-3xl p-1 shadow-2xl shadow-slate-900/30">
                    {{-- Fake browser bar --}}
                    <div class="bg-slate-800 rounded-t-2xl px-4 py-3 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-500/60"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/60"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/60"></div>
                        </div>
                        <div class="flex-1 bg-slate-700/50 rounded-md px-3 py-1 text-xs text-slate-400 font-mono text-center">
                            internconnect.co.tz/company/dashboard
                        </div>
                    </div>
                    {{-- Fake dashboard --}}
                    <div class="bg-slate-950 rounded-b-2xl p-5 space-y-4">
                        {{-- Mini stats --}}
                        <div class="grid grid-cols-3 gap-3">
                            @foreach([['Active Listings','3','text-blue-400'],['Applicants','24','text-purple-400'],['Interviews','6','text-emerald-400']] as [$l,$v,$c])
                            <div class="bg-slate-900 rounded-xl p-3 text-center border border-white/5">
                                <p class="font-display text-xl font-700 {{ $c }}">{{ $v }}</p>
                                <p class="text-slate-500 text-xs mt-0.5">{{ $l }}</p>
                            </div>
                            @endforeach
                        </div>
                        {{-- Fake table --}}
                        <div class="bg-slate-900 rounded-xl border border-white/5 overflow-hidden">
                            <div class="px-4 py-3 border-b border-white/5 flex justify-between items-center">
                                <p class="text-white text-xs font-semibold">Recent Applicants</p>
                                <span class="text-xs text-blue-400">View all →</span>
                            </div>
                            @foreach([['Amina R.','Software Intern','Shortlisted'],['Brian M.','Finance Intern','Under Review'],['Zawadi K.','Marketing Intern','Submitted']] as [$name,$role,$status])
                            <div class="px-4 py-3 flex items-center justify-between border-b border-white/5 last:border-0">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ substr($name,0,1) }}
                                    </div>
                                    <div>
                                        <p class="text-white text-xs font-medium">{{ $name }}</p>
                                        <p class="text-slate-500 text-xs">{{ $role }}</p>
                                    </div>
                                </div>
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $status=='Shortlisted' ? 'bg-purple-500/20 text-purple-400' : ($status=='Under Review' ? 'bg-blue-500/20 text-blue-400' : 'bg-slate-500/20 text-slate-400') }}">
                                    {{ $status }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- Decorative glow --}}
                <div class="absolute -bottom-8 -right-8 w-48 h-48 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑨ CTA
══════════════════════════════════════════════════════════════════════════ --}}
<section class="py-28 relative overflow-hidden" style="background:linear-gradient(135deg,#1E3A8A 0%,#1D4ED8 40%,#0EA5E9 100%);background-size:200% 200%;animation:gradientShift 8s ease infinite;">
    <div class="absolute inset-0 hero-grid opacity-20"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
        <h2 class="font-display text-4xl md:text-6xl font-800 text-white leading-tight mb-6">
            Ready to start your<br>internship journey?
        </h2>
        <p class="text-blue-100 text-lg mb-12 max-w-xl mx-auto leading-relaxed">
            Join thousands of Tanzanian graduates and verified organisations already using InternConnect.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-display font-700 px-8 py-4 rounded-2xl text-base hover:bg-blue-50 transition-all shadow-xl shadow-blue-900/30 hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                I'm a Student
            </a>
            <a href="{{ route('register') }}?type=company"
               class="inline-flex items-center justify-center gap-2 border-2 border-white/40 text-white font-display font-700 px-8 py-4 rounded-2xl text-base hover:bg-white/10 hover:border-white/70 transition-all hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                I'm an Organisation
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑩ CONTACT
══════════════════════════════════════════════════════════════════════════ --}}
<section id="contact" class="bg-slate-50 py-20 border-t border-slate-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
        <h2 class="font-display text-3xl font-700 text-slate-900 mb-3">Have questions?</h2>
        <p class="text-slate-500 mb-10">We're here to help. Reach us through any of the channels below.</p>
        <div class="grid sm:grid-cols-3 gap-5">
            @foreach([['Email','support@internconnect.co.tz','M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],['Phone','+255 XXX XXX XXX','M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],['Location','Dar es Salaam, Tanzania','M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z']] as [$label,$value,$icon])
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                    </svg>
                </div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">{{ $label }}</p>
                <p class="text-slate-700 text-sm font-medium">{{ $value }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     ⑪ FOOTER
══════════════════════════════════════════════════════════════════════════ --}}
<footer style="background:var(--ics-dark);" class="text-slate-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-5 gap-12 mb-12">
            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-display font-700 text-white text-lg">InternConnect</span>
                </div>
                <p class="text-sm leading-relaxed mb-6 max-w-xs">
                    Tanzania's most trusted internship management platform — bridging graduates with verified organisations since 2025.
                </p>
                {{-- Social icons --}}
                <div class="flex gap-3">
                    @foreach([['LinkedIn','M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],['Twitter','M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z']] as [$name,$path])
                    <a href="#" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/10 border border-white/8 flex items-center justify-center text-slate-400 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                        </svg>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Links --}}
            @foreach(['Students' => [['Find Internships',route('register')],['Create Account',route('register')],['Track Applications',route('login')],['Saved Listings',route('login')]], 'Companies' => [['Register Company',route('register').'?type=company'],['Post Internship',route('login')],['Manage Applicants',route('login')],['Schedule Interviews',route('login')]], 'Platform' => [['How It Works','#how-it-works'],['Features','#features'],['Contact','#contact'],['Privacy Policy','#'],['Terms of Use','#']]] as $group => $links)
            <div>
                <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-5">{{ $group }}</h4>
                <ul class="space-y-3">
                    @foreach($links as [$label, $href])
                    <li><a href="{{ $href }}" class="text-sm hover:text-white transition-colors hover:translate-x-0.5 inline-block transition-transform">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="border-t border-white/6 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-600">
            <p>&copy; {{ date('Y') }} InternConnect. All rights reserved. Built for Tanzania.</p>
            <p class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                All systems operational
            </p>
        </div>
    </div>
</footer>

{{-- ══════════════════════════════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Scroll reveal observer ────────────────────────────────────────
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => {
        revealObserver.observe(el);
    });

    // ── x-intersect polyfill for Alpine stat counters ─────────────────
    // Alpine's x-intersect plugin isn't guaranteed, so we wire up the
    // IntersectionObserver here and call the Alpine start() method.
    const statsSection = document.querySelector('#stats [x-data]');
    if (statsSection) {
        const statsObs = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                const component = statsSection._x_dataStack?.[0];
                if (component?.start) component.start();
                statsObs.disconnect();
            }
        }, { threshold: 0.3 });
        statsObs.observe(statsSection);
    }

    // ── Smooth anchor scrolling ────────────────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
</script>

</body>
</html>