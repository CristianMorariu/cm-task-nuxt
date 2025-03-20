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
    public function updateOrCreate(Request $request){
        // $request->validate([
        //     'task_id' => 'required|exists:tasks,id',
        //     'date' => 'required|date',
        //     'is_completed' => 'required|boolean',
        // ]);

        $newEntry =  TaskEntry::updateOrCreate(
            ['task_id' => $request->task_id, 'date' => $request->date],  // condiția de căutare
            ['is_completed' => $request->is_completed] // ce se setează
        );
        // return response()->json(['message' => 'Task entry saved!', 'entry' => $entry]);
        return new TaskEntriesResource($newEntry);
    }
}
