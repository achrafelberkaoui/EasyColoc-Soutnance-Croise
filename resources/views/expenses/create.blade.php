@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Ajouter Dépense</h2>

<div class="bg-white p-6 rounded shadow max-w-lg">

<form action="{{ route('expenses.store',$colocation) }}" method="POST">
@csrf

<input type="text" name="title" placeholder="Titre"
class="w-full p-2 border rounded mb-3">

<input type="number" step="0.01" name="amount"
placeholder="Montant"
class="w-full p-2 border rounded mb-3">

<input type="date" name="date"
class="w-full p-2 border rounded mb-3">

<select name="category_id"
class="w-full p-2 border rounded mb-3">
    @foreach($categories as $category)
        <option value="{{ $category->id }}">
            {{ $category->name }}
        </option>
    @endforeach
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Ajouter
</button>

</form>
</div>
@endsection