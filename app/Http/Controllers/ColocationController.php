<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $colocations = $user->colocations;
        $totalExpenses = 0;
        $totalBalance = 0;

        return view('dashboard', compact('user','colocations','totalExpenses','totalBalance'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Auth::user()->colocations;
        return view('colocation.index', compact('colocations'));    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colocation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:200'
        ]);
        $hasActive = Colocation::whereHas('members', function($st){
            $st->where('user_id', Auth::id());
        })->where('status', 'active')->exists();
        if($hasActive){
            return redirect()->route('colocation.index')->with('error', 'vous avez deja une colocation active');
        }
        $colocation = Colocation::create([
            'name'=> $request->name,
            'owner_id'=>Auth::id()
        ]);
        $colocation->members()->attach(Auth::id(),[
            'role'=> 'owner',
            'joined_at' => now()
        ]);
        return redirect()->route('colocation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $colocation->load('members', 'owner', 'expenses');
        $balances = [];
        return view('colocation.show', compact('balances', 'colocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function cancel(Colocation $colocation)
{
    $user = Auth::user();

    if($colocation->owner_id == $user->id) {
        $colocation->update(['status'=>'cancel']);
    } else {
        $membership = $colocation->members()->where('user_id',$user->id)->first();
        if($membership) {
            $membership->pivot->update(['left_at'=>now()]);
        }
    }

    return redirect()->route('colocation.index')
        ->with('success', 'Colocation mise à jour avec succès.');
}
    
}
