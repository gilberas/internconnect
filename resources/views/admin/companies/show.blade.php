<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('admin.companies.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Companies
            </a>
            <span class="text-gray-300 dark:text-gray-600 shrink-0">/</span>
            <span class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $company->company_name }}</span>
            <x-status-badge :status="$company->verification_status" class="shrink-0"/>
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

            {{-- Card 1 — Company Details --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">Company Information</h3>
                <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    @foreach ([
                        ['Company Name',        $company->company_name],
                        ['Registration Number', $company->registration_number],
                        ['Contact Person',      $company->contact_person],
                        ['Phone',               $company->phone ?? '—'],
                        ['Address',             $company->address ?? '—'],
                        ['Website',             $company->website ?? '—'],
                        ['Account Email',       $company->user->email],
                        ['Registered',          $company->created_at->format('d M Y')],
                    ] as [$label, $value])
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">{{ $label }}</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            {{-- Card 2 — Verification Documents --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-4">Verification Documents</h3>

                @if ($company->documents->isEmpty())
                    <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-amber-700 dark:text-amber-300">No documents uploaded yet.</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach ($company->documents as $doc)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-xl gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $doc->labelForType() }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $doc->original_filename }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 shrink-0">
                                <span class="text-xs text-gray-400 whitespace-nowrap">
                                    {{ $doc->uploaded_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('company.documents.download', $doc) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Card 3 — Decision Panel --}}
            @if ($company->isPending() || $company->isRejected())
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-5">Verification Decision</h3>

                @if ($company->isRejected())
                    <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                        <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-1">Previous Rejection Reason</p>
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $company->rejection_reason }}</p>
                    </div>
                @endif

                <div class="flex flex-wrap gap-3" x-data="{ open: false }">
                    {{-- Approve --}}
                    <form method="POST" action="{{ route('admin.companies.verify', $company) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                onclick="return confirm('Verify this company? They will be able to post internships.')"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve & Verify
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
                            <form method="POST" action="{{ route('admin.companies.reject', $company) }}" class="space-y-3">
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
            @elseif ($company->isVerified())
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Verified since {{ $company->verified_at?->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Revoking will reset status to pending and close all active internships.</p>
                    </div>
                    <form method="POST" action="{{ route('admin.companies.revoke', $company) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                onclick="return confirm('Revoke verification? All active internships will be closed.')"
                                class="text-sm font-medium text-red-600 dark:text-red-400 hover:underline">
                            Revoke Verification
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Company Internships --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">
                        Internships ({{ $company->internships->count() }})
                    </h3>
                </div>
                @if ($company->internships->isEmpty())
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">No internships posted yet.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                <tr>
                                    <th class="px-5 py-3 text-left">Title</th>
                                    <th class="px-5 py-3 text-left">Deadline</th>
                                    <th class="px-5 py-3 text-left">Applications</th>
                                    <th class="px-5 py-3 text-left">Status</th>
                                    <th class="px-5 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                @foreach ($company->internships as $i)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $i->title }}</td>
                                    <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">{{ $i->deadline->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $i->applications->count() }}</td>
                                    <td class="px-5 py-3"><x-status-badge :status="$i->status"/></td>
                                    <td class="px-5 py-3">
                                        <a href="{{ route('admin.internships.show', $i) }}"
                                           class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
