<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format a date/time according to user's timezone preference.
     *
     * @param mixed $date Carbon instance or date string
     * @param string $format Date format (default: 'd/m/Y H:i')
     * @return string Formatted date string
     */
    public static function format($date, string $format = 'd/m/Y H:i'): string
    {
        if (empty($date)) {
            return '-';
        }

        // Convert to Carbon if not already
        if (!$date instanceof Carbon) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                return (string) $date;
            }
        }

        // Get user's preferred timezone
        $timezone = self::getUserTimezone();

        // Convert to user's timezone and format
        return $date->setTimezone($timezone)->format($format);
    }

    /**
     * Format date only (without time).
     */
    public static function formatDate($date): string
    {
        return self::format($date, 'd/m/Y');
    }

    /**
     * Format time only.
     */
    public static function formatTime($date): string
    {
        return self::format($date, 'H:i:s');
    }

    /**
     * Get human-readable relative time (e.g., "2 hours ago").
     */
    public static function diffForHumans($date): string
    {
        if (empty($date)) {
            return '-';
        }

        if (!$date instanceof Carbon) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                return (string) $date;
            }
        }

        // Set locale based on user's language preference
        $locale = self::getUserLocale();
        $date->locale($locale);

        return $date->diffForHumans();
    }

    /**
     * Get the user's preferred timezone.
     */
    public static function getUserTimezone(): string
    {
        if (auth()->check()) {
            $prefs = auth()->user()->preferences['display'] ?? [];
            return $prefs['timezone'] ?? 'Asia/Ho_Chi_Minh';
        }
        return 'Asia/Ho_Chi_Minh';
    }

    /**
     * Get the user's preferred locale.
     */
    public static function getUserLocale(): string
    {
        if (auth()->check()) {
            $prefs = auth()->user()->preferences['display'] ?? [];
            return $prefs['language'] ?? 'vi';
        }
        return 'vi';
    }
}
