@extends('layouts.layout')

@section('content')
<form action="{{ route('register') }}" method="POST">
    @csrf

<input type="text" name="name" placeholder="name">
    @error('name')
    <p style="color:red">{{ $message }}</p>
    @enderror

<input type="text" name="email" placeholder="email@example.com">
@error('email')
    <p style="color:red">{{ $message }}</p>
@enderror

<input type="password"  name="password" placeholder="*********">
@error('password')
    <p style="color:red">{{ $message }}</p>
@enderror
<input type="password"  name="password_confirmation" placeholder="*********">
@error('password_confirmation')
    <p style="color:red">{{ $message }}</p>
@enderror
<button type="submit"> Register </button>
</form>
@endsection