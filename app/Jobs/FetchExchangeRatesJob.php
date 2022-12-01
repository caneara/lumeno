<?php

namespace App\Jobs;

use Exception;
use App\Types\Job;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\CurrencyLayerService;

class FetchExchangeRatesJob extends Job
{
    /**
     * The API response.
     *
     */
    protected array $response = [];

    /**
     * The number of times the job may be attempted.
     *
     */
    public int $tries = 1;

    /**
     * Execute the job.
     *
     */
    public function handle() : void
    {
        $this->retrieveExchangeRates()
            ->checkForErrors()
            ->updateLocalRates();
    }

    /**
     * Determine if the request to fetch the exchange rates failed.
     *
     */
    protected function checkForErrors() : static
    {
        $success = Arr::get($this->response, 'success', false);
        $message = Arr::get($this->response, 'error.info', 'Unknown Error');

        throw_unless($success, Exception::class, "Cannot fetch exchange rates: {$message}");

        return $this;
    }

    /**
     * Generate the SQL command to update the given currency.
     *
     */
    protected function prepareQuery(string $code, float $rate) : string
    {
        $rate = round(1 / $rate, 3);
        $code = Str::after($code, 'USD');

        return "UPDATE `currencies` SET `rate` = '{$rate}' WHERE `code` = '{$code}'";
    }

    /**
     * Fetch the latest exchange rates from the server.
     *
     */
    protected function retrieveExchangeRates() : static
    {
        $this->response = CurrencyLayerService::retrieveExchangeRates();

        return $this;
    }

    /**
     * Modify the locally-stored exchange rates.
     *
     */
    protected function updateLocalRates() : void
    {
        $sql = collect(Arr::get($this->response, 'quotes', []))
            ->map(fn($rate, $code) => $this->prepareQuery($code, $rate))
            ->implode(';');

        $sql ? attempt(fn() => DB::unprepared($sql)) : null;
    }
}
