<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $colocationsCount = Colocation::count();
        $expensesCount = Expense::count();
        $usersCount = User::count();

        return view('admin.dashboard', compact('colocationsCount', 'expensesCount', 'usersCount'));
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));

    }

    public function ban(User $user)
    {
        $user->is_banned = true;
        $user->save();
        
        return back()->with('success', 'utilisateur banni');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false
        ]);
        return back()->with('success', 'utilisateur debanni');
    }

}
