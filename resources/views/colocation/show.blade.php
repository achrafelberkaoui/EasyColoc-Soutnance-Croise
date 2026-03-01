@extends('layouts.layout')

@section('content')

<div class="max-w-6xl mx-auto">

<h2 class="text-2xl font-bold mb-6">{{ $colocation->name }}</h2>

<div class="grid md:grid-cols-3 gap-6">
    
    <!-- Filter -->
    <form method="GET" class="mb-4">
        <select name="month" class="border p-2 rounded">
        <option value="">Tous les mois</option>
        @for($i=1;$i<=12;$i++)
        <option value="{{ $i }}">
        Mois {{ $i }}
        </option>
        @endfor
        </select>
    <button class="bg-gray-600 text-white px-3 py-1 rounded">
    Filtrer
    </button>
    </form>
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

        @if($colocation->owner_id == auth()->id() && $colocation->status == 'active')
        <div class="mt-6">
            <h3 class="font-bold text-lg mb-3">Inviter</h3>
            <form action="{{ route('invitation.send',$colocation) }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" required
                       class="w-full border p-2 rounded mb-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Envoyer</button>
            </form>
        </div>
        @endif
    </div>

</div>

    <!-- categories  -->
    <div class="bg-white p-6 rounded shadow mt-8">
    <h3 class="font-bold mb-3">Statistiques par catégorie</h3>
    @foreach($statsCategories as $stat)
    <p>
    {{ $stat->category->name }} :
    <strong>{{ $stat->total }} DH</strong>
    </p>
    @endforeach
    </div>

    <!-- EXPENSES -->
        <div class="bg-white p-6 rounded shadow mt-8">
        <h3 class="font-bold mb-4">Remboursements</h3>
        @foreach($expenseDetails as $expense)
        @foreach($expense['credits'] as $credit)
        <p>
        {{ $credit['name'] }} doit
        <strong>{{ $credit['credit'] }} DH</strong>
        à
        {{ $expense['paid_by'] }}
        </p>
        @endforeach
        @endforeach
        </div>

<div class="bg-white p-6 rounded shadow mt-8">
    
    @if($colocation->status == 'active')
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">Dépenses</h3>
            <a href="{{ route('expenses.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Ajouter</a>
        </div>
    @endif

  @forelse($expenseDetails as $expense)
    <div class="border p-4 rounded mb-4">
        <div class="flex justify-between items-center">
            <h4 class="font-bold">{{ $expense['title'] }} 
                <span class="text-sm text-gray-500">({{ $expense['category'] }})</span>
            </h4>

        @if($expense['creator_id'] == auth()->id())
            <span class="text-green-600 font-semibold">Payée</span>
        @elseif($expense['is_paid'])
            <span class="text-green-600 font-semibold">Payée</span>
        @else
            <span class="text-red-600 font-semibold">Non payée</span>
        @endif
        </div>

        <p class="mt-2">Montant : <strong>{{ $expense['amount'] }} DH</strong></p>
        <p>Payé par : {{ $expense['paid_by'] }}</p>

        @if(count($expense['credits']) > 0)
            <p class="font-semibold mt-2">Qui doit :</p>
            <ul class="ml-4 list-disc">
                @foreach($expense['credits'] as $credit)
                    @if($credit['name'] != $expense['paid_by'])
                        <li>{{ $credit['name'] }} doit {{ $credit['credit'] }} DH</li>
                    @endif
                @endforeach
            </ul>
        @endif

       <!-- ACTIONS -->
        <div class="mt-3 flex gap-2">
        <!-- Button Payée -->
        @if($expense['creator_id'] != auth()->id() &&!$expense['is_paid'])            
        <form action="{{ route('expenses.markPaid', $expense['id']) }}" method="POST" class="mt-2">
                @csrf
                @method('PATCH')
                <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Marquer payé</button>
            </form>
        @endif
            @if($expense['creator_id'] == auth()->id())  
            <!-- Modifier -->
                <a href="{{ route('expenses.edit',$expense['id']) }}"
                class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                
                Modifier
                
                </a>
            @endif
            <!-- Supprimer -->
            @if($expense['creator_id'] == auth()->id())
                <form action="{{ route('expenses.destroy', $expense['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Supprimer</button>
                </form>
            @endif

        </div>


    </div>
@empty
    <p class="text-gray-500">Aucune dépense pour le moment.</p>
@endforelse
</div>

</div>

</div>

@endsection