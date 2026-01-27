<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Exchange rates relative to VND (base currency).
     * 1 USD = 25,000 VND, 1 EUR = 27,000 VND
     */
    private static array $exchangeRates = [
        'VND' => 1,
        'USD' => 25000,
        'EUR' => 27000,
    ];

    /**
     * Currency symbols
     */
    private static array $symbols = [
        'VND' => '₫',
        'USD' => '$',
        'EUR' => '€',
    ];

    /**
     * Convert amount from VND to target currency and format it.
     *
     * @param float|int $amountInVND The amount in VND (base currency)
     * @param string|null $targetCurrency The target currency code (VND, USD, EUR)
     * @param bool $showSymbol Whether to show currency symbol
     * @return string Formatted price string
     */
    public static function format($amountInVND, ?string $targetCurrency = null, bool $showSymbol = true): string
    {
        // Get user's preferred currency if not specified
        if ($targetCurrency === null) {
            $targetCurrency = self::getUserCurrency();
        }

        // Ensure valid currency
        if (!isset(self::$exchangeRates[$targetCurrency])) {
            $targetCurrency = 'VND';
        }

        // Convert amount
        $rate = self::$exchangeRates[$targetCurrency];
        $convertedAmount = $amountInVND / $rate;

        // Format based on currency
        if ($targetCurrency === 'VND') {
            $formatted = number_format($convertedAmount, 0, ',', ',');
        } else {
            $formatted = number_format($convertedAmount, 2, '.', ',');
        }

        // Add symbol
        if ($showSymbol) {
            $symbol = self::$symbols[$targetCurrency] ?? $targetCurrency;
            if ($targetCurrency === 'VND') {
                return $formatted . ' ' . $symbol;
            } else {
                return $symbol . $formatted;
            }
        }

        return $formatted;
    }

    /**
     * Get the user's preferred currency from their preferences.
     */
    public static function getUserCurrency(): string
    {
        if (auth()->check()) {
            $prefs = auth()->user()->preferences['display'] ?? [];
            return $prefs['currency'] ?? 'VND';
        }
        return 'VND';
    }

    /**
     * Get exchange rate for a currency relative to VND.
     */
    public static function getRate(string $currency): float
    {
        return self::$exchangeRates[$currency] ?? 1;
    }

    /**
     * Convert from one currency to another.
     */
    public static function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        // First convert to VND
        $fromRate = self::$exchangeRates[$fromCurrency] ?? 1;
        $amountInVND = $amount * $fromRate;

        // Then convert to target currency
        $toRate = self::$exchangeRates[$toCurrency] ?? 1;
        return $amountInVND / $toRate;
    }
}
