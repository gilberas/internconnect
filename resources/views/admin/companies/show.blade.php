<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.companies.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $company->company_name }}</h2>
            <x-status-badge :status="$company->verification_status"/>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Company Details --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Company Information</h3>
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    @foreach([
                        ['Company Name',         $company->company_name],
                        ['Registration Number',  $company->registration_number],
                        ['Contact Person',       $company->contact_person],
                        ['Phone',                $company->phone],
                        ['Address',              $company->address],
                        ['Website',              $company->website ?? '—'],
                        ['Account Email',        $company->user->email],
                        ['Registered',           $company->created_at->format('d M Y')],
                    ] as [$label, $value])
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide font-medium">{{ $label }}</dt>
                        <dd class="mt-0.5 text-gray-900 dark:text-white">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            {{-- Documents --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Verification Documents</h3>
                @if($company->documents->isEmpty())
                    <p class="text-sm text-gray-400">No documents uploaded.</p>
                @else
                <div class="space-y-2">
                    @foreach($company->documents as $doc)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $doc->labelForType() }}</p>
                                <p class="text-xs text-gray-500">{{ $doc->original_filename }}</p>
                            </div>
                        </div>
                        {{-- In production: use signed URL for private storage --}}
                        <span class="text-xs text-gray-400">{{ $doc->uploaded_at->format('d M Y') }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Actions --}}
            @if($company->isPending() || $company->isRejected())
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Verification Decision</h3>
                <div class="flex flex-wrap gap-3">
                    {{-- Approve --}}
                    <form method="POST" action="{{ route('admin.companies.verify', $company) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit" onclick="return confirm('Verify this company?')"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve & Verify
                        </button>
                    </form>

                    {{-- Reject (inline form) --}}
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="inline-flex items-center gap-2 border border-red-300 text-red-600 hover:bg-red-50 px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject
                        </button>
                        <div x-show="open" class="mt-3">
                            <form method="POST" action="{{ route('admin.companies.reject', $company) }}" class="flex gap-2">
                                @csrf @method('PATCH')
                                <textarea name="rejection_reason" required rows="2" placeholder="Provide a reason for rejection..."
                                          class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-red-500 focus:border-red-500"></textarea>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 shrink-0">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($company->isVerified())
            <div class="text-right">
                <form method="POST" action="{{ route('admin.companies.revoke', $company) }}" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" onclick="return confirm('Revoke verification? All active internships will be closed.')"
                            class="text-sm text-red-600 hover:underline">
                        Revoke Verification
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
