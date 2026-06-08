<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('company.applicants.index', $internship) }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Applicants
            </a>
            <span class="text-gray-300 dark:text-gray-600 shrink-0">/</span>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                {{ $application->student->full_name ?? $application->student->user->name }}
            </span>
            <x-status-badge :status="$application->status" class="shrink-0"/>
        </div>
    </x-slot>

    @php $student = $application->student; $iv = $application->interview; @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4 mb-6">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <div class="grid lg:grid-cols-5 gap-6">

                {{-- LEFT (3/5) ─────────────────────────────────────────────────────── --}}
                <div class="lg:col-span-3 space-y-5">

                    {{-- Card 1 — Student Profile ───────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shrink-0 text-lg font-bold text-white">
                                {{ strtoupper(substr($student->full_name ?? $student->user->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $student->full_name ?? $student->user->name }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $student->user->email }}</p>
                                @if ($student->phone)
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student->phone }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">University</p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $student->university ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Program</p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $student->program ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Graduation Year</p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $student->graduation_year ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Applied</p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $application->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if (!empty($student->skills))
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-2">Skills</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($student->skills as $skill)
                                        <span class="px-2.5 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Card 2 — Submitted Documents ───────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-4">
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
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">CV / Resume</p>
                                    @if ($application->cv_path)
                                        <p class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ basename($application->cv_path) }}</p>
                                    @else
                                        <p class="text-sm text-gray-400 italic">Not submitted</p>
                                    @endif
                                </div>
                                @if ($application->cv_path)
                                    <span class="text-xs text-gray-400 shrink-0 whitespace-nowrap">Available via secure download</span>
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
                                        <p class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ basename($application->cover_letter_path) }}</p>
                                    @else
                                        <p class="text-sm text-gray-400 italic">Not submitted</p>
                                    @endif
                                </div>
                                @if ($application->cover_letter_path)
                                    <span class="text-xs text-gray-400 shrink-0 whitespace-nowrap">Available via secure download</span>
                                @endif
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
                                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $cert->original_filename }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card 3 — Status Update Form ────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-4">
                            Update Application Status
                        </h3>

                        <form method="POST" action="{{ route('company.applications.status', $application) }}" class="space-y-4">
                            @csrf @method('PATCH')

                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                                <select name="status"
                                        class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                    @foreach (['under_review' => 'Under Review', 'shortlisted' => 'Shortlisted', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $val => $lbl)
                                        <option value="{{ $val }}" {{ old('status', $application->status) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Internal Notes
                                    <span class="text-gray-400 font-normal normal-case">(not visible to the student)</span>
                                </label>
                                <textarea name="company_notes" rows="3"
                                          placeholder="Notes visible only to your company..."
                                          class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none">{{ old('company_notes', $application->company_notes) }}</textarea>
                                @error('company_notes')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                                Update Status
                            </button>
                        </form>
                    </div>

                    {{-- Interview Section ──────────────────────────────────────────── --}}
                    @if ($iv)
                        {{-- Existing interview --}}
                        <div x-data="{ editing: false, type: '{{ old('interview_type', $iv->interview_type) }}' }"
                             class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200 uppercase tracking-wide">Interview</h3>
                                <x-status-badge :status="$iv->status"/>
                            </div>

                            {{-- Details --}}
                            <div x-show="!editing" class="space-y-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-white dark:bg-blue-900/30 rounded-lg text-xs font-medium text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M3 8h12a2 2 0 012 2v4a2 2 0 01-2 2H3a2 2 0 01-2-2v-4a2 2 0 012-2z"/>
                                    </svg>
                                    {{ $iv->typeLabel() }}
                                </span>

                                <div class="grid sm:grid-cols-2 gap-4 text-sm pt-1">
                                    <div>
                                        <p class="text-xs font-medium text-blue-500 dark:text-blue-400 uppercase tracking-wide mb-1">Date</p>
                                        <p class="text-blue-900 dark:text-blue-100 font-medium">{{ $iv->interview_date->format('l, d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-blue-500 dark:text-blue-400 uppercase tracking-wide mb-1">Time</p>
                                        <p class="text-blue-900 dark:text-blue-100">{{ substr($iv->interview_time, 0, 5) }}</p>
                                    </div>
                                    @if ($iv->venue)
                                    <div class="sm:col-span-2">
                                        <p class="text-xs font-medium text-blue-500 dark:text-blue-400 uppercase tracking-wide mb-1">Venue</p>
                                        <p class="text-blue-900 dark:text-blue-100">{{ $iv->venue }}</p>
                                    </div>
                                    @endif
                                    @if ($iv->meeting_link)
                                    <div class="sm:col-span-2">
                                        <p class="text-xs font-medium text-blue-500 dark:text-blue-400 uppercase tracking-wide mb-1">Meeting Link</p>
                                        <a href="{{ $iv->meeting_link }}" target="_blank" rel="noopener"
                                           class="text-sm text-blue-600 dark:text-blue-400 hover:underline break-all">{{ $iv->meeting_link }}</a>
                                    </div>
                                    @endif
                                    @if ($iv->instructions)
                                    <div class="sm:col-span-2">
                                        <p class="text-xs font-medium text-blue-500 dark:text-blue-400 uppercase tracking-wide mb-1">Instructions</p>
                                        <p class="text-blue-900 dark:text-blue-100 text-sm leading-relaxed">{{ $iv->instructions }}</p>
                                    </div>
                                    @endif
                                </div>

                                @if (!in_array($iv->status, ['cancelled', 'completed']))
                                    <div class="flex gap-3 pt-3 border-t border-blue-200 dark:border-blue-800">
                                        <button @click="editing = true"
                                                class="inline-flex items-center gap-1.5 bg-white dark:bg-blue-900/40 border border-blue-300 dark:border-blue-700 text-blue-700 dark:text-blue-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/60 transition-colors">
                                            Reschedule
                                        </button>
                                        <form method="POST" action="{{ route('company.interviews.cancel', $iv) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 bg-white dark:bg-red-900/20 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 text-sm font-medium px-4 py-2 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/40 transition-colors"
                                                    onclick="return confirm('Cancel this interview? The student will be notified.')">
                                                Cancel Interview
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if (!empty($iv->reschedule_history))
                                    <div class="pt-3 border-t border-blue-200 dark:border-blue-800">
                                        <p class="text-xs font-medium text-blue-500 dark:text-blue-400 uppercase tracking-wide mb-2">Reschedule History</p>
                                        <div class="space-y-1.5">
                                            @foreach ($iv->reschedule_history as $h)
                                                <p class="text-xs text-blue-700 dark:text-blue-300">
                                                    Was {{ \Carbon\Carbon::parse($h['previous_date'])->format('d M Y') }}
                                                    at {{ substr($h['previous_time'], 0, 5) }}
                                                    — rescheduled {{ \Carbon\Carbon::parse($h['rescheduled_at'])->format('d M Y, H:i') }}
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Reschedule form --}}
                            <div x-show="editing" x-cloak>
                                <form method="POST" action="{{ route('company.interviews.update', $iv) }}" class="space-y-4">
                                    @csrf @method('PUT')
                                    @include('company.applicants._interview-fields', [
                                        'date'         => old('interview_date', $iv->interview_date->format('Y-m-d')),
                                        'time'         => old('interview_time', substr($iv->interview_time, 0, 5)),
                                        'venue'        => old('venue', $iv->venue),
                                        'meetingLink'  => old('meeting_link', $iv->meeting_link),
                                        'instructions' => old('instructions', $iv->instructions),
                                    ])
                                    <div class="flex gap-3">
                                        <button type="submit"
                                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                                            Save Reschedule
                                        </button>
                                        <button type="button" @click="editing = false"
                                                class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @else
                        {{-- Schedule new interview --}}
                        <div x-data="{ open: false, type: '{{ old('interview_type', 'physical') }}' }"
                             class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 p-6">
                            <div class="flex items-center justify-between" :class="open ? 'mb-4' : ''">
                                <div>
                                    <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200 uppercase tracking-wide">Schedule an Interview</h3>
                                    <p x-show="!open" class="text-sm text-blue-700 dark:text-blue-300 mt-1">No interview scheduled yet for this applicant.</p>
                                </div>
                                <button @click="open = !open"
                                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition-colors shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span x-text="open ? 'Close' : 'Schedule Interview'"></span>
                                </button>
                            </div>

                            <form x-show="open" x-cloak
                                  method="POST" action="{{ route('company.interviews.store', $application) }}"
                                  class="space-y-4">
                                @csrf
                                @include('company.applicants._interview-fields', [
                                    'date'         => old('interview_date'),
                                    'time'         => old('interview_time'),
                                    'venue'        => old('venue'),
                                    'meetingLink'  => old('meeting_link'),
                                    'instructions' => old('instructions'),
                                ])
                                <button type="submit"
                                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                                    Confirm Interview
                                </button>
                            </form>
                        </div>
                    @endif

                </div>{{-- /left --}}

                {{-- RIGHT (2/5) ────────────────────────────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-5 lg:sticky lg:top-6 lg:self-start">

                    {{-- Internship summary ─────────────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">Internship</p>
                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 leading-snug">{{ $internship->title }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $internship->company->company_name }}</p>

                        <div class="space-y-1.5 text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Deadline: {{ $internship->deadline->format('d M Y') }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $internship->positions }} {{ Str::plural('position', $internship->positions) }}
                            </div>
                        </div>

                        <a href="{{ route('company.internships.show', $internship) }}"
                           class="block w-full text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            View Internship
                        </a>
                    </div>

                    {{-- Application timeline ────────────────────────────────────────── --}}
                    @php
                        $order        = ['submitted', 'under_review', 'shortlisted', 'interview_scheduled', 'accepted'];
                        $isRejected   = $application->status === 'rejected';
                        $currentIndex = array_search($application->status, $order);
                        $reachedIndex = $isRejected ? 2 : ($currentIndex === false ? 0 : $currentIndex);

                        $steps = [
                            'submitted'           => 'Submitted',
                            'under_review'        => 'Under Review',
                            'shortlisted'         => 'Shortlisted',
                            'interview_scheduled' => 'Interview Scheduled',
                            'accepted'            => 'Accepted',
                        ];
                    @endphp
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">
                            Application Timeline
                        </h3>

                        <ol class="relative">
                            @foreach ($steps as $key => $label)
                                @php
                                    $stepIndex = array_search($key, $order);
                                    $isReached = $stepIndex <= $reachedIndex;
                                    $isCurrent = $key === $application->status;
                                    $isLast    = $loop->last;

                                    if ($isLast && $isRejected) {
                                        $label     = 'Rejected';
                                        $isReached = true;
                                        $isCurrent = true;
                                    }
                                @endphp

                                <li class="flex gap-4 {{ ! $loop->last ? 'pb-6' : '' }}">
                                    <div class="flex flex-col items-center">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 z-10
                                            {{ $isLast && $isRejected
                                                ? 'bg-red-500 text-white'
                                                : ($isCurrent
                                                    ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900'
                                                    : ($isReached
                                                        ? 'bg-blue-600 text-white'
                                                        : 'bg-gray-200 dark:bg-gray-700 text-gray-400')) }}">
                                            @if ($isReached && ! $isCurrent)
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif ($isLast && $isRejected)
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <span class="text-xs font-bold">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        @if (! $loop->last)
                                            <div class="w-0.5 flex-1 mt-1 {{ $isReached ? 'bg-blue-400 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                                        @endif
                                    </div>

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
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $application->created_at->format('d M Y, H:i') }}</p>
                                        @elseif ($key === 'interview_scheduled' && $iv)
                                            <p class="text-xs text-gray-400 mt-0.5">Scheduled for {{ $iv->interview_date->format('d M Y') }}</p>
                                        @elseif (! $isReached)
                                            <p class="text-xs text-gray-400 mt-0.5">Pending</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                </div>{{-- /right --}}
            </div>{{-- /grid --}}
        </div>
    </div>
</x-app-layout>
