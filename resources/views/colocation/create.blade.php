@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Créer Colocation</h2>

<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('colocation.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nom colocation" class="w-full p-2 border rounded mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer</button>
    </form>
</div>
@endsection