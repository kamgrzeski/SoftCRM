<?php

namespace App\Jobs;

use App\Models\AdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
    public function __construct(string $oldPassword, string $newPassword, string $confirmNewPassword, AdminModel $adminModel)
    {
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
        $this->confirmNewPassword = $confirmNewPassword;
        $this->adminModel = $adminModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->adminModel->updateAdminPassword($this->newPassword, $this->adminModel->id);
    }
}
