@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Modifier Dépense</h2>

<div class="bg-white p-6 rounded shadow max-w-lg">

<form action="{{ route('expenses.update',$expense) }}" method="POST">
@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $expense->title }}"
class="w-full p-2 border rounded mb-3">

<input type="number"
step="0.01"
name="amount"
value="{{ $expense->amount }}"
class="w-full p-2 border rounded mb-3">

<input type="date"
name="date"
value="{{ $expense->date }}"
class="w-full p-2 border rounded mb-3">

<select name="category_id"
class="w-full p-2 border rounded mb-3">

@foreach($categories as $category)

<option value="{{ $category->id }}"
@if($expense->category_id == $category->id) selected @endif>

{{ $category->name }}

</option>

@endforeach

</select>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
Modifier
</button>

</form>

</div>
@endsection