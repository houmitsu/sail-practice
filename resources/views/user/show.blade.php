@extends('layouts.app')

@section('content')
<div class="container">
    @if(!empty($user))
    <table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>Registration Date</th>
    </tr>
    </thead>
    <tbody>
        <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->created_at }}</td>
        </tr>
    </tbody>
    </table>
    @endif
    <a href="{{ route('test.index') }}" class="alert-link">back</a><br />
</div>
@endsection