{{--
    ICS Register View
    Phase 2 — Authentication (Weeks 3–4)

    Key change from default Breeze:
    • Account-type selector (Student / Company) at the top
    • Hidden `account_type` field passed to RegisteredUserController
    • Alpine.js drives the toggle highlight
--}}
<x-guest-layout>
    {{-- Account Type Toggle --}}
    <div x-data="{ type: '{{ old('account_type', request('type', 'student')) }}' }" class="mb-6">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">I want to:</p>
        <div class="grid grid-cols-2 gap-3">
            {{-- Student --}}
            <button type="button"
                @click="type = 'student'"
                :class="type === 'student'
                    ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 ring-2 ring-blue-500'
                    : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-gray-400'"
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
                    ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 ring-2 ring-blue-500'
                    : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-gray-400'"
                class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition-all cursor-pointer">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="text-sm font-semibold">Post Internships</span>
                <span class="text-xs opacity-70">I'm an organisation</span>
            </button>
        </div>

        {{-- Hidden account_type field keeps value in sync --}}
        <input type="hidden" name="account_type" :value="type">
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                          name="name" :value="old('name')" required autofocus autocomplete="name"
                          placeholder="John Mwangi" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                          name="email" :value="old('email')" required autocomplete="username"
                          placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="new-password"
                          placeholder="Min. 8 characters" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Must include uppercase, lowercase, number, and special character.
            </p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 underline underline-offset-4 transition-colors"
               href="{{ route('login') }}">
                Already have an account?
            </a>
            <x-primary-button>
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
