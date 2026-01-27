<x-app-layout>
    <div class="max-w-xl mx-auto py-12 text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-4">🚫 {{ __('Transaction Cancelled') }}</h1>
        <p class="text-lg text-gray-700 mb-6">{{ __('Order Code') }}: <span
                class="font-mono font-semibold">{{ $orderCode ?? 'N/A' }}</span></p>
        <p class="text-gray-500">{{ __('Transaction cancelled message') }}</p>
        <a href="{{ route('products') }}"
            class="mt-8 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
            {{ __('Back to Products') }}
        </a>
    </div>
</x-app-layout>