<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">User Management</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex flex-wrap gap-3 mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..."
                       class="flex-1 min-w-48 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500"/>
                <select name="type" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="student" {{ request('type') == 'student' ? 'selected' : '' }}>Students</option>
                    <option value="company" {{ request('type') == 'company' ? 'selected' : '' }}>Companies</option>
                </select>
                <select name="status" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Filter</button>
            </form>

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3 text-left">User</th>
                            <th class="px-5 py-3 text-left">Type</th>
                            <th class="px-5 py-3 text-left">Joined</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50">
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-0.5 text-xs rounded-full
                                    {{ $user->account_type == 'student' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ ucfirst($user->account_type) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$user->status"/></td>
                            <td class="px-5 py-4">
                                @if($user->status === 'active')
                                    <div x-data="{ open: false }">
                                        <button @click="open = !open" class="text-xs text-red-500 hover:underline">Suspend</button>
                                        <div x-show="open" class="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                            <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="flex gap-2">
                                                @csrf @method('PATCH')
                                                <input type="text" name="suspended_reason" required placeholder="Reason..."
                                                       class="flex-1 rounded border-gray-300 text-xs dark:border-gray-700 dark:bg-gray-900"/>
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('admin.users.reactivate', $user) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-emerald-600 hover:underline">Reactivate</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
