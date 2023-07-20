<?php

namespace App\Console\Commands;

use App\Jobs\LoadCurrencyJob;
use App\Parser\Exceptions\EmptyDataException;
use DateInterval;
use DateTime;
use Illuminate\Console\Command;

class ParseRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws EmptyDataException
     */
    public function handle()
    {
        $date = new DateTime();
        $i = 0;
        do {
            LoadCurrencyJob::dispatch($date);
            $date->sub(new DateInterval('P1D'));
            $i++;
        } while ($i < 180);
    }
}
