<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
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
    public function store(Request $request)
    {
        $colocation = Auth::user()->activeColocation()->first();
        $request->validate([
            'title'=>'required|max:100',
            'amount'=>'required|numeric|min:0',
            'date'=>'required|date',
            'category_id'=>'required'
            
        ]);
        Expense::create([
            'title'=>$request->title,
            'amount'=>$request->amount,
            'date'=>$request->date,
            'colocation_id'=>$colocation->id,
            'user_id'=>auth()->id(),
            'category_id'=>$request->category_id
        ]);
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
        $categories = $expense->colocation->categories;
        return view('expenses.edit', compact('expense', 'categories'));
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
    public function destroy(Expense $expense, Colocation $colocation)
    {
        $colocation->load('members.expenses', 'expenses', 'owner');
        $expense->delete();

        return back()->with('success', 'Depense supprime');
    }
public function markPaid(Expense $expense)
{
    // if ($expense->colocation_id !== auth()->user()->activeColocation->id) {
    //     abort(403);
    // }

    $expense->update([
        'is_paid' => true
    ]);


    return back()->with('success','Depense marquee payee');
}
}
