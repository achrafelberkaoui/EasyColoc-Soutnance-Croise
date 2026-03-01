<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\payment;
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

    $expenses = $colocation->expenses()
        ->when($month, function($query, $month){
            $query->whereMonth('date', $month);
        })->with('category', 'user', 'payments.fromUser')->latest()->get();

    $statsCategories = $colocation->expenses()
        ->selectRaw('category_id, sum(amount) as total')
        ->groupBy('category_id')->with('category')->get();

    foreach($expenses as $expense){
        $payments = $expense->payments;
        $isPaid = $payments->where('from_user_id','!=', $expense->user_id)
        ->where('is_paid', false)->count() == 0;

        $credits = [];
        foreach ($payments as $payment) {
        if($payment->from_user_id == $expense->user_id){
            continue;
        }
            if(!$payment->is_paid){
                $credits[] = [
                    'name' => $payment->fromUser->name,
                    'credit' => round($payment->amount, 2)
                ];
            }
        }
        $expenseDetails[] = [
            'creator_id' => $expense->user_id,
            'id' => $expense->id,
            'title' => $expense->title,
            'amount' => $expense->amount,
            'paid_by'=> $expense->user->name,
            'is_paid'=> $isPaid,
            'credits'=> $credits,
            'category'=> $expense->category->name
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

    $hasDebt = payment::where('colocation_id', $colocation->id)
    ->where('from_user_id', $user->id)->where('is_paid', false)->exists(); 
    if($hasDebt){
        $user->decrement('reputation',1);
    }else{
        $user->increment('reputation',1);
    }

    if($colocation->owner_id == $user->id){
        $colocation->update([
            'status'=>'cancel'
        ]);
    }else{
        $membership = $colocation->members()
        ->where('user_id', $user->id)->first();
        if($membership){
            $membership->pivot->update([
                'left_at'=>now()
            ]);
            $colocation->members()->detach($user->id);
        }
    }

    return redirect()->route('colocation.index')
    ->with('success', 'Colocation mise a jour avec succes.');
}
    
}
