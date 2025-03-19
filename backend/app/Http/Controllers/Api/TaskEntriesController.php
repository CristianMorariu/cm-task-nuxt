<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskEntriesResource;
use App\Models\TaskEntry;
use Illuminate\Http\Request;

class TaskEntriesController extends Controller
{
    public function index(){
        $entry = TaskEntry::with('task')->get();
        return TaskEntriesResource::collection($entry);
    }
}
