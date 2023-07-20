<?php

namespace App\Jobs;

use App\Parser\Infrastructure\Models\CurrencyModel;
use App\Parser\Services\CurrencyService;
use DateTime;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LoadCurrencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DateTime $date;

    /**
     * Create a new job instance.
     */
    public function __construct(DateTime $date)
    {
        $this->date = $date;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Start currency update job");
        try {
            $service = new CurrencyService();
            $storage = new CurrencyModel();
            $service->parseDate($storage,$this->date);
        }catch (Exception $e)
        {
            Log::error($e->getMessage());
        }
        Log::info("End currency update job");

    }
}
