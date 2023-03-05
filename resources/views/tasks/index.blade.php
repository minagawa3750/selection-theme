@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row">
        <h2 class="text-center">今日は何する？</h2>
        <form action="/tasks" method="post" class="mt-10">
            @csrf

            <div class="input-group mt-4">
            <input type="text" class="form-control form-control-lg bg-white" placeholder="タスクを書く" name="task_name">
            <button type="submit" class="btn btn-info text-white">
                追加
            </button>
            </div>
            @error('task_name')
                <div class="mt-3">
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                </div>
            @enderror
        </form>
    </div>

    <form method="GET" action="{{ route('tasks.index') }}">
        <div class="input-group mt-5" style="margin: auto;">
            <input type="text" placeholder="タスクを検索" name="keyword" value="{{$keyword}}" class="form-control form-control-lg bg-white">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
        <div class="text-center mt-2">
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
            <th scope="col">投稿者</th>
            <th scope="col">操作</th>
        </tr>
        
    </thead>
    <tbody>
        @foreach ($tasks as $item)
            <tr>
                <td>
                    {{ $item->name }}
                </td>
                <td>{{ $item->user->name }}</td>
                <td>
                    <div class="justify-content-center" style="display: flex;">
                    @if ( $item->status == '0' )
                        <form action="/tasks/{{ $item->id }}"
                            method="post"
                            
                            role="menuitem" tabindex="-1">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="status" value="{{$item->status}}">
                            
                            <button type="submit" class="btn btn-success">完了</button>
                        </form>
                    @else
                        <button type="button" class="btn btn-secondary">終了</button>
                    @endif
                    @if ( $item->status == '0' )
                        <a href="/tasks/{{ $item->id }}/edit/" class="btn btn-primary">編集</a>
                    @else
                        <button type="button" class="btn btn-primary" disabled="disabled">編集</a>
                    @endif
                        <form onsubmit="return deleteTask();"
                            action="/tasks/{{ $item->id }}" method="post"
                            class="inline-block text-gray-500 font-medium"
                            role="menuitem" tabindex="-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger">削除</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
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