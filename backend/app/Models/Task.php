<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
     protected $fillable = [
        'project_id','user_id','name','description',
        'status','priority','due_date','completed_at','position'
    ];
    public function project() { return $this->belongsTo(Project::class); }
    public function user()    { return $this->belongsTo(User::class); }
}

