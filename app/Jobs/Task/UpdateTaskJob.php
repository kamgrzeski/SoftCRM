<?php

namespace App\Jobs\Task;

use App\Models\TasksModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TasksModel $task;
    private array $validatedData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, TasksModel $task)
    {
        $this->validatedData = $validatedData;
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->task->update($this->validatedData);
    }
}
