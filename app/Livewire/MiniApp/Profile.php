<?php

namespace App\Livewire\MiniApp;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public function mount($id = null)
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        }
        if (Auth::check()) {
            return redirect()->route('register');
        } else {
            $user = User::where('chat_id', $id)->first();
            Auth::login($user, true);
        }
    }
    public function render()
    {
        return view('livewire.mini-app.profile');
    }
}
