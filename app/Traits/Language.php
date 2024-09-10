<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\App;

/**
 * Trait Language
 *
 * Provides functionality to get localized messages.
 */
trait Language
{
    /**
     * Get the localized message based on the current locale.
     *
     * @param string $message The message key to be translated.
     * @return string|null The translated message if the locale is 'en', otherwise null.
     * @throws Exception If the translation fails.
     */
    public static function getMessage(string $message): ?string
    {
        if (App::isLocale('en')) {
            return __($message);
        }

        return null;
    }
}
