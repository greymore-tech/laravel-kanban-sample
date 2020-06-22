<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        //  fetch all tasks based on current user id
        $tasks = Task::all()->where('user_id', $user_id);

        //  return tasks as a resource
        return TaskResource::collection($tasks);
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
    public function store(Request $request, $user_id)
    {
        //  store new task in the database
        $task = new Task;
        $task->user_id = $user_id;
        $task->board_name = $request->input('board_name');
        $task->name = $request->input('name');
        $task->description = $request->input('description');

        if ($task->save()) {
            //  if saved then return task as a resource
            return new TaskResource($task);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id, $user_id)
    {
        //  fetch task based on current user id and task id
        $task = Task::where('user_id', $user_id)->FindOrFail($id);

        //  return task as a resource
        return new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        //  update existing task data based on current user id and task id
        $task = Task::where('user_id', $user_id)->FindOrFail($request->task_id);
        $task->user_id = $user_id;
        $task->board_name = $request->input('board_name');
        $task->name = $request->input('name');
        $task->description = $request->input('description');

        if ($task->save()) {
            //  if saved then return task as a resource
            return new TaskResource($task);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $user_id)
    {
        //  fetch task based on current user id and task id
        $task = Task::where('user_id', $user_id)->FindOrFail($id);

        if ($task->delete()) {
            //  if deleted then return task as a resource
            return new TaskResource($task);
        }
    }
}
