<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    {
        // 全てのフォルダを取得する
        $folders = Todo::all();


        // 選ばれたフォルダを取得する
        $current_folder = Todo::find($id);

        // 選ばれたフォルダに紐づくタスクを取得する
        // $tasks = Task::where('todo_id', $current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }
}
