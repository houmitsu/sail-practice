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
        <div><a href="/user/{{ $item->user_id }}" class="alert-link">{{$item->title}}</a></div>
        <img src="{{ Storage::url($item->img_path) }}" width="25%">
        <div>
            @if($item->is_liked_by_auth_user())
              <a href="/unlike/{{ $item->id }}" class="btn btn-success btn-sm">like<span class="badge">{{ $item->likes->count() }}</span></a>
            @else
              <a href="/like/{{ $item->id }}" class="btn btn-secondary btn-sm">like<span class="badge">{{ $item->likes->count() }}</span></a>
            @endif
        </div>
    </div>
@endforeach

@endsection