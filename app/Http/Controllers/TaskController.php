<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $task;
    private $user;

    public function __construct(Task $task, User $user) {
        $this->task = $task;
        $this->user = $user;
    }

    public function index()
    {
        $tasks = $this->task->all();
        return view('task.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $task = $this->task->create($request->all());

        $users = $this->user->all();
        $message = [
            'type' => 'Create task',
            'task' => $task->name,
            'content' => 'has been created!'
        ];
        SendMail::dispatch($message, $users)->delay(Carbon::now());

        return redirect()->back();
    }

    public function destroy($id)
    {
        $task = $this->task->findOrFail($id);
        $task->delete();
        $users = $this->user->all();
        $message = [
            'type' => 'Delete task',
            'task' => $task->name,
            'content' => 'has been deleted!'
        ];
        SendMail::dispatch($message, $users);
        return redirect()->back();
    }
}
