<x-guest-layout>
    <div class="mb-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-amber-500/15 rounded-lg flex items-center justify-center flex-shrink-0 border border-amber-400/20">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-slate-100">Confirm your password</h2>
                <p class="text-xs text-slate-400">This is a protected area. Please re-enter your password.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-slate-300!" />
            <div class="relative mt-1.5" x-data="{ show: false }">
                <input id="password"
                       :type="show ? 'text' : 'password'"
                       name="password" required autocomplete="current-password"
                       placeholder="Enter your password"
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
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-5 flex justify-end">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                    style="background:linear-gradient(135deg,#2563EB,#1D4ED8);box-shadow:0 4px 20px rgba(37,99,235,0.4),inset 0 1px 0 rgba(255,255,255,0.15);">
                {{ __('Confirm & Continue') }}
            </button>
        </div>
    </form>
</x-guest-layout>
