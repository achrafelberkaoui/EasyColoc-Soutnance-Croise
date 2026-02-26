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
        $totalExpenses = $user->expenses()->sum('amount');
        $reputation = $user->repetation;



        return view('dashboard', compact('user','colocations','totalExpenses','reputation'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Auth::user()->colocations;
        return view('colocation.index', compact('colocations'));    
    }

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
        $colocation->load('members.expenses', 'expenses', 'owner');

        $members = $colocation->members;
        $credits = [];
        $expenseDetails = [];
        $expenses = $colocation->expenses;
        $count = $members->count();
        foreach($expenses as $expense){
            $share = $count > 0 ? $expense->amount / $count : 0;
            foreach ($members as $member) {
            if($member->id == $expense->user_id){
                continue;
            }
                $credits[] = [
                    'name' => $member->name,
                    'credit' => round($share, 2)
                ];
            }
            $expenseDetails [] = [
                
                'creator_id' => $expense->user_id,
                'id' => $expense->id,
                'title' => $expense->title,
                'amount' => $expense->amount,
                'paid_by'=> $expense->user->name,
                'is_paid'=>$expense->is_paid,
                'credits'=>$credits,
                'category'=>$expense->category->name,
                'credit' => round($share, 2)
            ];
        }
        // $membership = $coloc->members->firstWhere('id', auth()->id());
        
        return view('colocation.show', compact('colocation','expenseDetails'));
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
        $hasCredit = $colocation->expenses()
        ->where('user_id',$user->id)->sum('amount') > 0;
        if($hasCredit){
            $user->increment('repetation', 1);
        }else{
            $user->decrement('repetation', 1);
        }
        $colocation->update(['status'=>'cancel']);
    } else {
        $membership = $colocation->members()->where('user_id',$user->id)->first();
        if($membership) {
            $membership->pivot->update(['left_at'=>now()]);
        }
    }
    return redirect()->route('colocation.index')
    ->with('success', 'Colocation mise a jour avec succes.');
}
    
}
