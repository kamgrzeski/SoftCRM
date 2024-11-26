<?php

namespace App\Relations\Has;

use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyTasks
{

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'employee_id');
    }
}
