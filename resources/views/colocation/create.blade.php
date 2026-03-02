@extends('layouts.layout')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
<h2 class="text-2xl font-bold mb-4">Créer Colocation</h2>

<div class="bg-white p-6 rounded shadow max-w-md">
    <form action="{{ route('colocation.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nom colocation" class="w-full p-2 border rounded mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer</button>
    </form>
</div>
@endsection