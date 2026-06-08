<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Complete Your Profile</h2>
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
                step: 1,
                skillsText: @js(implode(', ', old('skills', $profile?->skills ?? []))),
                get skillsArray() {
                    return this.skillsText.split(',').map(s => s.trim()).filter(s => s !== '')
                }
            }">

                {{-- Step Indicators --}}
                <div class="flex items-start justify-center gap-2 mb-8">
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center gap-1">
                        <div :class="step >= 1 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'"
                             class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all">1</div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Personal</span>
                    </div>
                    <div :class="step > 1 ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-700'"
                         class="h-0.5 w-16 mt-4 transition-colors"></div>
                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center gap-1">
                        <div :class="step >= 2 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'"
                             class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all">2</div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Academic</span>
                    </div>
                    <div :class="step > 2 ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-700'"
                         class="h-0.5 w-16 mt-4 transition-colors"></div>
                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center gap-1">
                        <div :class="step >= 3 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-900' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'"
                             class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all">3</div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Documents</span>
                    </div>
                </div>

                {{-- Wizard Form --}}
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Hidden skills[] inputs driven by Alpine --}}
                    <template x-for="(skill, idx) in skillsArray" :key="idx">
                        <input type="hidden" :name="'skills[' + idx + ']'" :value="skill">
                    </template>

                    {{-- ─────────────────────── STEP 1: Personal Info ──────────────────────── --}}
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8 space-y-5">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Personal Information</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Tell us a bit about yourself.</p>
                            </div>

                            {{-- Full Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="full_name"
                                       value="{{ old('full_name', $profile?->full_name) }}"
                                       required placeholder="e.g. Amina Hassan"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('full_name')" class="mt-1.5"/>
                            </div>

                            {{-- Gender --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Gender</label>
                                <select name="gender"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Prefer not to say</option>
                                    <option value="male"   {{ old('gender', $profile?->gender) === 'male'   ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $profile?->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other"  {{ old('gender', $profile?->gender) === 'other'  ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-1.5"/>
                            </div>

                            {{-- Date of Birth --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Date of Birth</label>
                                <input type="date" name="date_of_birth"
                                       value="{{ old('date_of_birth', $profile?->date_of_birth?->format('Y-m-d')) }}"
                                       max="{{ now()->subYears(16)->format('Y-m-d') }}"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1.5"/>
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Phone Number</label>
                                <input type="text" name="phone"
                                       value="{{ old('phone', $profile?->phone) }}"
                                       placeholder="+255 7XX XXX XXX"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-xs text-gray-400">Use +255 format for Tanzania numbers.</p>
                                <x-input-error :messages="$errors->get('phone')" class="mt-1.5"/>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="button" @click="step = 2"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    Next: Academic Info →
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ─────────────────────── STEP 2: Academic Info ──────────────────────── --}}
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8 space-y-5">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Academic Information</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Your educational background.</p>
                            </div>

                            {{-- University --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    University / Institution <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="university"
                                       value="{{ old('university', $profile?->university) }}"
                                       required placeholder="e.g. University of Dar es Salaam"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('university')" class="mt-1.5"/>
                            </div>

                            {{-- Program --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Programme / Course <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="program"
                                       value="{{ old('program', $profile?->program) }}"
                                       required placeholder="e.g. BSc Computer Science"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('program')" class="mt-1.5"/>
                            </div>

                            {{-- Graduation Year --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Expected Graduation Year <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="graduation_year"
                                       value="{{ old('graduation_year', $profile?->graduation_year) }}"
                                       required min="2020" max="2035" placeholder="{{ date('Y') + 1 }}"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('graduation_year')" class="mt-1.5"/>
                            </div>

                            {{-- Skills --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Skills</label>
                                <input type="text" x-model="skillsText"
                                       placeholder="e.g. PHP, Laravel, JavaScript, MySQL"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-xs text-gray-400">Separate skills with commas.</p>
                                <x-input-error :messages="$errors->get('skills')" class="mt-1.5"/>
                            </div>

                            <div class="pt-2 flex justify-between">
                                <button type="button" @click="step = 1"
                                        class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    ← Back
                                </button>
                                <button type="button" @click="step = 3"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    Next: Upload CV →
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ─────────────────────── STEP 3: Documents ─────────────────────────── --}}
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8 space-y-5">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Upload Your CV</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">A PDF CV helps companies review your application faster.</p>
                            </div>

                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-8 text-center">
                                <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <label class="cursor-pointer">
                                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Choose PDF file</span>
                                    <input type="file" name="cv" accept=".pdf" class="hidden">
                                </label>
                                <p class="text-xs text-gray-400 mt-1.5">PDF only · Max 5 MB</p>
                            </div>

                            <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                                <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-xs text-amber-700 dark:text-amber-300">
                                    CV upload is optional here. You can upload or update it anytime from your <strong>Profile</strong> page.
                                </p>
                            </div>

                            <div class="pt-2 flex justify-between">
                                <button type="button" @click="step = 2"
                                        class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    ← Back
                                </button>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-7 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    Save Profile
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
