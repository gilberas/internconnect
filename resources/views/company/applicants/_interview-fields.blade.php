{{-- Shared interview form fields. Expects the parent Alpine scope to define `type`.
     Variables: $date, $time, $venue, $meetingLink, $instructions --}}

<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Date <span class="text-red-500">*</span></label>
        <input type="date" name="interview_date"
               value="{{ $date }}"
               min="{{ now()->addDay()->format('Y-m-d') }}"
               class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
               required>
        @error('interview_date')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Time <span class="text-red-500">*</span></label>
        <input type="time" name="interview_time"
               value="{{ $time }}"
               class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
               required>
        @error('interview_time')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
    </div>
</div>

{{-- Interview type — styled radio cards --}}
<div>
    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Interview Type <span class="text-red-500">*</span></label>
    <div class="grid grid-cols-3 gap-3">
        @php
            $types = [
                'physical' => ['label' => 'Physical', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'],
                'online'   => ['label' => 'Online',   'icon' => 'M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M3 8h12a2 2 0 012 2v4a2 2 0 01-2 2H3a2 2 0 01-2-2v-4a2 2 0 012-2z'],
                'phone'    => ['label' => 'Phone Call','icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
            ];
        @endphp
        @foreach ($types as $val => $meta)
            <label @click="type = '{{ $val }}'"
                   class="cursor-pointer flex flex-col items-center gap-1.5 px-3 py-3 rounded-xl border text-center transition-colors"
                   :class="type === '{{ $val }}'
                       ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/30 ring-1 ring-blue-500'
                       : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-gray-400'">
                <input type="radio" name="interview_type" value="{{ $val }}" x-model="type" class="sr-only">
                <svg class="w-5 h-5" :class="type === '{{ $val }}' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $meta['icon'] }}"/>
                </svg>
                <span class="text-xs font-medium" :class="type === '{{ $val }}' ? 'text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-400'">
                    {{ $meta['label'] }}
                </span>
            </label>
        @endforeach
    </div>
    @error('interview_type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

{{-- Conditional: venue (physical) --}}
<div x-show="type === 'physical'" x-cloak>
    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Venue <span class="text-red-500">*</span></label>
    <input type="text" name="venue"
           value="{{ $venue }}"
           placeholder="e.g. 2nd Floor, Main Office, Dar es Salaam"
           class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
    @error('venue')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

{{-- Conditional: meeting link (online) --}}
<div x-show="type === 'online'" x-cloak>
    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meeting Link <span class="text-red-500">*</span></label>
    <input type="url" name="meeting_link"
           value="{{ $meetingLink }}"
           placeholder="https://meet.google.com/..."
           class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
    @error('meeting_link')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

{{-- Instructions --}}
<div>
    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Instructions (optional)</label>
    <textarea name="instructions" rows="3"
              placeholder="What the candidate should bring or prepare..."
              class="w-full px-3.5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none">{{ $instructions }}</textarea>
    @error('instructions')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>
