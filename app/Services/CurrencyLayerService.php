<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyLayerService
{
    /**
     * Fetch the latest exchange rates from Currency Layer.
     *
     */
    public static function retrieveExchangeRates() : array
    {
        $service = config('services.currency_layer');

        return Http::acceptJson()
            ->withUserAgent(config('app.agent'))
            ->retry(6, 10000)
            ->get("{$service['url']}?access_key={$service['key']}")
            ->throw()
            ->json();
    }
}
