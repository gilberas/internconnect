<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Internships</h2>
            @if(auth()->user()->companyProfile?->isVerified())
            <a href="{{ route('company.internships.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Post Internship
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                @if($internships->isEmpty())
                    <div class="py-16 text-center text-gray-400">No internships posted yet.</div>
                @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-left text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3">Title</th>
                            <th class="px-5 py-3">Category</th>
                            <th class="px-5 py-3">Deadline</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($internships as $i)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-5 py-4">
                                <a href="{{ route('company.internships.show', $i) }}"
                                   class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $i->title }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-gray-500">{{ $i->category->name }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $i->deadline->format('d M Y') }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$i->status"/></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('company.internships.show', $i) }}"
                                       class="text-xs text-blue-600 hover:underline">View</a>
                                    @if($i->isEditable())
                                    <a href="{{ route('company.internships.edit', $i) }}"
                                       class="text-xs text-gray-500 hover:underline">Edit</a>
                                    @endif
                                    @if($i->status === 'approved')
                                    <form method="POST" action="{{ route('company.internships.close', $i) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-red-500 hover:underline"
                                                onclick="return confirm('Close this internship?')">Close</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $internships->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
