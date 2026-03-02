@extends('layouts.layout')

@section('content')

<h2 class="text-2xl font-bold mb-6">Gestion Utilisateurs</h2>

@foreach($users as $user)

<div class="border p-4 mb-3 rounded flex justify-between">

<div>
<p><strong>{{ $user->name }}</strong></p>
<p>{{ $user->email }}</p>
</div>

@if($user->is_banned)

<form action="{{ route('admin.unban',$user) }}" method="POST">
@csrf
@method('PATCH')

<button class="bg-green-600 text-white px-3 py-1 rounded">
Débannir
</button>

</form>

@else

<form action="{{ route('admin.ban',$user) }}" method="POST">
@csrf
@method('PATCH')

<button class="bg-red-600 text-white px-3 py-1 rounded">
Bannir
</button>

</form>

@endif

</div>

@endforeach

@endsection