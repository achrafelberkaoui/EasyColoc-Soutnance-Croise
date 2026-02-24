@extends('layouts.layout')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer un compte</h2>
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nom complet" 
               class="w-full p-2 border border-gray-300 rounded" value="{{ old('name') }}">
        @error('name')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input type="email" name="email" placeholder="email@example.com"
               class="w-full p-2 border border-gray-300 rounded" value="{{ old('email') }}">
        @error('email')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input type="password" name="password" placeholder="Mot de passe"
               class="w-full p-2 border border-gray-300 rounded">
        @error('password')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe"
               class="w-full p-2 border border-gray-300 rounded">
        @error('password_confirmation')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">S'inscrire</button>
    </form>
</div>
@endsection