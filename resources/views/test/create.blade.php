@extends('layouts.app')

@section('content')

<form action="{{ route('test.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="user_id" value="{{$user[0]['id']}}">
<input type="text" name="title" placeholder="Input title." maxlength="200">
<input type="file" name="img_path">
<input type="submit" value="アップロード">
</form>

@endsection