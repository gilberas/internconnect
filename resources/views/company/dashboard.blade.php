<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Company Dashboard</h2>
            <x-status-badge :status="auth()->user()->companyProfile?->verification_status ?? 'pending'"/>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @php $profile = auth()->user()->companyProfile; @endphp

            {{-- Verification Notice --}}
            @if($profile && $profile->isPending())
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-5 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">Verification Pending</p>
                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-0.5">
                        Your account is under review. You can post internships once verified.
                    </p>
                </div>
            </div>
            @elseif($profile && $profile->isRejected())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-5 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">Verification Rejected</p>
                    <p class="text-xs text-red-700 dark:text-red-400 mt-0.5">
                        Reason: {{ $profile->rejection_reason }}
                    </p>
                    <a href="{{ route('company.setup') }}" class="text-xs text-red-600 underline mt-1 inline-block">
                        Resubmit Documents →
                    </a>
                </div>
            </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([
                    ['Active Internships', $profile?->internships()->where('status','approved')->count() ?? 0, 'blue'],
                    ['Total Applicants', \App\Models\Application::whereHas('internship', fn($q)=>$q->where('company_id', $profile?->id))->count(), 'emerald'],
                    ['Pending Internships', $profile?->internships()->where('status','pending')->count() ?? 0, 'amber'],
                    ['Scheduled Interviews', \App\Models\Interview::whereHas('application.internship', fn($q)=>$q->where('company_id', $profile?->id))->where('status','scheduled')->count(), 'indigo'],
                ] as [$label, $value, $color])
                <div class="bg-white dark:bg-gray-900 rounded-xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $label }}</p>
                </div>
                @endforeach
            </div>

            {{-- Quick Actions --}}
            @if($profile?->isVerified())
            <div class="flex gap-3">
                <a href="{{ route('company.internships.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
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

        </div>
    </div>
</x-app-layout>
