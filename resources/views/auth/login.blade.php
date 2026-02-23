@extends('layouts.layout')

@section('content')
<form action="{{ route('login') }}" method="post">
    @csrf
<input type="text" name="email">
@error('email')
    <p style="color:red">{{ $message }}</p>
@enderror
<input type="password" name="password">
@error('password')
    <p style="color:red">{{ $message }}</p>
@enderror
<button type="submit"> Login </button>
</form>
@endsection