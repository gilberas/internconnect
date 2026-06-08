<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Users
            </a>
            <span class="text-gray-300 dark:text-gray-600 shrink-0">/</span>
            <span class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold shrink-0
                {{ $user->isStudent() ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' }}">
                {{ ucfirst($user->account_type) }}
            </span>
            <x-status-badge :status="$user->status" class="shrink-0"/>
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

            {{-- Card 1 — Account Info --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">Account Information</h3>

                <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm mb-6">
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Name</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Email</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Account Type</dt>
                        <dd class="text-gray-900 dark:text-white">{{ ucfirst($user->account_type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Joined</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $user->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>

                @if ($user->isSuspended())
                    <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 space-y-2 text-sm">
                        <div>
                            <p class="text-xs font-semibold text-red-700 dark:text-red-300 uppercase tracking-wide mb-0.5">Suspension Reason</p>
                            <p class="text-red-600 dark:text-red-400">{{ $user->suspended_reason }}</p>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-red-700 dark:text-red-300 uppercase tracking-wide mb-0.5">Suspended At</p>
                                <p class="text-red-600 dark:text-red-400 text-xs">{{ $user->suspended_at?->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-red-700 dark:text-red-300 uppercase tracking-wide mb-0.5">Suspended By</p>
                                <p class="text-red-600 dark:text-red-400 text-xs">
                                    @if ($user->suspended_by)
                                        {{ \App\Models\User::find($user->suspended_by)?->name ?? 'Unknown admin' }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.reactivate', $user) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                            Reactivate Account
                        </button>
                    </form>
                @else
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="inline-flex items-center gap-2 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
                            Suspend Account
                        </button>
                        <div x-show="open" x-cloak class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                            <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="space-y-3">
                                @csrf @method('PATCH')
                                <div>
                                    <label class="block text-xs font-medium text-red-700 dark:text-red-300 mb-1.5">
                                        Suspension Reason <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="suspended_reason" required rows="3"
                                              placeholder="Reason for suspension (min 10 characters)..."
                                              class="w-full rounded-xl border-red-300 dark:border-red-700 dark:bg-gray-800 text-sm focus:ring-red-500 resize-none">{{ old('suspended_reason') }}</textarea>
                                    @error('suspended_reason')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                                        Confirm Suspension
                                    </button>
                                    <button type="button" @click="open = false"
                                            class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-sm text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Card 2 — Profile Info --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">
                    {{ $user->isStudent() ? 'Student Profile' : 'Company Profile' }}
                </h3>

                @if ($user->isStudent() && $user->studentProfile)
                    @php $sp = $user->studentProfile; @endphp
                    <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">University</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $sp->university ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Program</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $sp->program ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Graduation Year</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $sp->graduation_year ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">CV Uploaded</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $sp->hasCv() ? 'Yes' : 'No' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-2">Profile Completion</dt>
                            <dd>
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all"
                                             style="width: {{ $sp->completion_percentage ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 shrink-0">
                                        {{ $sp->completion_percentage ?? 0 }}%
                                    </span>
                                </div>
                            </dd>
                        </div>
                    </dl>
                @elseif ($user->isCompany() && $user->companyProfile)
                    @php $cp = $user->companyProfile; @endphp
                    <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Company Name</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $cp->company_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Registration Number</dt>
                            <dd class="text-gray-900 dark:text-white font-mono text-xs">{{ $cp->registration_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Verification Status</dt>
                            <dd><x-status-badge :status="$cp->verification_status"/></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Documents</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $cp->documents->count() }} uploaded</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Phone</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $cp->phone ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Address</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $cp->address ?? '—' }}</dd>
                        </div>
                    </dl>
                @else
                    <p class="text-sm text-gray-400 italic">No profile set up yet.</p>
                @endif
            </div>

            {{-- Card 3 — Activity --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">
                        {{ $user->isStudent() ? 'Recent Applications' : 'Internships' }}
                    </h3>
                </div>

                @if ($user->isStudent())
                    @php $apps = $user->studentProfile?->applications()->with('internship')->latest()->take(5)->get() ?? collect(); @endphp
                    @if ($apps->isEmpty())
                        <div class="px-6 py-8 text-center text-gray-400 text-sm">No applications yet.</div>
                    @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($apps as $app)
                        <div class="px-6 py-3 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $app->internship->title }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $app->created_at->format('d M Y') }}</p>
                            </div>
                            <x-status-badge :status="$app->status"/>
                        </div>
                        @endforeach
                    </div>
                    @endif
                @elseif ($user->isCompany())
                    @php $internships = $user->companyProfile?->internships ?? collect(); @endphp
                    @if ($internships->isEmpty())
                        <div class="px-6 py-8 text-center text-gray-400 text-sm">No internships posted.</div>
                    @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($internships as $i)
                        <div class="px-6 py-3 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('admin.internships.show', $i) }}"
                                   class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate block">
                                    {{ $i->title }}
                                </a>
                                <p class="text-xs text-gray-400">Deadline {{ $i->deadline->format('d M Y') }}</p>
                            </div>
                            <x-status-badge :status="$i->status"/>
                        </div>
                        @endforeach
                    </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
