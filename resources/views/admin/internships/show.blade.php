<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.internships.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $internship->title }}</h2>
            <x-status-badge :status="$internship->status"/>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    @foreach([
                        ['Company',       $internship->company->company_name],
                        ['Category',      $internship->category->name],
                        ['Type',          $internship->typeLabel()],
                        ['Location',      $internship->location],
                        ['Duration',      $internship->duration],
                        ['Positions',     $internship->positions],
                        ['Deadline',      $internship->deadline->format('d M Y')],
                        ['Applications',  $internship->applications->count()],
                    ] as [$label, $value])
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide font-medium">{{ $label }}</dt>
                        <dd class="mt-0.5 text-gray-900 dark:text-white">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Description</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $internship->description }}</p>
            </div>

            @if($internship->rejection_reason)
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-xl p-4">
                <p class="text-sm font-medium text-red-700">Previous Rejection Reason</p>
                <p class="text-sm text-red-600 mt-1">{{ $internship->rejection_reason }}</p>
            </div>
            @endif

            {{-- Approval Actions --}}
            @if($internship->status === 'pending')
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Review Decision</h3>
                <div class="flex flex-wrap gap-3">
                    <form method="POST" action="{{ route('admin.internships.approve', $internship) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit" onclick="return confirm('Approve this internship? It will be published immediately.')"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve & Publish
                        </button>
                    </form>

                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="inline-flex items-center gap-2 border border-red-300 text-red-600 hover:bg-red-50 px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            Reject
                        </button>
                        <div x-show="open" class="mt-3">
                            <form method="POST" action="{{ route('admin.internships.reject', $internship) }}" class="flex gap-2">
                                @csrf @method('PATCH')
                                <textarea name="rejection_reason" required rows="2" placeholder="Rejection reason..."
                                          class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm"></textarea>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shrink-0">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
