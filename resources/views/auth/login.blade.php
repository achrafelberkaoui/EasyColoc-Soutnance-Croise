@extends('layouts.layout')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
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
        <input type="email" name="email" placeholder="email@example.com"
               class="w-full p-2 border border-gray-300 rounded" value="{{ old('email') }}">
        <input type="password" name="password" placeholder="Mot de passe"
               class="w-full p-2 border border-gray-300 rounded">

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Se connecter</button>
    </form>
</div>
@endsection