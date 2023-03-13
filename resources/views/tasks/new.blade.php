@extends('layouts.app')

@section('content') 
<h3 class="text-center mb-3">タスクを追加</h3>                                                                                                 
<div class="w-50 bg-white pt-3 pr-3 pl-3 pb-3" style="margin :auto;">
    <form action="{{ route('tasks.store') }}" method="post" class="mt-10">
        @csrf
        <div class="form-group">
          <label for="text" class="form-label">タスク名</label>
          <input type="text" name="text" class="form-control bg-white">
          @error('text')
                <div class="mt-2">
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="start_date" class="form-label">開始日</label>
          <input type="date" name="start_date" class="form-control bg-white">
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
          <input type="date" name="finish_date" class="form-control bg-white">
          @error('finish_date')
                <div class="mt-2">
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                </div>
          @enderror
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-info text-white">
            追加
        </button>
        <a href="/tasks">戻る</a>
    </div>
    </form>
    
</div>
@endsection