@extends('layouts.layout')

@section('content')

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Nombre Utilisateurs -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total Utilisateurs</h2>
            <p class="text-3xl font-bold mt-2">{{ $usersCount }}</p>
        </div>

        <!-- Nombre Colocations -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total Colocations</h2>
            <p class="text-3xl font-bold mt-2">{{ $colocationsCount }}</p>
        </div>

        <!-- Total Dépenses -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total Dépenses</h2>
            <p class="text-3xl font-bold mt-2">{{ $expensesCount }}</p>
        </div>

    <a href="{{ route('admin.users') }}"
       class="bg-blue-500 text-white p-4 rounded text-center hover:bg-blue-600">
        Voir les utilisateurs
    </a>

    </div>

</div>

@endsection