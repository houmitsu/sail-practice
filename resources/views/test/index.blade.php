@extends('layouts.app')

@section('content')

<h3>index</h3>

<form method="GET" action="{{ route('test.index') }}">
    <input type="search" placeholder="input title" name="search" value="@if (isset($search)) {{ $search }} @endif">
    <div>
        <button type="submit">search</button>
        <button>
            <a href="{{ route('test.index') }}" class="text-white">
                clear
            </a>
        </button>
    </div>
</form>

<div>
    <a href="{{ route('test.create') }}">create</a>
</div>
@foreach ($items as $item)
    <div>
        <div>{{$item->title}}</div>
        <img src="{{ Storage::url($item->img_path) }}" width="25%">
    </div>
@endforeach

@endsection