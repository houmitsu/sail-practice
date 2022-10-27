@extends('layouts.app')

@section('content')

<h3>index</h3>
<div>
    <a href="{{ route('test.create') }}">create</a>
</div>
@foreach ($items as $item)
    <img src="{{ Storage::url($item->img_path) }}" width="25%">
@endforeach

@endsection