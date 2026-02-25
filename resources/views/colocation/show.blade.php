@extends('layouts.layout')

@section('content')

<h2 class="text-2xl font-bold mb-6">{{ $colocation->name }}</h2>

<div class="grid md:grid-cols-3 gap-6">

    <!-- INFO -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-bold mb-2">Informations</h3>
        <p>Owner : {{ $colocation->owner->name }}</p>
        <p>Status : {{ $colocation->status }}</p>
        <p>Membres : {{ $colocation->members->count() }}</p>
    </div>

    <!-- MEMBRES -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-bold mb-2">Membres</h3>
        <ul class="space-y-2">
            @foreach($colocation->members as $member)
            <li class="flex justify-between">
                <span>{{ $member->name }}</span>
                <span class="text-sm text-gray-500">{{ $member->pivot->role }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- SOLDE -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-bold mb-2">Balances</h3>
        @foreach($balances as $name => $amount)
            <p>{{ $name }} : {{ $amount }} €</p>
        @endforeach
    </div>

</div>

@endsection