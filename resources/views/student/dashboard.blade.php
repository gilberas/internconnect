<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Student Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @php $profile = auth()->user()->studentProfile; @endphp

            {{-- Profile Completion Banner --}}
            @if($profile && $profile->completion_percentage < 80)
            <div class="bg-blue-600 rounded-2xl p-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-lg">Complete Your Profile</h3>
                    <p class="text-blue-100 text-sm mt-1">A complete profile improves your chances of getting shortlisted.</p>
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

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([
                    ['Available Internships', \App\Models\Internship::approved()->count(), 'Search Now', route('student.internships.index'), 'blue', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['My Applications', $profile?->applications()->count() ?? 0, 'View All', route('student.applications.index'), 'indigo', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['Saved', $profile?->savedInternships()->count() ?? 0, 'View Saved', route('student.saved.index'), 'purple', 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z'],
                    ['Interviews', $profile?->applications()->where('status','interview_scheduled')->count() ?? 0, 'View Applications', route('student.applications.index'), 'amber', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ] as [$label, $value, $action, $href, $color, $icon])
                <div class="bg-white dark:bg-gray-900 rounded-xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="w-10 h-10 bg-{{ $color }}-50 dark:bg-{{ $color }}-900/30 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-{{ $color }}-600 dark:text-{{ $color }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $label }}</p>
                    <a href="{{ $href }}" class="text-xs text-{{ $color }}-600 dark:text-{{ $color }}-400 font-medium mt-2 inline-block hover:underline">
                        {{ $action }} →
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Recent Applications --}}
            @if($profile && $profile->applications()->count() > 0)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Recent Applications</h3>
                    <a href="{{ route('student.applications.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-gray-800">
                    @foreach($profile->applications()->with('internship.company')->latest()->take(5)->get() as $app)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $app->internship->title }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $app->internship->company->company_name }}</p>
                        </div>
                        <x-status-badge :status="$app->status"/>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
