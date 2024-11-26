<?php

namespace App\Jobs\Product;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private array $validatedData;
    private Product $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, Product $product)
    {
        $this->validatedData = $validatedData;
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->product->update($this->validatedData);
    }
}
