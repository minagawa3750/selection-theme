@extends('layouts.app')

@section('content') 
<main>
    <div>
    <h3 class="text-center mb-3">タスクを編集</h3>  
            <form action="/tasks/{{ $task->id }}" method="post" class="mt-5">
                @csrf
                @method('PUT')

                <div class="w-50 mb-4 bg-white" style="margin: auto;">
                    <div class="form-group">
                        <label for="text" class="form-label">タスク名</label>
                        <input type="text" name="text" class="form-control bg-white" value="{{ $task->text }}">
                        @error('text')
                                <div class="mt-2">
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        @php
                            use Carbon\Carbon;
                        @endphp
                        <label for="start_date" class="form-label">開始日</label>
                        <input type="date" name="start_date" class="form-control bg-white" value="{{ \Carbon\Carbon::parse($task->start_date) }}">
                        @error('start_date')
                                <div class="mt-2">
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                </div>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label for="finish_date" class="form-label">終了日</label>
                        <input type="date" name="finish_date" class="form-control bg-white" value="{{ \Carbon\Carbon::parse($task->finish_date)->format('Y年m月d日') }}">
                        @error('finish_date')
                                <div class="mt-2">
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                </div>
                        @enderror
                    </div>
                    <div class="text-center">
                    <a href="/tasks">
                        戻る
                    </a>
                    <button type="submit" class="btn btn-primary">
                        更新する
                    </button>
                    </div>
                </div>
            </form>
    </div>
</main>

@endsection