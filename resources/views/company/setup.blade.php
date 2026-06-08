<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Set Up Your Company</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <p class="text-sm font-medium text-red-700 dark:text-red-300 mb-1">Please fix the following:</p>
                    <ul class="text-sm text-red-600 dark:text-red-400 list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div x-data="{
                step: {{ $errors->any() ? 1 : 1 }},
                companyName: '{{ old('company_name', $profile?->company_name ?? '') }}',
                regNumber:   '{{ old('registration_number', $profile?->registration_number ?? '') }}',
                contact:     '{{ old('contact_person', $profile?->contact_person ?? '') }}',
                phone:       '{{ old('phone', $profile?->phone ?? '') }}',
                address:     '{{ old('address', $profile?->address ?? '') }}',
                get canAdvance() {
                    return this.companyName.trim() !== ''
                        && this.regNumber.trim() !== ''
                        && this.contact.trim() !== ''
                        && this.phone.trim() !== ''
                        && this.address.trim() !== '';
                }
            }">

                {{-- Step indicators ──────────────────────────────────────────── --}}
                <div class="flex items-start justify-center gap-2 mb-8">
                    <div class="flex flex-col items-center gap-1">
                        <div :class="step >= 1 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'"
                             class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all">1</div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Company Info</span>
                    </div>
                    <div :class="step >= 2 ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-700'"
                         class="h-0.5 w-20 mt-4 transition-colors"></div>
                    <div class="flex flex-col items-center gap-1">
                        <div :class="step >= 2 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'"
                             class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all">2</div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Documents</span>
                    </div>
                </div>

                <form action="{{ route('company.setup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ──────────────────── STEP 1: Company Information ────────────────────── --}}
                    <div x-show="step === 1"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8">
                            <div class="mb-5">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Company Information</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Tell us about your organisation.</p>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">

                                {{-- Company Name --}}
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        Company Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="company_name" x-model="companyName"
                                           value="{{ old('company_name', $profile?->company_name) }}"
                                           required placeholder="e.g. Acme Tanzania Ltd"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-1.5"/>
                                </div>

                                {{-- Registration Number --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        BRELA Registration No. <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="registration_number" x-model="regNumber"
                                           value="{{ old('registration_number', $profile?->registration_number) }}"
                                           required placeholder="e.g. 12345678"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('registration_number')" class="mt-1.5"/>
                                </div>

                                {{-- Contact Person --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        Contact Person <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="contact_person" x-model="contact"
                                           value="{{ old('contact_person', $profile?->contact_person) }}"
                                           required placeholder="Full name of HR representative"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('contact_person')" class="mt-1.5"/>
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        Phone <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="phone" x-model="phone"
                                           value="{{ old('phone', $profile?->phone) }}"
                                           required placeholder="+255 XXX XXX XXX"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('phone')" class="mt-1.5"/>
                                </div>

                                {{-- Website --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Website</label>
                                    <input type="url" name="website"
                                           value="{{ old('website', $profile?->website) }}"
                                           placeholder="https://yourcompany.co.tz"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('website')" class="mt-1.5"/>
                                </div>

                                {{-- Address --}}
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        Physical Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="address" x-model="address" required rows="3"
                                              placeholder="Street, City, Region"
                                              class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address', $profile?->address) }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-1.5"/>
                                </div>

                                {{-- Logo --}}
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        Company Logo <span class="text-gray-400 font-normal">(optional)</span>
                                    </label>
                                    <input type="file" name="logo" accept="image/*"
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                  file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                  file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG · max 2 MB</p>
                                    <x-input-error :messages="$errors->get('logo')" class="mt-1.5"/>
                                </div>

                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button"
                                        @click="canAdvance && (step = 2)"
                                        :class="canAdvance
                                            ? 'bg-blue-600 hover:bg-blue-700 text-white'
                                            : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
                                        class="px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    Next: Upload Documents →
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ──────────────────── STEP 2: Verification Documents ─────────────────── --}}
                    <div x-show="step === 2"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8 space-y-5">

                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Verification Documents</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Required for company verification.</p>
                            </div>

                            {{-- Security notice --}}
                            <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4">
                                <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-xs text-amber-700 dark:text-amber-300">
                                    All documents are stored securely and only visible to admins during the verification process.
                                </p>
                            </div>

                            {{-- BRELA Certificate --}}
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            BRELA Certificate <span class="text-red-500">*</span>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Business Registration Certificate from BRELA</p>
                                    </div>
                                </div>
                                <input type="file" name="brela_document" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                              file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                                <p class="text-xs text-gray-400">PDF, JPG, PNG · max 5 MB</p>
                                <x-input-error :messages="$errors->get('brela_document')" class="mt-1"/>
                            </div>

                            {{-- NIDA --}}
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            NIDA Identification <span class="text-red-500">*</span>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">National ID of the contact person</p>
                                    </div>
                                </div>
                                <input type="file" name="nida_document" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                              file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                                <p class="text-xs text-gray-400">PDF, JPG, PNG · max 5 MB</p>
                                <x-input-error :messages="$errors->get('nida_document')" class="mt-1"/>
                            </div>

                            {{-- TRA --}}
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                  d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">TRA Certificate</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tax Registration Certificate (optional but recommended)</p>
                                    </div>
                                </div>
                                <input type="file" name="tra_document" accept=".pdf,.jpg,.jpeg,.png"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                              file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-300">
                                <p class="text-xs text-gray-400">PDF, JPG, PNG · max 5 MB · Optional</p>
                                <x-input-error :messages="$errors->get('tra_document')" class="mt-1"/>
                            </div>

                            <div class="pt-1 flex justify-between">
                                <button type="button" @click="step = 1"
                                        class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    ← Back
                                </button>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-7 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    Submit for Verification
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
