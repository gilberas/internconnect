<x-guest-layout>
    @if (session('status') && session('status') !== 'verification-link-sent')
    <div class="mb-5 p-3 bg-emerald-500/10 border border-emerald-400/25 rounded-xl text-sm text-emerald-300 text-center">
        ✓ {{ session('status') }}
    </div>
    @endif

    <div class="flex flex-col items-center text-center mb-6">
        <div class="w-16 h-16 bg-blue-500/15 rounded-full flex items-center justify-center mb-4 border border-blue-400/20">
            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-slate-100" style="font-family: 'Sora', sans-serif;">Check your inbox</h2>
        <p class="mt-2 text-sm text-slate-400 max-w-sm">
            We sent a verification link to your email address. Click the link to activate your InternConnect account.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-400/25">
            <p class="text-sm text-emerald-300 text-center">
                ✓ A new verification link has been sent to your email.
            </p>
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="w-full justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                    style="background:linear-gradient(135deg,#2563EB,#1D4ED8);box-shadow:0 4px 20px rgba(37,99,235,0.4),inset 0 1px 0 rgba(255,255,255,0.15);">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit"
                    class="text-sm text-slate-400 hover:text-blue-300 underline underline-offset-4 transition-colors">
                {{ __('Sign out and use a different account') }}
            </button>
        </form>
    </div>
</x-guest-layout>
