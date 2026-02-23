@extends('layouts.layout')

@section('content')

<p>Welcome {{ auth()->user()->name }}</p>

<form method="POST">
    @csrf
    <input name="name" placeholder="Colocation name">
    <button type="submit">Create Colocation</button>
</form>

<form method="POST" action="/logout">
    @csrf
    <button type="submit">Logout</button>
</form>

@endsection