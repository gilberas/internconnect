<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Internship Categories</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Add Category --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-4">Add New Category</h3>
                <form method="POST" action="{{ route('admin.categories.store') }}" class="flex flex-wrap gap-3 items-end">
                    @csrf
                    <div class="flex-1 min-w-40">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="e.g. Software Engineering"
                               class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    </div>
                    <div class="flex-1 min-w-40">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Description</label>
                        <input type="text" name="description" value="{{ old('description') }}"
                               placeholder="Short description (optional)"
                               class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    </div>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap">
                        Add Category
                    </button>
                </form>
                @error('name')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Categories table --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 text-left">Name + Description</th>
                                <th class="px-5 py-3 text-center">Internships</th>
                                <th class="px-5 py-3 text-left">Status</th>
                                <th class="px-5 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse ($categories as $cat)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors {{ ! $cat->is_active ? 'opacity-60' : '' }}">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $cat->name }}</p>
                                    @if ($cat->description)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $cat->description }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $cat->internships_count }}
                                </td>
                                <td class="px-5 py-4">
                                    <x-status-badge :status="$cat->is_active ? 'active' : 'closed'"/>
                                </td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('admin.categories.toggle', $cat) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                class="text-xs font-medium hover:underline {{ $cat->is_active ? 'text-red-500 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                            {{ $cat->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center text-gray-400 text-sm">No categories yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
