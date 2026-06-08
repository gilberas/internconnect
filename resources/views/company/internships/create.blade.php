<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Post New Internship</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('company.internships.store') }}"
                  class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-8 space-y-6">
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <x-input-label for="title" value="Internship Title *"/>
                        <x-text-input id="title" name="title" class="mt-1 w-full" :value="old('title')" required placeholder="e.g. Software Developer Intern"/>
                        <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                    </div>

                    <div>
                        <x-input-label for="category_id" value="Category *"/>
                        <select id="category_id" name="category_id" required
                                class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-1"/>
                    </div>

                    <div>
                        <x-input-label for="internship_type" value="Type *"/>
                        <select id="internship_type" name="internship_type" required
                                class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:ring-blue-500 text-sm">
                            <option value="full_time"  {{ old('internship_type') == 'full_time'  ? 'selected' : '' }}>Full-time</option>
                            <option value="part_time"  {{ old('internship_type') == 'part_time'  ? 'selected' : '' }}>Part-time</option>
                            <option value="remote"     {{ old('internship_type') == 'remote'     ? 'selected' : '' }}>Remote</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="location" value="Location *"/>
                        <x-text-input id="location" name="location" class="mt-1 w-full" :value="old('location')" required placeholder="e.g. Dar es Salaam"/>
                        <x-input-error :messages="$errors->get('location')" class="mt-1"/>
                    </div>

                    <div>
                        <x-input-label for="duration" value="Duration *"/>
                        <x-text-input id="duration" name="duration" class="mt-1 w-full" :value="old('duration')" required placeholder="e.g. 3 months"/>
                        <x-input-error :messages="$errors->get('duration')" class="mt-1"/>
                    </div>

                    <div>
                        <x-input-label for="positions" value="Number of Positions *"/>
                        <x-text-input id="positions" name="positions" type="number" min="1" max="100"
                                      class="mt-1 w-full" :value="old('positions', 1)" required/>
                        <x-input-error :messages="$errors->get('positions')" class="mt-1"/>
                    </div>

                    <div>
                        <x-input-label for="deadline" value="Application Deadline *"/>
                        <x-text-input id="deadline" name="deadline" type="date" class="mt-1 w-full"
                                      :value="old('deadline')" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"/>
                        <x-input-error :messages="$errors->get('deadline')" class="mt-1"/>
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description *"/>
                    <textarea id="description" name="description" rows="5" required
                              class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                              placeholder="Describe the internship role, company, and what interns will do...">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1"/>
                </div>

                <div>
                    <x-input-label for="requirements" value="Requirements *"/>
                    <textarea id="requirements" name="requirements" rows="3" required
                              class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                              placeholder="e.g. Enrolled in a relevant degree, basic programming knowledge...">{{ old('requirements') }}</textarea>
                    <x-input-error :messages="$errors->get('requirements')" class="mt-1"/>
                </div>

                <div>
                    <x-input-label for="responsibilities" value="Responsibilities *"/>
                    <textarea id="responsibilities" name="responsibilities" rows="3" required
                              class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                              placeholder="Key tasks and responsibilities the intern will handle...">{{ old('responsibilities') }}</textarea>
                    <x-input-error :messages="$errors->get('responsibilities')" class="mt-1"/>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('company.internships.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    <x-primary-button>Submit for Review</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
