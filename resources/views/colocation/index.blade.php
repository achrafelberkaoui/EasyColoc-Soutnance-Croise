@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Mes Colocations</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($colocations as $coloc)
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-xl font-semibold">{{ $coloc->name }}</h3>
        <p>Owner: {{ $coloc->owner->name }}</p>
        <p>Status: {{ $coloc->status }}</p>
        <p>Membres: {{ $coloc->members->count() }}</p>
        <div class="mt-4 flex gap-2">
            <a href="{{ route('colocation.show', $coloc->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Voir</a>
            @if($coloc->owner_id === auth()->id())
            <a href="#" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Éditer</a>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">
    <a href="{{ route('colocation.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Créer une colocation</a>
</div>
@endsection