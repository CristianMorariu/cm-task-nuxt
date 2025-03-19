<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskEntry extends Model
{
    /** @use HasFactory<\Database\Factories\TaskEntryFactory> */
    use HasFactory;

    protected $fillable=[
        "day", 'month', 'year', 'is_completed'
    ];

    public function task():BelongsTo{
        return $this->belongsTo(Task::class);
    }
}
