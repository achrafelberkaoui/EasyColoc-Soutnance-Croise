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
        <div class="bg-white p-6 rounded shadow mt-6">
        
            <h3 class="font-bold text-lg mb-4">Inviter un membre</h3>
        
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        
            <form action="{{ route('invitation.send',$colocation) }}" method="POST">
                @csrf
        
                <input type="email"
                       name="email"
                       placeholder="Email du membre"
                       required
                       class="w-full border p-3 rounded mb-3">
        
                <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                    Envoyer invitation
                </button>
            </form>
        
        </div>
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