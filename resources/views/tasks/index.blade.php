@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row">
        <h2 class="text-center">今日は何する？</h2>
        @auth
            <div class="text-center">
                <img src="{{asset('storage/images/'.Auth::user()->avatar)}}" alt="{{ Auth::user()->name }}" style="width: 200px; height: 200px; border-radius: 50%;">
                <h5 class="mt-3">{{ Auth::user()->name }}</h5>
            </div>
        @endauth
        <div class="text-center mt-3">
        <button class="btn btn-info btn-lg">
            <a href="{{ route('tasks.create') }}" class="text-white" style="text-decoration: none;">
                    タスクを追加
            </a>
        </button>
    </div>
        
    </div>
    <form method="GET" action="{{ route('tasks.index') }}">
        <div class="input-group mt-5 w-75" style="margin: auto;">
            <input type="text" placeholder="タスクを検索" name="keyword" value="{{$keyword}}" class="form-control form-control-lg bg-white">
        </div>
        <div class="text-center mt-2">
            <button type="submit" class="btn btn-primary">検索</button>
            <button class="btn btn-secondary">
                <a href="{{ route('tasks.index') }}" class="text-white" style="text-decoration: none;">
                    検索をクリア
                </a>
            </button>
        </div>
    </form>
</div>


    @if ($tasks->isNotEmpty())
    
    <table class="table text-center bg-white mt-5" style="margin: auto; width: 68%;">
        <thead>
            <tr>
                <th scope="col">タスク</th>
                <th scope="col">開始日</th>
                <th scope="col">終了日</th>
                <th scope="col">投稿者</th>
                <th scope="col">操作</th>
            </tr>
            
        </thead>
        <tbody>
            @auth
                @foreach ($tasks as $task)
                    @if(Auth::user()->can('view', $task))
                    
                        <tr>
                            @php
                                $date = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($task->finish_date))
                            @endphp
                            <td>{{ $task->text }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->start_date)->format("Y/m/d") }}</td>
                            @if( $task->status == 0 )
                                @if(\Carbon\Carbon::today() <= \Carbon\Carbon::parse($task->finish_date))
                                    @if ( $date == 3 || $date == 2 || $date == 1 )
                                        <td class="bg-warning text-white">{{ \Carbon\Carbon::parse($task->finish_date)->format("Y/m/d") }}</td>
                                    @elseif( $date == 0 )
                                        <td class="text-white" style="background: #df7163;">{{ \Carbon\Carbon::parse($task->finish_date)->format("Y/m/d") }}</td>
                                    @else
                                        <td>{{ \Carbon\Carbon::parse($task->finish_date)->format("Y/m/d") }}</td>
                                    @endif
                                @else
                                    <td class="bg-danger text-white">{{ \Carbon\Carbon::parse($task->finish_date)->format("Y/m/d") }}</td>
                                @endif
                            @else
                                <td class="bg-success text-white">タスク終了！</td>
                            @endif
                            <td>{{ $task->user->name }}</td>
                            <td>
                                <div class="justify-content-center" style="display: flex;">
                                @if ( $task->status == '0' )
                                    <form action="/tasks/{{ $task->id }}"
                                        method="post"                                  
                                        role="menuitem" tabindex="-1">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="status" value="{{$task->status}}">
                                        
                                        <button type="submit" class="btn btn-success">完了</button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary">終了</button>
                                @endif
                                @if ( $task->status == '0' )
                                    <a href="/tasks/{{ $task->id }}/edit/" class="btn btn-primary">編集</a>
                                @else
                                    <button type="button" class="btn btn-primary" disabled="disabled">編集</a>
                                @endif
                                    <form onsubmit="return deleteTask();"
                                        action="/tasks/{{ $task->id }}" method="post"
                                        role="menuitem" tabindex="-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-danger">削除</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                    <p>{{ $task->count_task }}</p>
                @endforeach
            @endauth
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-5">{!! $tasks->links() !!}</div>
    <script>
        function deleteTask() {
            if (confirm('本当に削除しますか？')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    @endif
@endsection