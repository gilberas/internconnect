<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
                @foreach([
                    ['Pending Companies',   $stats['pending_companies'],   'amber',   route('admin.companies.index',  ['status'=>'pending'])],
                    ['Pending Internships', $stats['pending_internships'], 'rose',    route('admin.internships.index',['status'=>'pending'])],
                    ['Total Students',      $stats['total_students'],      'blue',    route('admin.users.index',      ['type'=>'student'])],
                    ['Verified Companies',  $stats['total_companies'],     'emerald', route('admin.companies.index',  ['status'=>'verified'])],
                    ['Live Internships',    $stats['total_internships'],   'indigo',  route('admin.internships.index',['status'=>'approved'])],
                    ['Applications',        $stats['total_applications'],  'purple',  '#'],
                ] as [$label, $value, $color, $href])
                <a href="{{ $href }}"
                   class="bg-white dark:bg-gray-900 rounded-xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow block">
                    <p class="text-3xl font-extrabold text-{{ $color }}-600 dark:text-{{ $color }}-400">{{ $value }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $label }}</p>
                </a>
                @endforeach
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                {{-- Pending Companies --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Pending Companies</h3>
                        <a href="{{ route('admin.companies.index', ['status'=>'pending']) }}"
                           class="text-xs text-blue-600 hover:underline">View all →</a>
                    </div>
                    @if($recentCompanies->isEmpty())
                        <p class="text-sm text-gray-400 p-5 text-center">No pending companies.</p>
                    @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($recentCompanies as $c)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $c->company_name }}</p>
                                <p class="text-xs text-gray-500">{{ $c->user->email }}</p>
                            </div>
                            <a href="{{ route('admin.companies.show', $c) }}"
                               class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors">
                                Review
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Pending Internships --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Pending Internships</h3>
                        <a href="{{ route('admin.internships.index', ['status'=>'pending']) }}"
                           class="text-xs text-blue-600 hover:underline">View all →</a>
                    </div>
                    @if($recentInternships->isEmpty())
                        <p class="text-sm text-gray-400 p-5 text-center">No pending internships.</p>
                    @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($recentInternships as $i)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $i->title }}</p>
                                <p class="text-xs text-gray-500">{{ $i->company->company_name }}</p>
                            </div>
                            <a href="{{ route('admin.internships.show', $i) }}"
                               class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors">
                                Review
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
