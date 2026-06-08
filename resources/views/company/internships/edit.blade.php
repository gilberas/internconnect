<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('company.internships.show', $internship) }}"
               class="text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                ← {{ $internship->title }}
            </a>
            <span class="text-gray-300 dark:text-gray-600">/</span>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Edit</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Warning banner --}}
            <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-amber-700 dark:text-amber-300">
                    <strong>Heads up:</strong> Saving changes will reset this internship to
                    <strong>Pending</strong> and require re-approval before it goes live again.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <p class="text-sm font-medium text-red-700 dark:text-red-300 mb-1">Please fix the following:</p>
                    <ul class="text-sm text-red-600 dark:text-red-400 list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('company.internships.update', $internship) }}"
                  class="space-y-6"
                  x-data="{ type: '{{ old('internship_type', $internship->internship_type) }}' }">
                @csrf
                @method('PUT')

                {{-- ── Section 1: Basic Info ──────────────────────────────────────── --}}
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8 space-y-5">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">Basic Information</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Internship Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $internship->title) }}" required
                               class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('title')" class="mt-1.5"/>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select a category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            {{ old('category_id', $internship->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location"
                                   value="{{ old('location', $internship->location) }}" required
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('location')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Duration <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="duration"
                                   value="{{ old('duration', $internship->duration) }}" required
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('duration')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Open Positions <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="positions"
                                   value="{{ old('positions', $internship->positions) }}"
                                   required min="1" max="100"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('positions')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Application Deadline <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="deadline"
                                   value="{{ old('deadline', $internship->deadline->format('Y-m-d')) }}"
                                   required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <x-input-error :messages="$errors->get('deadline')" class="mt-1.5"/>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Skills Required</label>
                            <input type="text" name="skills_required"
                                   value="{{ old('skills_required', implode(', ', $internship->skills_required ?? [])) }}"
                                   placeholder="e.g. PHP, Laravel, MySQL"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-400 mt-1">Separate skills with commas.</p>
                            <x-input-error :messages="$errors->get('skills_required')" class="mt-1.5"/>
                        </div>
                    </div>

                    {{-- Internship Type — Radio Cards --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Internship Type <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="internship_type" :value="type">
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['full_time' => 'Full-time', 'part_time' => 'Part-time', 'remote' => 'Remote'] as $value => $label)
                            <div @click="type = '{{ $value }}'"
                                 :class="type === '{{ $value }}'
                                     ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 ring-2 ring-blue-500'
                                     : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-gray-400'"
                                 class="border-2 rounded-xl p-3 text-center text-sm font-medium cursor-pointer transition-all select-none">
                                {{ $label }}
                            </div>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('internship_type')" class="mt-1.5"/>
                    </div>
                </div>

                {{-- ── Section 2: Details ─────────────────────────────────────────── --}}
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 sm:p-8 space-y-5">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">Details</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="6" required
                                  class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $internship->description) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Minimum 50 characters.</p>
                        <x-input-error :messages="$errors->get('description')" class="mt-1.5"/>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Requirements <span class="text-red-500">*</span>
                        </label>
                        <textarea name="requirements" rows="4" required
                                  class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('requirements', $internship->requirements) }}</textarea>
                        <x-input-error :messages="$errors->get('requirements')" class="mt-1.5"/>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Responsibilities <span class="text-red-500">*</span>
                        </label>
                        <textarea name="responsibilities" rows="4" required
                                  class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('responsibilities', $internship->responsibilities) }}</textarea>
                        <x-input-error :messages="$errors->get('responsibilities')" class="mt-1.5"/>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('company.internships.show', $internship) }}"
                       class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-7 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                        Save &amp; Resubmit for Review
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
