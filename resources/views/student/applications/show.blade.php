<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('student.applications.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                My Applications
            </a>
            <span class="text-gray-300 dark:text-gray-600">/</span>
            <span class="text-sm text-gray-700 dark:text-gray-300 font-medium truncate max-w-xs">
                {{ $application->internship->title }}
            </span>
        </div>
    </x-slot>

    @php
        $statusOrder = ['submitted', 'under_review', 'shortlisted', 'interview_scheduled', 'accepted'];
        $currentStatus  = $application->status;
        $isRejected = $currentStatus === 'rejected';
        $currentIndex = array_search($currentStatus, $statusOrder);
        // For rejected, use the index before rejected (treat as after shortlisted at minimum)
        $reachedIndex = $isRejected ? max(1, $currentIndex === false ? 1 : $currentIndex) : ($currentIndex === false ? 0 : $currentIndex);

        $steps = [
            'submitted'            => 'Submitted',
            'under_review'         => 'Under Review',
            'shortlisted'          => 'Shortlisted',
            'interview_scheduled'  => 'Interview Scheduled',
            'accepted'             => 'Accepted',
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-6">

                {{-- LEFT COLUMN (2/3) ──────────────────────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Status Timeline ──────────────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-6 uppercase tracking-wide">
                            Application Progress
                        </h3>

                        <ol class="relative">
                            @foreach ($steps as $key => $label)
                                @php
                                    $stepIndex  = array_search($key, $statusOrder);
                                    $isReached  = $stepIndex <= $reachedIndex;
                                    $isCurrent  = $key === $currentStatus;
                                    $isLast     = $loop->last;

                                    // Skip "Accepted" and replace with "Rejected" step
                                    if ($isLast && $isRejected) {
                                        $label     = 'Rejected';
                                        $isReached = true;
                                        $isCurrent = true;
                                    }
                                @endphp

                                <li class="flex gap-4 {{ ! $loop->last ? 'pb-6' : '' }}">
                                    {{-- Circle + connecting line --}}
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 transition-colors
                                            {{ $isLast && $isRejected
                                                ? 'bg-red-500 text-white'
                                                : ($isCurrent
                                                    ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900'
                                                    : ($isReached
                                                        ? 'bg-blue-600 text-white'
                                                        : 'bg-gray-200 dark:bg-gray-700 text-gray-400')) }}">
                                            @if ($isReached && ! $isCurrent)
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif ($isLast && $isRejected)
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <span class="text-xs font-bold">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        @if (! $loop->last)
                                            <div class="w-0.5 flex-1 mt-1
                                                {{ $isReached ? 'bg-blue-400 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Label + timestamp --}}
                                    <div class="pb-1">
                                        <p class="text-sm font-semibold
                                            {{ $isLast && $isRejected
                                                ? 'text-red-600 dark:text-red-400'
                                                : ($isCurrent
                                                    ? 'text-blue-700 dark:text-blue-300'
                                                    : ($isReached
                                                        ? 'text-gray-900 dark:text-white'
                                                        : 'text-gray-400 dark:text-gray-500')) }}">
                                            {{ $label }}
                                            @if ($isCurrent && ! ($isLast && $isRejected))
                                                <span class="ml-1.5 text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-1.5 py-0.5 rounded-full">Current</span>
                                            @endif
                                        </p>
                                        @if ($key === 'submitted')
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $application->created_at->format('d M Y, H:i') }}
                                            </p>
                                        @elseif ($isCurrent && $key === 'interview_scheduled' && $application->interview)
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                Scheduled for {{ $application->interview->interview_date->format('d M Y') }}
                                            </p>
                                        @elseif (! $isReached)
                                            <p class="text-xs text-gray-400 mt-0.5">Pending</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Documents ─────────────────────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 uppercase tracking-wide">
                            Submitted Documents
                        </h3>

                        <div class="space-y-3">
                            {{-- CV --}}
                            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="w-9 h-9 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">CV</p>
                                    @if ($application->cv_path)
                                        <p class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                            {{ basename($application->cv_path) }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-400 italic">Not provided</p>
                                    @endif
                                </div>
                                @if ($application->cv_path)
                                    <span class="text-xs text-gray-400 shrink-0">Private</span>
                                @endif
                            </div>

                            {{-- Cover Letter --}}
                            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="w-9 h-9 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Cover Letter</p>
                                    @if ($application->cover_letter_path)
                                        <p class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                            {{ basename($application->cover_letter_path) }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-400 italic">Not submitted</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Certificates --}}
                            @if ($application->certificates->isNotEmpty())
                                <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                        Certificates ({{ $application->certificates->count() }})
                                    </p>
                                    <div class="space-y-1.5">
                                        @foreach ($application->certificates as $cert)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                                    {{ $cert->original_filename }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="w-9 h-9 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Certificates</p>
                                        <p class="text-sm text-gray-400 italic">None submitted</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN (1/3, sticky) ─────────────────────────────────────── --}}
                <div class="space-y-4 lg:sticky lg:top-6 lg:self-start">

                    {{-- Internship summary --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">Internship</p>

                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 leading-snug">
                            {{ $application->internship->title }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                            {{ $application->internship->company->company_name }}
                        </p>

                        <div class="space-y-1.5 text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $application->internship->location }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $application->internship->typeLabel() }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Deadline: {{ $application->internship->deadline->format('d M Y') }}
                            </div>
                        </div>

                        <a href="{{ route('student.internships.show', $application->internship) }}"
                           class="block w-full text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            View Internship
                        </a>
                    </div>

                    {{-- Interview card --}}
                    @if ($application->interview)
                    @php $iv = $application->interview; @endphp
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wide">Interview</p>
                            <x-status-badge :status="$iv->status"/>
                        </div>

                        {{-- Type badge --}}
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-white dark:bg-blue-900/30 rounded-lg text-xs font-medium text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700 mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M3 8h12a2 2 0 012 2v4a2 2 0 01-2 2H3a2 2 0 01-2-2v-4a2 2 0 012-2z"/>
                            </svg>
                            {{ $iv->typeLabel() }}
                        </span>

                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2 text-blue-800 dark:text-blue-200">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium">{{ $iv->interview_date->format('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-blue-800 dark:text-blue-200">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ substr($iv->interview_time, 0, 5) }}</span>
                            </div>

                            @if ($iv->interview_type === 'physical' && $iv->venue)
                            <div class="flex items-start gap-2 text-blue-800 dark:text-blue-200">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="text-xs">{{ $iv->venue }}</span>
                            </div>
                            @elseif ($iv->interview_type === 'online' && $iv->meeting_link)
                            <div class="flex items-start gap-2 text-blue-800 dark:text-blue-200">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <a href="{{ $iv->meeting_link }}" target="_blank" rel="noopener"
                                   class="text-xs text-blue-600 dark:text-blue-400 hover:underline truncate">
                                    Join Meeting
                                </a>
                            </div>
                            @endif

                            @if ($iv->instructions)
                            <div class="mt-3 p-3 bg-white/60 dark:bg-blue-950/40 rounded-xl text-xs text-blue-800 dark:text-blue-200 leading-relaxed">
                                <p class="font-semibold mb-1">Instructions</p>
                                {{ $iv->instructions }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>{{-- /right --}}
            </div>{{-- /grid --}}
        </div>
    </div>
</x-app-layout>
