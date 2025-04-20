<?php

namespace App\Livewire;

use App\Models\Massenger;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class Chat extends Component
{
    public $to;
    public $user_to;
    public $massageText;
    public $search = "";
    public function mount()
    {
        $users = $this->users;

        if ($users->isNotEmpty()) {
            $this->to = $users[0]->id;
            if ($this->to == auth()->user()->id) {
                $this->to = $users->count() > 1 ? $users[1]->id : $this->to;
            }
        }
    }

    #[Computed]
    public function users()
    {
        return User::latest('last_chat_at')->search($this->search)->get();
    }

    public function render()
    {

        $massage = Massenger::with('user')->latest()->take(50)->get()->sortBy('id');
        $massageText = $this->massageText;

        return view('livewire.chat', ['massage' => $massage, 'massageText' => $massageText]);
    }
    public function sendMessage(Massenger $Massenger)
    {
        $userId = Auth::id();
        Massenger::create([
            'user_id' => $userId,
            'massage_text' => $this->massageText,
            'to' => $this->to,
        ]);
        User::where('id', $this->to)->update(['last_chat_at' => now()]);
        // $this->reset('massageText');
        $this->massageText = "";
    }
    public function updateTo($newTo)
    {
        $this->to = $newTo;
        $this->user_to = User::find($this->to);
    }
}
