@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Mes Catégories</h2>
@if(session('succes'))
<p>{{session('succes')}}</p>
@endif
<div class="mb-6">
<form action="{{ route('categories.store') }}" method="POST" class="flex gap-2">
@csrf
<input type="text" name="name" placeholder="Nouvelle catégorie" class="border p-2 rounded flex-1">
<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
</form>
</div>

<table class="w-full bg-white rounded shadow">
<thead class="bg-gray-100">
<tr>
<th class="p-2">Nom</th>
<th class="p-2">Action</th>
</tr>
</thead>
<tbody>
@foreach($categories as $category)
<tr class="border-t">
<td class="p-2 text-center">{{ $category->name }}</td>
<td class="p-2 text-center">
    <form action="{{ route('categories.destroy', $category) }}" 
          method="POST" 
          onsubmit="return confirm('Supprimer cette catégorie ?')" 
          class="inline-block">
        @csrf
        @method('DELETE')
        <button class="bg-red-500 text-white px-2 py-1 rounded">
            Supprimer
        </button>
    </form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection