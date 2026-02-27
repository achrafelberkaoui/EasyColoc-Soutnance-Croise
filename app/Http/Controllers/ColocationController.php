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
        $reputation = $user->reputation;
        $isOwner = $colocations->contains(function($coloc) use ($user){
            // dd($coloc->owner_id = $user->id && $coloc->status == 'active');
            return ($coloc->owner_id == $user->id && $coloc->status == 'active');
        });

        return view('dashboard', compact('user','colocations','totalExpenses','reputation', 'isOwner'));
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
        $data = $request->only(['name']);
        $hasActive = Colocation::whereHas('members', function($st){
            $st->where('user_id', Auth::id());
        })->where('status', 'active')->exists();
        if($hasActive){
            return redirect()->route('colocation.index')->with('error', 'vous avez deja une colocation active');
        }
        $colocation = Colocation::create([
            'name'=> $data['name'],
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
        $month = request('month');
        $members = $colocation->members;
        $expenseDetails = [];
        $expenses = $colocation->expenses()->when($month, function($query, $month){
            $query->whereMonth('date', $month);
            })->with('category', 'user')->latest()->get();
            // dd($month);
            $statsCategories = $colocation->expenses()->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')->with('category')->get();
            $count = $members->count();
            foreach($expenses as $expense){
            $credits = [];
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
        
        return view('colocation.show', compact('colocation','expenseDetails','statsCategories'));
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
        ->where('user_id',$user->id)->sum('amount') >= 0;
        if($hasCredit){
            $user->increment('reputation', 1);
        }else{
            $user->decrement('reputation', 1);
        }
        $colocation->update(['status'=>'cancel']);
    } else {
        $membership = $colocation->members()->where('user_id',$user->id)->first();
        $hasCredit = $colocation->expenses()
        ->where('user_id',$membership->id)->sum('amount') >= 0;
        if($hasCredit){
            $membership->increment('reputation', 1);
        }else{
            $membership->decrement('reputation', 1);
        }
        if($membership) {
            $membership->pivot->update(['left_at'=>now()]);
            $colocation->members()->detach($user->id);
        }
    }
    return redirect()->route('colocation.index')
    ->with('success', 'Colocation mise a jour avec succes.');
}
    
}
