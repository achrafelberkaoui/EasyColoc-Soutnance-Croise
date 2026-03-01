@extends('layouts.layout')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

<h2 class="text-2xl font-bold mb-6">Mon Profil</h2>

@if(session('success'))
<p class="text-green-600 mb-4">{{ session('success') }}</p>
@endif

<form action="{{ route('profile.update') }}" method="POST">
@csrf
@method('PATCH')

<div class="mb-4">
<label class="block font-semibold">Nom</label>
<input type="text" name="name" value="{{ $user->name }}"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label class="block font-semibold">Email</label>
<input type="email" name="email" value="{{ $user->email }}"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label class="block font-semibold">Réputation</label>
<input type="text" value="{{ $user->reputation }}"
class="w-full border p-2 rounded bg-gray-100" disabled>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Modifier
</button>

</form>

</div>

@endsection