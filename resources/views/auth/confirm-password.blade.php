{{--
    ICS Confirm Password View
    Phase 2 — Authentication (Weeks 3–4)
--}}
<x-guest-layout>
    <div class="mb-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Confirm your password</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">This is a protected area. Please re-enter your password.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-5 flex justify-end">
            <x-primary-button>
                {{ __('Confirm & Continue') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
