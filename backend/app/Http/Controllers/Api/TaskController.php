<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskEntriesResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $today =Carbon::today();
        $tasks = Task::with('entries')->get();
        $response =[
            'date' =>[
                'currentDate' => $today->toDateString(),
                'dayName' =>$today->dayName,
                'monthName'=>$today->monthName,
            ],
                // 'task_count' => $tasks->count(),
            'days_in_month' => $today->daysInMonth,
            'data'=> TaskResource::collection($tasks),
            
        ];
        // return $response;
        return response()->json($response);
    }

    public function show(Task $task){
        return new TaskResource($task);
    }

    public function store(Request $request){
        $request->validate([
        'name'=>'required|String',
        ]);
        $task = Task::create($request->all());

        return new TaskResource($task);
    }
}
