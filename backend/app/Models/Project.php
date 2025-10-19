<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'supervisor_id', 'deadline', 'status',
    ];
    protected $casts = [
        'deadline'   => 'date',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
     public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
