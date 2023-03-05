@extends('layouts.app')

@section('content') 
@if ($todolists->isNotEmpty())
        <div class="container px-5 mx-auto">
            <ul>
                @foreach ($todolists as $item)
                    <li>
                        {{ $item->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection