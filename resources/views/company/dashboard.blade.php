<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Company Dashboard
            </h2>
            <x-status-badge :status="auth()->user()->companyProfile->verification_status"/>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Verification notices --}}
            @if ($profile->isPending())
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-5 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">Verification Pending</p>
                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-0.5">
                        Your documents are under review. You can post internships once verified. This usually takes up to 24 hours.
                    </p>
                </div>
            </div>
            @elseif ($profile->isRejected())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-5 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">Verification Rejected</p>
                    <p class="text-xs text-red-700 dark:text-red-400 mt-0.5">Reason: {{ $profile->rejection_reason }}</p>
                    <a href="{{ route('company.setup') }}"
                       class="text-xs text-red-600 dark:text-red-400 underline mt-1 inline-block font-medium">
                        Resubmit Documents →
                    </a>
                </div>
            </div>
            @endif

            {{-- Stats grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ([
                    ['Active Internships',   $stats['active'],     'company.internships.index', 'View All',     'blue',   'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['Total Applicants',     $stats['applicants'], 'company.internships.index', 'Manage',       'emerald','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['Scheduled Interviews', $stats['interviews'], 'company.internships.index', 'View',         'indigo', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['Pending Review',       $stats['pending'],    'company.internships.index', 'Check Status', 'amber',  'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ] as [$label, $value, $route, $action, $color, $icon])
                <div class="bg-white dark:bg-gray-900 rounded-xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-{{ $color }}-50 dark:bg-{{ $color }}-900/20 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-{{ $color }}-600 dark:text-{{ $color }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $label }}</p>
                    <a href="{{ route($route) }}"
                       class="text-xs text-{{ $color }}-600 dark:text-{{ $color }}-400 font-medium mt-2 inline-block hover:underline">
                        {{ $action }} →
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Quick actions (only if verified) --}}
            @if ($profile->isVerified())
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('company.internships.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Post New Internship
                </a>
                <a href="{{ route('company.internships.index') }}"
                   class="inline-flex items-center gap-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    View All Internships
                </a>
            </div>
            @endif

            {{-- Bottom two columns --}}
            <div class="grid lg:grid-cols-2 gap-6">

                {{-- Recent Applications --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Recent Applications</h3>
                    </div>
                    @if ($recentApplications->isEmpty())
                        <div class="p-8 text-center text-gray-400 dark:text-gray-500 text-sm">No applications yet.</div>
                    @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($recentApplications as $app)
                        <div class="px-5 py-3 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $app->student->user->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $app->internship->title }} · {{ $app->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <x-status-badge :status="$app->status"/>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Active Internships --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Active Internships</h3>
                        <a href="{{ route('company.internships.index') }}"
                           class="text-xs text-blue-600 dark:text-blue-400 hover:underline">View all →</a>
                    </div>
                    @if ($activeInternships->isEmpty())
                        <div class="p-8 text-center text-gray-400 dark:text-gray-500 text-sm">
                            No active internships.
                            @if ($profile->isVerified())
                            <a href="{{ route('company.internships.create') }}"
                               class="block mt-2 text-blue-600 dark:text-blue-400 hover:underline">
                                Post your first internship
                            </a>
                            @endif
                        </div>
                    @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($activeInternships as $i)
                        <div class="px-5 py-3 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('company.internships.show', $i) }}"
                                   class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate block">
                                    {{ $i->title }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $i->applications_count }} {{ Str::plural('applicant', $i->applications_count) }} · Deadline {{ $i->deadline->format('d M') }}
                                </p>
                            </div>
                            <a href="{{ route('company.applicants.index', $i) }}"
                               class="text-xs text-blue-600 dark:text-blue-400 hover:underline shrink-0">
                                Review →
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
