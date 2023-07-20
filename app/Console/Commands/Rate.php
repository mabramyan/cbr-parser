<?php

namespace App\Console\Commands;

use App\Services\RateService;
use Exception;
use Illuminate\Console\Command;

class Rate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rate';

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

        try {
            $rate = $service->getRate('USD','RUR');

        }catch (Exception $e)
        {
            $this->error($e->getMessage());
        }


        $this->info(json_encode($rate));
    }
}
