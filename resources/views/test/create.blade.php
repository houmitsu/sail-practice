@extends('layouts.app')

@section('content')

<form action="{{ route('test.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="file" name="img_path">
<input type="submit" value="アップロード">
</form>

@endsection