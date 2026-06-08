<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Internships</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex flex-wrap gap-3 mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..."
                       class="flex-1 min-w-48 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500"/>
                <select name="status" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    @foreach(['pending','approved','rejected','closed'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Filter</button>
            </form>

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3 text-left">Internship</th>
                            <th class="px-5 py-3 text-left">Company</th>
                            <th class="px-5 py-3 text-left">Deadline</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($internships as $i)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50">
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.internships.show', $i) }}"
                                   class="font-medium text-gray-900 dark:text-white hover:text-blue-600">
                                    {{ $i->title }}
                                </a>
                                <p class="text-xs text-gray-500">{{ $i->category->name }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-500 text-xs">{{ $i->company->company_name }}</td>
                            <td class="px-5 py-4 text-gray-500 text-xs">{{ $i->deadline->format('d M Y') }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$i->status"/></td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.internships.show', $i) }}" class="text-xs text-blue-600 hover:underline">Review</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No internships found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $internships->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
