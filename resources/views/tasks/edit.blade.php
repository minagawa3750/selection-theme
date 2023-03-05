@extends('layouts.app')

@section('content') 
<main class="text-center">
    <div>
            <form action="/tasks/{{ $task->id }}" method="post" class="mt-5">
                @csrf
                @method('PUT')

                <div class="w-50 mb-4" style="margin: auto;">
                    <input class="form-control form-control-lg bg-white" type="text" name="task_name" value="{{ $task->name }}" />
                    @error('task_name')
                        <div class="mt-3">
                            <p class="text-danger">
                            {{ $message }}
                            </p>
                        </div>
                    @enderror
                </div>
                    <a href="/tasks">
                        戻る
                    </a>
                    <button type="submit" class="btn btn-primary">
                        更新する
                    </button>
            </form>
    </div>
</main>

@endsection