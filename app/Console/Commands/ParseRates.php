<?php

namespace App\Console\Commands;

use App\Jobs\LoadCurrencyJob;
use App\Models\Parser;
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
    protected $description = 'Parse rates from https://cbr.ru for last 180 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = new DateTime();
        $i = 0;
        do {
            $parser = Parser::firstOrCreate(
                [
                    'date' => $date->format('Y-m-d')
                ]
            );
            //add Load currency job for each day
            if (empty($parser->state)) {
                LoadCurrencyJob::dispatch($date);
                $parser->state = 1;
                $parser->save();
            }
            $date->sub(new DateInterval('P1D'));
            $i++;
        } while ($i < 180);
    }
}
