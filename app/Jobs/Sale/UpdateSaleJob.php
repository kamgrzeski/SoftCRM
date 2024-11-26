<?php

namespace App\Jobs\Sale;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSaleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private array $validatedData;
    private Sale $sale;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, Sale $sale)
    {
        $this->validatedData = $validatedData;
        $this->sale = $sale;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->sale->update($this->validatedData);
    }
}
