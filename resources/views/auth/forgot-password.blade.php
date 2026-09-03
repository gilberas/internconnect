<x-guest-layout>
    <div class="mb-5">
        <h2 class="text-lg font-semibold text-slate-100" style="font-family: 'Sora', sans-serif;">Reset your password</h2>
        <p class="mt-1 text-sm text-slate-400">
            Enter your email and we'll send you a reset link. The link expires in 60 minutes.
        </p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-slate-300!" />
            <x-text-input id="email" class="block mt-1.5 w-full auth-input"
                          type="email" name="email"
                          :value="old('email')" required autofocus
                          placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}"
               class="text-sm text-slate-400 hover:text-blue-300 transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to sign in
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                    style="background:linear-gradient(135deg,#2563EB,#1D4ED8);box-shadow:0 4px 20px rgba(37,99,235,0.4),inset 0 1px 0 rgba(255,255,255,0.15);">
                {{ __('Send Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
