<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidatRequest;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $colocation = auth()->user()->activeColocation()->first();
        // $expenses = $colocation->expenses()->with('category','user')
        // ->latest()->get();
        // return view('expenses.index', compact('expenses', 'colocation'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Colocation $colocation)
    {
        
        $categories = auth()->user()->categories()->get();
        // dd($categories);
        return view('expenses.create', compact('colocation', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidatRequest $request)
    {
        $colocation = Auth::user()->activeColocation()->first();
        $data = $request->only(['title','amount','date','category_id']);
        $expense = Expense::create([
            'title'=>$data['title'],
            'amount'=>$data['amount'],
            'date'=>$data['date'],
            'colocation_id'=>$colocation->id,
            'user_id'=>auth()->id(),
            'category_id'=>$data['category_id']
        ]);
        $members = $colocation->members;
        $count = $members->count();
        $credit = $expense->amount / $count;

        foreach($members as $member){
            if ($member->id == $expense->user_id) {
                continue;
            }
            Payment::create([
                'expense_id'=>$expense->id,
                'colocation_id'=> $colocation->id,
                'from_user_id'=> $member->id,
                'to_user_id'=> $expense->user_id,
                'amount'=> $credit,
                'is_paid'=> false
            ]);
        }
        return redirect()->route('colocation.show',$colocation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        if ($expense->colocation_id !== auth()->user()->activeColocation->first()->id) {
        abort(403, 'aucun colocation Active');
        }
        $categories = auth()->user()->categories;
        // dd($categories);
        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidatRequest $request, Expense $expense)
    {
    $colocation = auth()->user()->activeColocation()->first();

    if ($expense->colocation_id !== ($colocation->id ?? 0)) {
        abort(403,'aucun colocation Active');
    }

    $data = $request->only([
        'title',
        'amount',
        'date',
        'category_id'
    ]);

    $expense->update($data);

    return redirect()->route('colocation.show',$colocation)->with('success','Depense modifiee');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense, Colocation $colocation)
    {
    if ($expense->colocation_id !== (auth()->user()->activeColocation()->first()->id ?? 0)) {
        abort(403, 'aucun colocation Active');
    }
        $colocation->load('members.expenses', 'expenses', 'owner');
        $expense->delete();

        return back()->with('success', 'Depense supprime');
    }
public function markPaid(Expense $expense)
{
    if ($expense->colocation_id !== auth()->user()->activeColocation->first()->id) {
        abort(403, 'aucun colocation Active');
    }

    $expense->update([
        'is_paid' => true
    ]);
    Payment::where('expense_id', $expense->id)->update([
        'is_paid'=>true
    ]);


    return back()->with('success','Paiment enregistre');
}
}
