<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('admin.internships.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Internships
            </a>
            <span class="text-gray-300 dark:text-gray-600 shrink-0">/</span>
            <span class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $internship->title }}</span>
            <x-status-badge :status="$internship->status" class="shrink-0"/>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Info grid --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">Internship Details</h3>
                <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    @foreach ([
                        ['Company',      $internship->company->company_name],
                        ['Category',     $internship->category->name],
                        ['Type',         $internship->typeLabel()],
                        ['Location',     $internship->location],
                        ['Duration',     $internship->duration],
                        ['Positions',    $internship->positions],
                        ['Deadline',     $internship->deadline->format('d M Y')],
                        ['Applications', $internship->applications->count()],
                    ] as [$label, $value])
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">{{ $label }}</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $value }}</dd>
                    </div>
                    @endforeach
                    @if ($internship->approvedBy)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Approved By</dt>
                        <dd class="text-gray-900 dark:text-white">
                            {{ $internship->approvedBy->name }}
                            <span class="text-gray-400 text-xs ml-1">· {{ $internship->approved_at->format('d M Y, H:i') }}</span>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Description --}}
            <div x-data="{ open: true }"
                 class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-6 py-4 text-left">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">Description</h3>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="px-6 pb-6 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $internship->description }}</p>
                </div>
            </div>

            {{-- Requirements --}}
            <div x-data="{ open: false }"
                 class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-6 py-4 text-left">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">Requirements</h3>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="px-6 pb-6 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $internship->requirements }}</p>
                </div>
            </div>

            {{-- Responsibilities --}}
            <div x-data="{ open: false }"
                 class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-6 py-4 text-left">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">Responsibilities</h3>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="px-6 pb-6 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $internship->responsibilities }}</p>
                </div>
            </div>

            {{-- Rejection reason box --}}
            @if ($internship->rejection_reason)
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-5">
                <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-1 uppercase tracking-wide">Rejection Reason</p>
                <p class="text-sm text-red-600 dark:text-red-400">{{ $internship->rejection_reason }}</p>
            </div>
            @endif

            {{-- Decision Panel (pending or rejected) --}}
            @if (in_array($internship->status, ['pending', 'rejected']))
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6"
                 x-data="{ open: false }">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">Review Decision</h3>

                <div class="flex flex-wrap gap-3">
                    {{-- Approve --}}
                    <form method="POST" action="{{ route('admin.internships.approve', $internship) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                onclick="return confirm('Approve this internship? It will be published immediately.')"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve & Publish
                        </button>
                    </form>

                    {{-- Reject --}}
                    <div>
                        <button @click="open = !open"
                                class="inline-flex items-center gap-2 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject
                        </button>
                        <div x-show="open" x-cloak class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                            <form method="POST" action="{{ route('admin.internships.reject', $internship) }}" class="space-y-3">
                                @csrf @method('PATCH')
                                <div>
                                    <label class="block text-xs font-medium text-red-700 dark:text-red-300 mb-1.5">
                                        Rejection Reason <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="rejection_reason" required rows="3"
                                              placeholder="Provide a clear reason for rejection (minimum 10 characters)..."
                                              class="w-full rounded-xl border-red-300 dark:border-red-700 dark:bg-gray-800 text-sm focus:ring-red-500 focus:border-red-500 resize-none">{{ old('rejection_reason') }}</textarea>
                                    @error('rejection_reason')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                                        Submit Rejection
                                    </button>
                                    <button type="button" @click="open = false"
                                            class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-sm text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
