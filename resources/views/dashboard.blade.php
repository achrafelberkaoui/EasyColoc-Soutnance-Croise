@extends('layouts.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6">Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold text-gray-500">Mes colocations</h3>
        <p class="text-3xl font-bold mt-2">{{ $user->colocations->count() }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold text-gray-500">Dépenses totales</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalExpenses ?? 0 }} €</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-semibold text-gray-500">Balance totale</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalBalance ?? 0 }} €</p>
    </div>

</div>
@endsection