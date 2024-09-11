<?php

namespace App\Jobs;

use App\Models\AdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class ChangePasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $oldPassword;
    private string $newPassword;
    private string $confirmNewPassword;
    private AdminModel $adminModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, AdminModel $adminModel)
    {
        $this->oldPassword = $validatedData['old_password'];
        $this->newPassword = $validatedData['new_password'];
        $this->confirmNewPassword = $validatedData['confirm_password'];

        $this->adminModel = $adminModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->adminModel->update([
            'password' => Hash::make($this->newPassword),
            'updated_at' => now()
        ]);
    }
}
