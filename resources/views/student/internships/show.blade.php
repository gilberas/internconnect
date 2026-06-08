<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('student.internships.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Browse Internships
            </a>
            <span class="text-gray-300 dark:text-gray-600">/</span>
            <span class="text-sm text-gray-700 dark:text-gray-300 font-medium truncate max-w-xs">{{ $internship->title }}</span>
        </div>
    </x-slot>

    @php
        $profile  = auth()->user()->studentProfile;
        $daysLeft = (int) now()->startOfDay()->diffInDays($internship->deadline, false);
    @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-5 flex items-center gap-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Title + Meta ────────────────────────────────────────────────────────── --}}
            <div class="mb-6">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                        {{ $internship->category->name }}
                    </span>
                    @if ($internship->isOpen())
                        <span class="px-2.5 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 text-xs font-medium rounded-full">Open</span>
                    @else
                        <span class="px-2.5 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 text-xs font-medium rounded-full">Closed</span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">
                    {{ $internship->title }}
                </h1>
                <p class="text-base text-gray-500 dark:text-gray-400 mt-1">
                    {{ $internship->company->company_name }}
                </p>

                {{-- Info badges --}}
                <div class="flex flex-wrap gap-3 mt-4">
                    <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $internship->location }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $internship->typeLabel() }}
                    </span>
                    @if ($internship->duration)
                    <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $internship->duration }}
                    </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $internship->positions }} {{ Str::plural('position', $internship->positions) }}
                    </span>
                </div>
            </div>

            {{-- Two-column layout ───────────────────────────────────────────────────── --}}
            <div class="grid lg:grid-cols-3 gap-6">

                {{-- LEFT COLUMN (2/3) ──────────────────────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Tabbed content --}}
                    <div x-data="{ tab: 'overview' }"
                         class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">

                        {{-- Tab nav --}}
                        <div class="flex border-b border-gray-100 dark:border-gray-800 px-1 pt-1 gap-1">
                            @foreach (['overview' => 'Overview', 'requirements' => 'Requirements', 'responsibilities' => 'Responsibilities'] as $key => $label)
                            <button type="button"
                                    @click="tab = '{{ $key }}'"
                                    :class="tab === '{{ $key }}'
                                        ? 'border-blue-600 text-blue-600 dark:text-blue-400'
                                        : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'"
                                    class="px-4 py-3 text-sm font-medium border-b-2 transition-colors">
                                {{ $label }}
                            </button>
                            @endforeach
                        </div>

                        <div class="p-6">
                            <div x-show="tab === 'overview'" x-transition>
                                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                    {{ $internship->description ?? 'No description provided.' }}
                                </div>
                            </div>

                            <div x-show="tab === 'requirements'" x-transition>
                                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                    {{ $internship->requirements ?? 'No specific requirements listed.' }}
                                </div>
                            </div>

                            <div x-show="tab === 'responsibilities'" x-transition>
                                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                    {{ $internship->responsibilities ?? 'No responsibilities listed.' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Skills required --}}
                    @if (!empty($internship->skills_required))
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Skills Required</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($internship->skills_required as $skill)
                                <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- RIGHT COLUMN (1/3, sticky) ─────────────────────────────────────── --}}
                <div class="space-y-4 lg:sticky lg:top-6 lg:self-start">

                    {{-- Company card --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr($internship->company->company_name, 0, 1)) }}
                                </span>
                            </div>
                            @if ($internship->company->isVerified())
                                <span class="inline-flex items-center gap-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 text-xs font-medium px-2 py-0.5 rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    BRELA Verified
                                </span>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-2">
                            {{ $internship->company->company_name }}
                        </h3>
                        @if ($internship->company->address)
                        <p class="text-xs text-gray-500 dark:text-gray-400 flex items-start gap-1.5 mb-1">
                            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $internship->company->address }}
                        </p>
                        @endif
                        @if ($internship->company->phone)
                        <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $internship->company->phone }}
                        </p>
                        @endif
                    </div>

                    {{-- Deadline + positions --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Deadline</span>
                            @if ($daysLeft <= 0)
                                <span class="text-xs font-semibold text-gray-500 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-full">Closed</span>
                            @elseif ($daysLeft <= 7)
                                <span class="text-xs font-semibold text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-0.5 rounded-full">{{ $daysLeft }} days left</span>
                            @else
                                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">{{ $daysLeft }} days left</span>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $internship->deadline->format('d F Y') }}
                        </p>

                        <div class="border-t border-gray-100 dark:border-gray-800 pt-3 flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Open Positions</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $internship->positions }}</span>
                        </div>
                    </div>

                    {{-- Apply + Save section --}}
                    <div x-data="{ applyOpen: {{ $errors->hasAny(['cv','cover_letter','certificates']) ? 'true' : 'false' }} }"
                         class="space-y-3">

                        {{-- Apply Modal --}}
                        <div x-show="applyOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-black/60 z-50 overflow-y-auto"
                             @click.self="applyOpen = false">
                            <div class="min-h-screen px-4 py-10 flex items-start justify-center">
                                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     @click.stop>

                                    {{-- Modal header --}}
                                    <div class="flex items-start justify-between p-6 border-b border-gray-100 dark:border-gray-800">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Apply for Internship</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">{{ $internship->title }}</p>
                                        </div>
                                        <button type="button" @click="applyOpen = false"
                                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors ml-4 mt-0.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Modal form --}}
                                    <form method="POST"
                                          action="{{ route('student.applications.store', $internship) }}"
                                          enctype="multipart/form-data"
                                          class="p-6 space-y-5">
                                        @csrf

                                        {{-- CV section --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                                Curriculum Vitae (CV)
                                            </label>
                                            @if ($profile?->hasCv())
                                                <div class="flex items-center gap-2.5 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl mb-2">
                                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <p class="text-xs text-emerald-700 dark:text-emerald-300">
                                                        Your profile CV will be used. Upload below to override.
                                                    </p>
                                                </div>
                                            @endif
                                            <input type="file" name="cv" accept=".pdf"
                                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                          file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                          file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                                          hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                                            <p class="text-xs text-gray-400 mt-1">PDF only · max 5 MB</p>
                                            @error('cv')
                                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Cover Letter --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                                Cover Letter <span class="text-gray-400 font-normal">(optional)</span>
                                            </label>
                                            <input type="file" name="cover_letter" accept=".pdf,.doc,.docx"
                                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                          file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                          file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                                          hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX · max 5 MB</p>
                                            @error('cover_letter')
                                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Certificates --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                                Supporting Certificates <span class="text-gray-400 font-normal">(optional)</span>
                                            </label>
                                            <input type="file" name="certificates[]"
                                                   accept=".pdf,.jpg,.jpeg,.png" multiple
                                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                          file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                          file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                                          hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                                            <p class="text-xs text-gray-400 mt-1">Max 5 files · 2 MB each · PDF, JPG, PNG</p>
                                            @error('certificates')
                                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                            @enderror
                                            @error('certificates.*')
                                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex gap-3 pt-1">
                                            <button type="button" @click="applyOpen = false"
                                                    class="flex-1 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                    class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors">
                                                Submit Application
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- /Modal --}}

                        @if (! $profile || ! $profile->hasCv())
                            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-2xl p-4">
                                <p class="text-sm font-medium text-amber-800 dark:text-amber-300 mb-2">Upload your CV first</p>
                                <p class="text-xs text-amber-600 dark:text-amber-400 mb-3">A CV is required to apply for internships.</p>
                                <a href="{{ route('student.profile.edit') }}"
                                   class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                                    Go to Profile →
                                </a>
                            </div>
                        @elseif ($hasApplied)
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-2xl p-4 text-center">
                                <div class="flex items-center justify-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">Application Submitted</span>
                                </div>
                                <a href="{{ route('student.applications.index') }}"
                                   class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline">
                                    View your applications →
                                </a>
                            </div>
                        @elseif (! $internship->isOpen())
                            <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl p-4 text-center">
                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Applications Closed</p>
                                <p class="text-xs text-gray-400 mt-0.5">This internship is no longer accepting applications.</p>
                            </div>
                        @else
                            <button type="button" @click="applyOpen = true"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-2xl text-sm transition-colors">
                                Apply Now
                            </button>
                        @endif

                        {{-- Save toggle --}}
                        <form method="POST" action="{{ route('student.internships.save', $internship) }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-2xl border text-sm font-medium transition-colors
                                           {{ $isSaved
                                               ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-700 text-blue-700 dark:text-blue-300 hover:bg-blue-100'
                                               : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <svg class="w-4 h-4 {{ $isSaved ? 'fill-current' : '' }}"
                                     fill="{{ $isSaved ? 'currentColor' : 'none' }}"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                {{ $isSaved ? 'Saved ✓' : 'Save Internship' }}
                            </button>
                        </form>
                    </div>

                </div>{{-- /right --}}
            </div>{{-- /grid --}}

        </div>
    </div>
</x-app-layout>
