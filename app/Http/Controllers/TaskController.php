<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        // index, show を除外
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index(Request $request)
    {
        $tasks = \Auth::user();

        {
            $keyword = $request->input('keyword');

            //クエリ生成
            $query = Task::query();

            //もしキーワードがあったら
            if(!empty($keyword))
            {
                $query->orWhere('text','like','%'.$keyword.'%');
            }

            // 全件取得 +ページネーション
            $tasks = $query->orderBy('id','desc')->paginate(5);
            return view('tasks.index')->with('tasks',$tasks)->with('keyword',$keyword);
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $rules = [
            'text' => 'required|max:100',
            'start_date' =>  'required|after:yesterday', //start_dateが今日以降の日付かどうかチェック
            'finish_date' => 'required|after:start_date',
        ];
    
        $messages = [
            'required' => '必須項目です', 'max' => '100文字以下にしてください。',
            'start_date.after' => '開始日には今日以降の日付を入力してください。',
            'finish_date.after' => '終了日には開始日以降の日付を入力してください。',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //モデルをインスタンス化
        $task = new Task;
        
        $task->text = $request->input('text');
        $task->user_id = Auth::id();
        $task->start_date = $request->input('start_date');
        $task->finish_date = $request->input('finish_date');
        
        
        //データベースに保存
        $task->save();
        
        //リダイレクト
        session()->flash('flash_message', 'タスクを追加しました');
        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->status === null) {
                $rules = [
                    'text' => 'required|max:100',
                    'start_date' =>  'required|date|after:yesterday', //start_dateが今日以降の日付かどうかチェック
                    'finish_date' => 'required|date|after:start_date',
                ];
            
                $messages = [
                    'required' => '必須項目です', 'max' => '100文字以下にしてください。',
                    'start_date.after' => '開始日には今日以降の日付を入力してください。',
                    'finish_date.after' => '終了日には開始日以降の日付を入力してください。',
                ];
            
                Validator::make($request->all(), $rules, $messages)->validate();
            
            
                //該当のタスクを検索
                $task = Task::find($id);
            
                //モデル->カラム名 = 値 で、データを割り当てる
                $task->text = $request->input('text');
                $task->start_date = $request->input('start_date');
                $task->finish_date = $request->input('finish_date');
            
                //データベースに保存
                $task->save();
            } else {
                //「完了」ボタンを押したとき
            
                //該当のタスクを検索
                $task = Task::find($id);
            
                //モデル->カラム名 = 値 で、データを割り当てる
                $task->status = true; //true:完了、false:未完了
            
                //データベースに保存
                $task->save();
            }
        
        
          //リダイレクト
          session()->flash('flash_message', 'タスクを更新しました');
          return redirect('/tasks');
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
  
        session()->flash('flash_message', 'タスクを削除しました');
        return redirect('/tasks');
    }
}
