<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Internship Categories</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Add Category --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Add New Category</h3>
                <form method="POST" action="{{ route('admin.categories.store') }}" class="flex flex-wrap gap-3">
                    @csrf
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Category name..."
                           class="flex-1 min-w-48 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500"/>
                    <input type="text" name="description" value="{{ old('description') }}" placeholder="Short description (optional)"
                           class="flex-1 min-w-48 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500"/>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                        Add Category
                    </button>
                </form>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            {{-- Categories List --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3 text-left">Name</th>
                            <th class="px-5 py-3 text-left">Internships</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $cat->name }}</p>
                                @if($cat->description)
                                <p class="text-xs text-gray-500">{{ $cat->description }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-500">{{ $cat->internships_count }}</td>
                            <td class="px-5 py-4">
                                <x-status-badge :status="$cat->is_active ? 'active' : 'closed'"/>
                            </td>
                            <td class="px-5 py-4">
                                <form method="POST" action="{{ route('admin.categories.toggle', $cat) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-xs {{ $cat->is_active ? 'text-red-500' : 'text-emerald-600' }} hover:underline">
                                        {{ $cat->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">No categories yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
