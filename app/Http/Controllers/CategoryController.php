<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = auth()->user()->categories()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required|max:100']);
        // dd('ffff');
        auth()->user()->categories()->create([
            'name'=>$request->name
        ]);
        return back()->with('success','Categorie ajoute !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(Category $category)
    {
        if(auth()->id() != $category->user_id){
            abort(403);
        }
        $category->delete();
        return back()->with('succes', 'categorie supprime succes');
    }
}
