<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
$user=auth()->user()->Tasks;
return $user;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'content' => 'required',
            'category_id' => 'required'
        ]);


        $user = auth()->user();


        if($user->Tasks()->create($request->all())){
            return response()->json(['message' => 'Add Successful'], 401);
        }else{
            return response()->json(['message' => 'Error'], 402);

        }
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if(auth()->user()->id!=$task->id){
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $task->load('Files');

            return new TaskResource($task);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {

        $validation = $request->validate([
            'category_id' => 'required'
        ]);

        $modelCategory = Category::findOrFail($request->category_id);
        //check if user not own this task or didn't have access

        if (auth()->user()->id != $modelCategory->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $task->update($request->all());
             return response()->json(['message' => 'Update Successful'], 402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //check if user not own this task or didn't have access
        if (auth()->user()->id != $task->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $task->delete();
            return response()->json(['message' => 'Delete Successful'], 402);
        }


    }

    public function forceDelete($taskId)
    {

        $task = Task::withTrashed()->findOrFail($taskId);

        //check if user not own this gategory or didn't have access
        if (auth()->user()->id != $task->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        }
        if ($task->forceDelete())
        {
$userEmail=$task->user()->email;
            $taskTitle=$task->name;

            Storage::deleteDirectory('public/tasks/'.$task->id);

            //Send notification email to alert user when task deleted
            Mail::send([],[],function ($message) use ($userEmail, $taskTitle){
                $message->subject('Task was delete Successful');
                $message->to($userEmail);
                $message->setBody('<h1>Task Deleted</h1><p>'.$taskTitle.'</p>','text/html');

            });



            return response()->json(['message' => 'Deleted Successful']);
            }

        return response()->json(['message' => 'Error Try Again'], 500);




    }

    public function restore($id)
    {
        $model = Task::withTrashed()->findOrFail($id);

        //check if user not own this gategory or didn't have access
        if (auth()->user()->id != $model->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $model->restore();
            return response()->json(['message' => 'Restore Successful'], 500);
        }
    }

}
