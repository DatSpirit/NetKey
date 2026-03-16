<x-guest-layout>
    <div class="mb-6">
        <h2 class="guest-form-title">{{ __('Confirm Password') }}</h2>
        <p class="guest-form-subtitle">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">
                {{ __('Password') }}
            </label>
            <input id="password" class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 px-4 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="nk-submit-btn w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                {{ __('Confirm Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
