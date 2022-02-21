<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    // 引数にインポートしたRequestクラスを受け入れる
    public function create(CreateFolder $request)
    {
        // Todoモデルのインスタンスを作成する
        $folder = new Todo();
        // タイトルに入力値を代入する
        $folder->title = $request->title;

        // ★ ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder);


        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
