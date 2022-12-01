<?php

namespace App\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchExchangeRatesJob;

class FetchExchangeRatesCommand extends Command
{
    /**
     * The command's name and signature.
     *
     */
    protected $signature = 'system:fetch-exchange-rates';

    /**
     * The command's description.
     *
     */
    protected $description = 'Retrieve the latest exchange rates for the US Dollar';

    /**
     * Execute the console command.
     *
     */
    public function handle() : void
    {
        FetchExchangeRatesJob::dispatch();

        $this->info('The exchange rates have been retrieved');
    }
}
