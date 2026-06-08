<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Saved Internships</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            @if ($saved->isEmpty())
                {{-- Empty state --}}
                <div class="text-center py-20 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">No saved internships yet</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Bookmark internships you're interested in and find them here.
                    </p>
                    <a href="{{ route('student.internships.index') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Browse Internships
                    </a>
                </div>
            @else
                <div class="flex items-center justify-between mb-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $saved->total() }} saved {{ Str::plural('internship', $saved->total()) }}
                    </p>
                    <a href="{{ route('student.internships.index') }}"
                       class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Browse more →
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($saved as $item)
                        @php $internship = $item->internship @endphp
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow flex flex-col">
                            <div class="p-5 flex-1">

                                {{-- Title + remove button --}}
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('student.internships.show', $internship) }}"
                                           class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 line-clamp-2 text-sm leading-snug">
                                            {{ $internship->title }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ $internship->company->company_name }}
                                        </p>
                                    </div>

                                    {{-- Remove / unsave --}}
                                    <form method="POST"
                                          action="{{ route('student.internships.save', $internship) }}"
                                          class="shrink-0">
                                        @csrf
                                        <button type="submit"
                                                title="Remove from saved"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 dark:text-blue-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-500 transition-colors">
                                            <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24">
                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                {{-- Badges --}}
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs rounded-full">
                                        {{ $internship->category->name }}
                                    </span>
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs rounded-full">
                                        {{ $internship->typeLabel() }}
                                    </span>
                                    @if (! $internship->isOpen())
                                        <span class="px-2 py-0.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full">Expired</span>
                                    @endif
                                </div>

                                {{-- Meta --}}
                                <div class="space-y-1 text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        {{ $internship->location }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Deadline: {{ $internship->deadline->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="px-5 pb-5 flex gap-2">
                                <a href="{{ route('student.internships.show', $internship) }}"
                                   class="flex-1 block text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-xl transition-colors">
                                    View & Apply
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $saved->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>
