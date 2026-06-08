{{--
    ICS Login View
    Phase 2 — Authentication (Weeks 3–4)
--}}
<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email"
                          :value="old('email')" required autofocus
                          autocomplete="username"
                          placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-600 dark:text-blue-400 hover:underline underline-offset-4"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-400"
                       name="remember">
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

            <x-primary-button>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Register link --}}
    @if (Route::has('register'))
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="text-blue-600 dark:text-blue-400 font-medium hover:underline underline-offset-4">
                    Create one — it's free
                </a>
            </p>
        </div>
    @endif
</x-guest-layout>
