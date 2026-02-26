<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function send(Request $request, Colocation $colocation)
    {
        $request->validate(
            [
                'email'=> 'required|email|max:200'
            ]
        );
        $token = Str::random();

        $invitation = Invitation::create([
            'email'=> $request->email,
            'token'=> $token,
            'colocation_id' => $colocation->id
        ]);

        Mail::To($request->email)->send(new InvitationMail($invitation));
        return back()->with('succes', 'invitaion envoyee');
    }
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
        ->where('status', 'pending')->firstOrFail();
        $user = Auth::user();
        $userCo = $user->colocations();
        if($userCo->where('status','active')->exists()){
        return redirect()->route('dashboard')->with('error','Vous avez deja une colocation active');
        }
        $colocation = $invitation->colocation;
        $colocation->members()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now()
        ]);
        $invitation->update(['status', 'accept']);
        return redirect()->route('colocation.show',$invitation->colocation);    
        }

        public function refuse($token)
        {
        $invitation = Invitation::where('token',$token)->where('status','pending')
        ->firstOrFail();
        $invitation->update([
        'status'=>'refused'
        ]);

        return redirect()->route('dashboard')->with('success','Invitation refusee');
        }
}
