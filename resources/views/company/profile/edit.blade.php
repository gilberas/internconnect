<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Company Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Verification status banner --}}
            @if ($profile->isPending())
                <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">Verification Pending</p>
                        <p class="text-xs text-amber-700 dark:text-amber-400 mt-0.5">
                            Our team is reviewing your documents. This usually takes up to 24 hours.
                        </p>
                    </div>
                </div>
            @elseif ($profile->isVerified())
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">Company Verified</p>
                </div>
            @elseif ($profile->isRejected())
                <div class="flex items-start gap-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl p-4">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-700 dark:text-red-300">Verification Rejected</p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $profile->rejection_reason }}</p>
                        <a href="{{ route('company.setup') }}" class="text-xs text-red-600 dark:text-red-400 underline mt-1 inline-block">
                            Resubmit Documents →
                        </a>
                    </div>
                </div>
            @endif

            {{-- ─── Card 1: Company Info ──────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Company Information</h3>
                </div>

                <div class="p-6 space-y-5">

                    {{-- Read-only fields --}}
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Company Name</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $profile->company_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Registration Number</p>
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $profile->registration_number }}</p>
                                @if ($profile->isVerified())
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        BRELA Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Editable fields --}}
                    <form action="{{ route('company.profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Contact Person <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="contact_person"
                                       value="{{ old('contact_person', $profile->contact_person) }}"
                                       required
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('contact_person')" class="mt-1.5"/>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone"
                                       value="{{ old('phone', $profile->phone) }}"
                                       required
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('phone')" class="mt-1.5"/>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Physical Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="address" required rows="2"
                                          class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address', $profile->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-1.5"/>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Website</label>
                                <input type="url" name="website"
                                       value="{{ old('website', $profile->website) }}"
                                       placeholder="https://..."
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('website')" class="mt-1.5"/>
                            </div>
                        </div>

                        {{-- Logo --}}
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Logo</p>
                            @if ($profile->logo_path)
                                <div class="flex items-center gap-4 mb-3">
                                    <img src="{{ asset('storage/' . $profile->logo_path) }}"
                                         alt="Company logo"
                                         class="w-16 h-16 object-contain rounded-xl border border-gray-200 dark:border-gray-700 p-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Current logo</p>
                                </div>
                            @endif
                            <input type="file" name="logo" accept="image/*"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                          file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG · max 2 MB (leave empty to keep current)</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ─── Card 2: Uploaded Documents ───────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Verification Documents</h3>
                </div>

                <div class="p-6">
                    @if ($profile->documents->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-4">No documents uploaded yet.</p>
                    @else
                        <div class="space-y-3">
                            @foreach ($profile->documents as $doc)
                                <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="w-9 h-9 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $doc->labelForType() }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $doc->original_filename }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                            Uploaded {{ ($doc->uploaded_at ?? $doc->created_at)?->format('d M Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('company.documents.download', $doc) }}"
                                       class="shrink-0 text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-4">
                            To update or replace documents, please contact support.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
