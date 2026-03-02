@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Dashboard</h2>
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

@if($isOwner)
<div class="bg-blue-100 p-4 rounded mt-6">
    <h3 class="font-bold text-blue-700">Mode Owner</h3>
    <p>Vous gérez au moins une colocation.</p>
</div>
@else
<div class="bg-gray-100 p-4 rounded mt-6">
    <h3 class="font-bold text-gray-700">Mode Membre</h3>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold text-gray-500">Mes colocations</h3>
        <p class="text-3xl font-bold mt-2">{{ $user->colocations->count() }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold text-gray-500">Dépenses totales</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalExpenses ?? 0 }} DH</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold text-gray-500">Reputation</h3>
        <p class="text-3xl font-bold mt-2">{{ $reputation ?? 0 }}</p>
    </div>

</div>
@endsection