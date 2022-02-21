<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Todo $folder)
    {
        // 全てのフォルダを取得する
        $folders = Auth::user()->folders()->get();


        // 選ばれたフォルダに基づくタスクを取得する
        // $current_folder = Todo::find($id);
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder ->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成フォーム
     * @param Todo $folder
     * @return \Illuminate\View\View
     */

    public function showCreateForm(Todo $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id
        ]);
    }

    /**
     * タスク作成
     * @param Todo $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function create(Todo $folder, CreateTask $request)
    {

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    /**
     * タスク編集フォーム
     * @param Todo $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */

    public function showEditForm(Todo $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Todo $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function edit(Todo $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder, $task);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'folder' => $task->todo_id,
        ]);
    }

    private function checkRelation(Todo $folder, Task $task)
    {
        if ($folder->id !== $task->todo_id) {
            abort(404);
        }
    }
}
