<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Applications</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($applications->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 mb-4">You haven't applied to any internships yet.</p>
                    <a href="{{ route('student.internships.index') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors">
                        Browse Internships
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($applications as $app)
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                            <div class="flex-1">
                                <a href="{{ route('student.applications.show', $app) }}"
                                   class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $app->internship->title }}
                                </a>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $app->internship->company->company_name }}
                                    &middot; {{ $app->internship->location }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Applied {{ $app->created_at->diffForHumans() }}
                                </p>

                                @if($app->interview && in_array($app->interview->status, ['scheduled','confirmed','rescheduled']))
                                <div class="mt-2 inline-flex items-center gap-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-xs px-3 py-1 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Interview: {{ $app->interview->interview_date->format('d M Y') }}
                                    at {{ substr($app->interview->interview_time, 0, 5) }}
                                    &mdash; {{ $app->interview->typeLabel() }}
                                </div>
                                @endif
                            </div>
                            <x-status-badge :status="$app->status" class="shrink-0"/>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
