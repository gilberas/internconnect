{{--
    ICS Verify Email View
    Phase 2 — Authentication (Weeks 3–4)
--}}
<x-guest-layout>
    @if (session('status') && session('status') !== 'verification-link-sent')
    <div class="mb-5 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-sm text-emerald-700 dark:text-emerald-300 text-center">
        ✓ {{ session('status') }}
    </div>
    @endif

    <div class="flex flex-col items-center text-center mb-6">
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Check your inbox</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-sm">
            We sent a verification link to your email address. Click the link to activate your InternConnect account.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <p class="text-sm text-green-700 dark:text-green-400 text-center">
                ✓ A new verification link has been sent to your email.
            </p>
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 underline underline-offset-4 transition-colors">
                {{ __('Sign out and use a different account') }}
            </button>
        </form>
    </div>
</x-guest-layout>
