<x-guest-layout>
    <form method="POST" action="{{ route('register') }}"
          x-data="{ type: '{{ old('account_type', request('type', 'student')) }}', showPassword: false, showConfirm: false }">
        @csrf

        {{-- Account Type Toggle --}}
        <div class="mb-6">
            <p class="text-sm font-medium text-slate-300 mb-3">I want to:</p>
            <div class="grid grid-cols-2 gap-3">
                {{-- Student --}}
                <button type="button"
                        @click="type = 'student'"
                        :class="type === 'student'
                            ? 'border-blue-500 bg-blue-500/10 text-blue-300 ring-2 ring-blue-500'
                            : 'border-slate-500/30 text-slate-400 hover:border-slate-400'"
                        class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition-all cursor-pointer">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <span class="text-sm font-semibold">Find Internships</span>
                    <span class="text-xs opacity-70">I'm a student</span>
                </button>

                {{-- Company --}}
                <button type="button"
                        @click="type = 'company'"
                        :class="type === 'company'
                            ? 'border-blue-500 bg-blue-500/10 text-blue-300 ring-2 ring-blue-500'
                            : 'border-slate-500/30 text-slate-400 hover:border-slate-400'"
                        class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition-all cursor-pointer">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-sm font-semibold">Post Internships</span>
                    <span class="text-xs opacity-70">I'm an organisation</span>
                </button>
            </div>

            {{-- Hidden input synced with Alpine --}}
            <input type="hidden" name="account_type" :value="type">

            {{-- Fallback for no-JS --}}
            <noscript>
                <select name="account_type" class="w-full mt-3 rounded-xl auth-input">
                    <option value="student" {{ old('account_type', 'student') === 'student' ? 'selected' : '' }}>Student — Find Internships</option>
                    <option value="company" {{ old('account_type') === 'company' ? 'selected' : '' }}>Organisation — Post Internships</option>
                </select>
            </noscript>

            <x-input-error :messages="$errors->get('account_type')" class="mt-2"/>
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-slate-300!" />
            <x-text-input id="name" class="block mt-1.5 w-full auth-input" type="text"
                          name="name" :value="old('name')" required autofocus autocomplete="name"
                          placeholder="John Mwangi"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" class="text-slate-300!" />
            <x-text-input id="email" class="block mt-1.5 w-full auth-input" type="email"
                          name="email" :value="old('email')" required autocomplete="username"
                          placeholder="you@example.com"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-slate-300!" />
            <div class="relative mt-1.5" x-data="{ show: false }">
                <input id="password"
                       :type="show ? 'text' : 'password'"
                       name="password" required autocomplete="new-password"
                       placeholder="Min. 8 characters"
                       class="block w-full auth-input pr-11">
                <button type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-300 transition-colors"
                        :aria-label="show ? 'Hide password' : 'Show password'"
                        aria-label="Show password">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            <p class="mt-1.5 text-xs text-slate-500">
                Must include uppercase, lowercase, number, and special character.
            </p>
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-300!" />
            <div class="relative mt-1.5" x-data="{ show: false }">
                <input id="password_confirmation"
                       :type="show ? 'text' : 'password'"
                       name="password_confirmation" required autocomplete="new-password"
                       placeholder="Re-enter your password"
                       class="block w-full auth-input pr-11">
                <button type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-300 transition-colors"
                        :aria-label="show ? 'Hide password' : 'Show password'"
                        aria-label="Show password">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-slate-400 hover:text-blue-300 underline underline-offset-4 transition-colors"
               href="{{ route('login') }}">
                Already have an account?
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                    style="background:linear-gradient(135deg,#2563EB,#1D4ED8);box-shadow:0 4px 20px rgba(37,99,235,0.4),inset 0 1px 0 rgba(255,255,255,0.15);">
                {{ __('Create Account') }}
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
