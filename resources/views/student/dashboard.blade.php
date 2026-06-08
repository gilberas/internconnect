<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Student Dashboard</h2>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ now()->format('l, d M Y') }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Suspended notice --}}
            @if (auth()->user()->isSuspended())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 flex gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-300">Account Suspended</p>
                    <p class="text-sm text-red-600 dark:text-red-400 mt-0.5">
                        {{ auth()->user()->suspended_reason ?? 'Please contact support for assistance.' }}
                    </p>
                </div>
            </div>
            @endif

            {{-- Profile completion banner --}}
            @if ($profile->completion_percentage < 80)
            <div class="bg-blue-600 rounded-2xl p-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-lg">Complete Your Profile</h3>
                    <p class="text-blue-100 text-sm mt-1">A complete profile improves your chances of being shortlisted.</p>
                    <div class="mt-3 bg-white/20 rounded-full h-2 w-64">
                        <div class="bg-white rounded-full h-2" style="width: {{ $profile->completion_percentage }}%"></div>
                    </div>
                    <p class="text-blue-200 text-xs mt-1">{{ $profile->completion_percentage }}% complete</p>
                </div>
                <a href="{{ route('student.profile.edit') }}"
                   class="shrink-0 bg-white text-blue-700 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-50 transition-colors">
                    Complete Profile
                </a>
            </div>
            @endif

            {{-- Stats grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ([
                    ['Available Internships', $stats['available'],   'student.internships.index', 'Browse',   'blue',
                     'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['My Applications',       $stats['applications'], 'student.applications.index', 'View All', 'indigo',
                     'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['Saved Internships',     $stats['saved'],        'student.saved.index',        'View Saved', 'purple',
                     'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z'],
                    ['Interviews',            $stats['interviews'],   'student.applications.index', 'View',     'amber',
                     'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ] as [$label, $value, $route, $action, $color, $icon])
                <div class="bg-white dark:bg-gray-900 rounded-xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-{{ $color }}-50 dark:bg-{{ $color }}-900/30 rounded-lg flex items-center justify-center mb-3">
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

            {{-- Recent Applications + Recommended side by side --}}
            <div class="grid lg:grid-cols-2 gap-6">

                {{-- Recent Applications --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Recent Applications</h3>
                        <a href="{{ route('student.applications.index') }}"
                           class="text-xs text-blue-600 dark:text-blue-400 hover:underline">View all →</a>
                    </div>

                    @if ($recentApplications->isEmpty())
                        <div class="p-8 text-center">
                            <p class="text-sm text-gray-400">No applications yet.</p>
                            <a href="{{ route('student.internships.index') }}"
                               class="block mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                Browse internships →
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach ($recentApplications as $app)
                            <div class="px-5 py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('student.applications.show', $app) }}"
                                       class="text-sm font-medium text-gray-900 dark:text-white truncate block hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $app->internship->title }}
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $app->internship->company->company_name }}
                                    </p>
                                    @if ($app->interview && in_array($app->interview->status, ['scheduled', 'confirmed', 'rescheduled']))
                                        <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">
                                            Interview: {{ $app->interview->interview_date->format('d M') }}
                                        </span>
                                    @endif
                                </div>
                                <x-status-badge :status="$app->status"/>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Latest Opportunities --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Latest Opportunities</h3>
                        <a href="{{ route('student.internships.index') }}"
                           class="text-xs text-blue-600 dark:text-blue-400 hover:underline">View all →</a>
                    </div>

                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse ($recommended as $internship)
                        <div class="px-5 py-3">
                            <a href="{{ route('student.internships.show', $internship) }}"
                               class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors block">
                                {{ $internship->title }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $internship->company->company_name }} &middot; {{ $internship->location }}
                            </p>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs px-2 py-0.5 rounded-full">
                                    {{ $internship->category->name }}
                                </span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    Deadline: {{ $internship->deadline->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <p class="text-sm text-gray-400">No internships available right now.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
