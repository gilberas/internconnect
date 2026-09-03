<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-slate-300!" />
            <x-text-input id="email" class="block mt-1.5 w-full auth-input"
                          type="email" name="email"
                          :value="old('email')" required autofocus
                          autocomplete="username"
                          placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-slate-300!" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-400 hover:text-blue-300 hover:underline underline-offset-4 transition-colors"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            {{-- Password input with toggle --}}
            <div class="relative mt-1.5" x-data="{ show: false }">
                <input id="password"
                       :type="show ? 'text' : 'password'"
                       name="password"
                       required autocomplete="current-password"
                       placeholder="Enter your password"
                       class="block w-full auth-input pr-11">
                <button type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-300 transition-colors"
                        :aria-label="show ? 'Hide password' : 'Show password'"
                        aria-label="Show password">
                    {{-- Eye --}}
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    {{-- Eye Off --}}
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox"
                       class="rounded border-slate-500/40 bg-white/5 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-offset-0"
                       name="remember">
                <span class="text-sm text-slate-400">{{ __('Remember me') }}</span>
            </label>

            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                    style="background:linear-gradient(135deg,#2563EB,#1D4ED8);box-shadow:0 4px 20px rgba(37,99,235,0.4),inset 0 1px 0 rgba(255,255,255,0.15);">
                {{ __('Sign In') }}
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </form>

    {{-- Register link --}}
    @if (Route::has('register'))
        <div class="mt-6 text-center">
            <p class="text-sm text-slate-400">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="text-blue-400 font-medium hover:text-blue-300 hover:underline underline-offset-4 transition-colors">
                    Create one &mdash; it's free
                </a>
            </p>
        </div>
    @endif
</x-guest-layout>
