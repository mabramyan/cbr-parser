<?php

namespace App\Console\Commands;

use App\Services\Constenats\CurrencyCodes;
use App\Services\RateService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;

class Rate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rate {currency} {baseCurrency=RUR}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new RateService();
        $rate = '';

        $currencyList = (new ReflectionClass(CurrencyCodes::class))->getConstants();

        $validator = Validator::make([
            'currency' => $this->argument('currency'),
            'baseCurrency' => $this->argument('baseCurrency'),
        ], [
            'currency' => 'required|in:' . implode(',', $currencyList),
            'baseCurrency' => 'required|in:' . implode(',', $currencyList),
        ]);

        if ($validator->fails()) {
            $this->error($validator->messages());
            return;
        }


        try {
            $rate = $service->getRate($this->argument('currency'), $this->argument('baseCurrency'));

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }


        $this->info(json_encode($rate));
    }
}
