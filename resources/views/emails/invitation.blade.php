<h2>Invitation EasyColoc</h2>

<p>Vous êtes invité à rejoindre :</p>
<p><strong>{{ $invitation->colocation->name }}</strong></p>

<p>
    <a href="{{ route('invitation.accept', $invitation->token) }}" 
       style="background:green;color:white;padding:8px 12px;border-radius:4px;text-decoration:none;">
       Accepter l'invitation
    </a>
</p>

<p>
    <a href="{{ route('invitation.refuse', $invitation->token) }}" 
       style="background:red;color:white;padding:8px 12px;border-radius:4px;text-decoration:none;">
       Refuser l'invitation
    </a>
</p>