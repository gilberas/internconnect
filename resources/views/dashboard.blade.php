{{--
    ICS Role-Aware Dashboard Shell
    Phase 2/3/4/5 — Used as the base layout. The web.php route redirects
    each role to their specific dashboard. This view is the fallback.
--}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Dashboard') }}
            </h2>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                @if(auth()->user()->account_type === 'student')    bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                @elseif(auth()->user()->account_type === 'company') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                @else                                               bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300
                @endif">
                <span class="w-1.5 h-1.5 rounded-full
                    @if(auth()->user()->account_type === 'student')    bg-blue-500
                    @elseif(auth()->user()->account_type === 'company') bg-emerald-500
                    @else                                               bg-purple-500
                    @endif">
                </span>
                {{ ucfirst(auth()->user()->account_type) }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 mb-8 text-white shadow-lg">
                <h3 class="text-2xl font-bold mb-1">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h3>
                <p class="text-blue-100">
                    @if(auth()->user()->account_type === 'student')
                        Continue your internship journey — browse opportunities and track your applications.
                    @elseif(auth()->user()->account_type === 'company')
                        Manage your internship listings and review incoming applications.
                    @else
                        Monitor platform activity and manage verifications from your admin panel.
                    @endif
                </p>
                <div class="mt-5">
                    @if(auth()->user()->account_type === 'student')
                        <a href="{{ route('student.internships.index') }}"
                           class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold text-sm px-5 py-2.5 rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                            Browse Internships
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @elseif(auth()->user()->account_type === 'company')
                        <a href="{{ route('company.internships.create') }}"
                           class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold text-sm px-5 py-2.5 rounded-lg hover:bg-indigo-50 transition-colors shadow-sm">
                            Post an Internship
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('admin.companies.index') }}"
                           class="inline-flex items-center gap-2 bg-white text-purple-700 font-semibold text-sm px-5 py-2.5 rounded-lg hover:bg-purple-50 transition-colors shadow-sm">
                            Review Pending Items
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Suspended Account Notice --}}
            @if(auth()->user()->status === 'suspended')
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-5 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-700 dark:text-red-400">Account Suspended</p>
                        <p class="text-sm text-red-600 dark:text-red-300 mt-1">
                            {{ auth()->user()->suspended_reason ?? 'Your account has been suspended. Please contact support for assistance.' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Placeholder Stats Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @if(auth()->user()->account_type === 'student')
                    @foreach([
                        ['Available Internships', '—', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'blue'],
                        ['Active Applications', '—', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'indigo'],
                        ['Saved Internships', '—', 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z', 'purple'],
                        ['Profile Complete', '—%', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'emerald'],
                    ] as [$label, $value, $icon, $color])
                @elseif(auth()->user()->account_type === 'company')
                    @foreach([
                        ['Active Internships', '—', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'blue'],
                        ['Total Applicants', '—', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'emerald'],
                        ['Scheduled Interviews', '—', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'indigo'],
                        ['Pending Internships', '—', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'amber'],
                    ] as [$label, $value, $icon, $color])
                @else
                    @foreach([
                        ['Pending Companies', '—', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'amber'],
                        ['Pending Internships', '—', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'rose'],
                        ['Total Students', '—', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'blue'],
                        ['Active Companies', '—', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'emerald'],
                    ] as [$label, $value, $icon, $color])
                @endif
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-{{ $color }}-50 dark:bg-{{ $color }}-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-{{ $color }}-600 dark:text-{{ $color }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Build prompt: replace with actual dashboard partial --}}
            <div class="mt-6 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                <p class="text-xs text-blue-600 dark:text-blue-400 font-mono">
                    <!-- TODO: Replace this view with resources/views/{{ auth()->user()->account_type }}/dashboard.blade.php -->
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
