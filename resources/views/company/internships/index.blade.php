<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Internships</h2>
            @if (auth()->user()->companyProfile?->isVerified())
                <a href="{{ route('company.internships.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Post Internship
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Filter tabs --}}
            <div class="flex flex-wrap gap-1.5">
                @foreach ([''] + ['pending', 'approved', 'rejected', 'closed'] as $tab)
                    @php
                        $label = $tab === '' ? 'All' : ucfirst($tab);
                        $active = request('status', '') === $tab;
                    @endphp
                    <a href="{{ route('company.internships.index', $tab ? ['status' => $tab] : []) }}"
                       class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors
                              {{ $active
                                  ? 'bg-blue-600 text-white'
                                  : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                @if ($internships->isEmpty())
                    <div class="py-20 text-center">
                        <div class="w-14 h-14 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">No internships yet.</p>
                        @if (auth()->user()->companyProfile?->isVerified())
                            <a href="{{ route('company.internships.create') }}"
                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                Post Your First Internship
                            </a>
                        @endif
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                <tr>
                                    <th class="px-5 py-3 text-left">Title</th>
                                    <th class="px-5 py-3 text-left">Category</th>
                                    <th class="px-5 py-3 text-left">Type</th>
                                    <th class="px-5 py-3 text-left">Deadline</th>
                                    <th class="px-5 py-3 text-center">Apps</th>
                                    <th class="px-5 py-3 text-left">Status</th>
                                    <th class="px-5 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                @foreach ($internships as $i)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <a href="{{ route('company.internships.show', $i) }}"
                                           class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors line-clamp-1 max-w-[200px] block">
                                            {{ $i->title }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 text-xs">
                                        {{ $i->category->name }}
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                        {{ $i->typeLabel() }}
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                        {{ $i->deadline->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <a href="{{ route('company.applicants.index', $i) }}"
                                           class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $i->applications->count() }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <x-status-badge :status="$i->status"/>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3 whitespace-nowrap">
                                            <a href="{{ route('company.internships.show', $i) }}"
                                               class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                                View
                                            </a>
                                            @if ($i->isEditable())
                                                <a href="{{ route('company.internships.edit', $i) }}"
                                                   class="text-xs text-gray-500 dark:text-gray-400 hover:underline font-medium">
                                                    Edit
                                                </a>
                                            @endif
                                            @if ($i->status === 'approved')
                                                <form method="POST"
                                                      action="{{ route('company.internships.close', $i) }}"
                                                      class="inline">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                            class="text-xs text-amber-600 dark:text-amber-400 hover:underline font-medium"
                                                            onclick="return confirm('Close this internship? Students will no longer be able to apply.')">
                                                        Close
                                                    </button>
                                                </form>
                                            @endif
                                            @if (in_array($i->status, ['pending', 'rejected']))
                                                <form method="POST"
                                                      action="{{ route('company.internships.destroy', $i) }}"
                                                      class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="text-xs text-red-500 dark:text-red-400 hover:underline font-medium"
                                                            onclick="return confirm('Delete this internship? This cannot be undone.')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($internships->hasPages())
                        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                            {{ $internships->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
