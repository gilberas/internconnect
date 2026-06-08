<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash message (for student profile updates only, not account settings) --}}
            @if (session('status') && ! in_array(session('status'), ['profile-updated', 'password-updated']))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- ─── Photo + Completion ────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">

                    {{-- Avatar --}}
                    <div class="shrink-0">
                        @if ($profile?->profile_photo_path)
                            <img src="{{ asset('storage/' . $profile->profile_photo_path) }}"
                                 alt="Profile photo"
                                 class="w-24 h-24 rounded-full object-cover ring-4 ring-blue-100 dark:ring-blue-900">
                        @else
                            <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center ring-4 ring-blue-100 dark:ring-blue-900">
                                <span class="text-2xl font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Name + completion --}}
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $profile?->full_name ?? auth()->user()->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>

                        {{-- Completion bar --}}
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Profile completion</span>
                                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $profile?->completion_percentage ?? 0 }}%
                                </span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all"
                                     style="width: {{ $profile?->completion_percentage ?? 0 }}%"></div>
                            </div>
                            @if (($profile?->completion_percentage ?? 0) < 100)
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    Fill in all fields to reach 100% and stand out to companies.
                                </p>
                            @else
                                <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium mt-1">Profile complete!</p>
                            @endif
                        </div>
                    </div>

                    {{-- Photo upload form --}}
                    <div class="shrink-0">
                        <form action="{{ route('student.profile.photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="cursor-pointer flex flex-col items-center gap-1.5 group">
                                <input type="file" name="photo" accept=".jpg,.jpeg,.png"
                                       class="hidden" onchange="this.form.submit()">
                                <span class="text-xs font-medium text-blue-600 dark:text-blue-400 group-hover:underline">
                                    Change Photo
                                </span>
                                <span class="text-xs text-gray-400">JPG, PNG · max 2 MB</span>
                            </label>
                            <x-input-error :messages="$errors->get('photo')" class="mt-1"/>
                        </form>
                    </div>

                </div>
            </div>

            {{-- ─── Personal Info Form ──────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Personal Information</h3>
                </div>

                <form action="{{ route('student.profile.update') }}" method="POST" class="p-6 space-y-5"
                      x-data="{
                          skillsText: @js(implode(', ', $profile?->skills ?? [])),
                          get skillsArray() {
                              return this.skillsText.split(',').map(s => s.trim()).filter(s => s !== '')
                          }
                      }">
                    @csrf
                    @method('PUT')

                    {{-- Hidden skills[] inputs --}}
                    <template x-for="(skill, idx) in skillsArray" :key="idx">
                        <input type="hidden" :name="'skills[' + idx + ']'" :value="skill">
                    </template>

                    <div class="grid sm:grid-cols-2 gap-5">
                        {{-- Full Name --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name"
                                   value="{{ old('full_name', $profile?->full_name) }}"
                                   required
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
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Phone</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', $profile?->phone) }}"
                                   placeholder="+255 7XX XXX XXX"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('phone')" class="mt-1.5"/>
                        </div>

                        {{-- University --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                University <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="university"
                                   value="{{ old('university', $profile?->university) }}"
                                   required
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('university')" class="mt-1.5"/>
                        </div>

                        {{-- Program --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Programme <span class="text-red-500">*</span>
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
                                Graduation Year <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="graduation_year"
                                   value="{{ old('graduation_year', $profile?->graduation_year) }}"
                                   required min="2020" max="2035"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('graduation_year')" class="mt-1.5"/>
                        </div>

                        {{-- Skills --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Skills</label>
                            <input type="text" x-model="skillsText"
                                   placeholder="e.g. PHP, Laravel, JavaScript, MySQL"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-400">Separate skills with commas.</p>
                            @if ($profile?->skills)
                                <div class="flex flex-wrap gap-1.5 mt-2">
                                    @foreach ($profile->skills as $skill)
                                        <span class="px-2.5 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs rounded-full">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <x-input-error :messages="$errors->get('skills')" class="mt-1.5"/>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            {{-- ─── CV Upload ───────────────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Curriculum Vitae (CV)</h3>
                </div>
                <div class="p-6">
                    {{-- Current CV --}}
                    @if ($profile?->cv_path)
                        <div class="flex items-center gap-3 mb-5 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                            <div class="w-9 h-9 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                                    {{ basename($profile->cv_path) }}
                                </p>
                                <p class="text-xs text-gray-400">Current CV on file</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 mb-5 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-700">
                            <svg class="w-5 h-5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-amber-700 dark:text-amber-300">No CV uploaded yet. Upload a PDF to improve your applications.</p>
                        </div>
                    @endif

                    <form action="{{ route('student.profile.cv') }}" method="POST" enctype="multipart/form-data"
                          class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        @csrf
                        <label class="flex-1 w-full">
                            <div class="flex items-center gap-3 w-full px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 transition-colors group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                    Click to select PDF file <span class="text-xs opacity-70">(max 5 MB)</span>
                                </span>
                            </div>
                            <input type="file" name="cv" accept=".pdf" class="hidden"
                                   onchange="this.closest('form').querySelector('[data-filename]').textContent = this.files[0]?.name ?? ''">
                        </label>
                        <p data-filename class="text-xs text-gray-500 italic hidden sm:block"></p>
                        <button type="submit"
                                class="shrink-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap">
                            {{ $profile?->cv_path ? 'Replace CV' : 'Upload CV' }}
                        </button>
                    </form>
                    <x-input-error :messages="$errors->get('cv')" class="mt-2"/>
                </div>
            </div>

            {{-- ─── Account Settings ────────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Account Settings</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Manage your login email, display name, and password.</p>
                </div>

                {{-- Login Information --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Login Information</h4>

                    @if (session('status') === 'profile-updated')
                        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-3 mb-4">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">Login information updated successfully.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Display Name
                            </label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('name')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required autocomplete="username"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('email')" class="mt-1.5"/>
                            @if (auth()->user()->email_verified_at === null)
                                <p class="mt-1.5 text-xs text-amber-600 dark:text-amber-400">
                                    Your email is not verified.
                                    <a href="{{ route('verification.notice') }}" class="underline">Resend verification</a>
                                </p>
                            @endif
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                Update Info
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Change Password --}}
                <div class="p-6">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Change Password</h4>

                    @if (session('status') === 'password-updated')
                        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-3 mb-4">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">Password changed successfully.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Current Password
                            </label>
                            <input type="password" id="current_password" name="current_password"
                                   required autocomplete="current-password"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                New Password
                            </label>
                            <input type="password" id="new_password" name="password"
                                   required autocomplete="new-password"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Confirm New Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   required autocomplete="new-password"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5"/>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
