<?php

namespace App\Jobs\Deal;

use App\Models\Deal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDealJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private array $validatedData;
    private Deal $deal;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, Deal $deal)
    {
        $this->validatedData = $validatedData;
        $this->deal = $deal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->deal->update($this->validatedData);
    }
}
