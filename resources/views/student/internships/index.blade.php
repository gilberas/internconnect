<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Browse Internships</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Search & Filters --}}
            <form method="GET" action="{{ route('student.internships.index') }}"
                  class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 mb-6 flex flex-wrap gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by title or keyword..."
                       class="flex-1 min-w-48 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500"/>

                <select name="category" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500 min-w-40">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="type" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="full_time"  {{ request('type') == 'full_time'  ? 'selected' : '' }}>Full-time</option>
                    <option value="part_time"  {{ request('type') == 'part_time'  ? 'selected' : '' }}>Part-time</option>
                    <option value="remote"     {{ request('type') == 'remote'     ? 'selected' : '' }}>Remote</option>
                </select>

                <input type="text" name="location" value="{{ request('location') }}"
                       placeholder="Location..."
                       class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500 w-36"/>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Search
                </button>
                @if(request()->hasAny(['search','category','type','location']))
                    <a href="{{ route('student.internships.index') }}"
                       class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg">
                        Clear
                    </a>
                @endif
            </form>

            {{-- Results Info --}}
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Showing {{ $internships->firstItem() ?? 0 }}–{{ $internships->lastItem() ?? 0 }}
                of {{ $internships->total() }} internships
            </p>

            {{-- Grid --}}
            @if($internships->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>No internships found. Try adjusting your filters.</p>
                </div>
            @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($internships as $internship)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow flex flex-col">
                    <div class="p-5 flex-1">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div>
                                <a href="{{ route('student.internships.show', $internship) }}"
                                   class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 line-clamp-2">
                                    {{ $internship->title }}
                                </a>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $internship->company->company_name }}</p>
                            </div>
                            {{-- Save toggle --}}
                            <form method="POST" action="{{ route('student.internships.save', $internship) }}" class="shrink-0">
                                @csrf
                                <button type="submit" title="{{ $savedIds->contains($internship->id) ? 'Remove from saved' : 'Save' }}">
                                    <svg class="w-5 h-5 {{ $savedIds->contains($internship->id) ? 'text-blue-600 fill-current' : 'text-gray-400' }}"
                                         fill="{{ $savedIds->contains($internship->id) ? 'currentColor' : 'none' }}"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs rounded-full">
                                {{ $internship->category->name }}
                            </span>
                            <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs rounded-full">
                                {{ $internship->typeLabel() }}
                            </span>
                        </div>

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

                    <div class="px-5 pb-5">
                        <a href="{{ route('student.internships.show', $internship) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                            View & Apply
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $internships->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>
