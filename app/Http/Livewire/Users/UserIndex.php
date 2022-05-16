<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    
    public $search = '';
    public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $userId;
    public $role_id;
    public $editMode =false;
    protected $rules = [
        'username' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'password' => 'required',
        'email' => 'required|email',
        'role_id' => 'required',
    ];
    public function storeUser()
    {
        $this->validate();

        User::create([
           'username' =>  $this->username,
           'first_name' =>  $this->first_name,
           'last_name' =>  $this->last_name,
           'email' =>  $this->email,
           'password' =>  Hash::make($this->password),
           'role_id' => $this->role_id,

       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        session()->flash('user-message', 'User successfully created');
    }

    public function showUserModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }
    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;
        // find user
        $this->userId = $id;
        // load user
        $this->loadUser();
        // show Modal
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }
    public function loadUser()
    {
        $user = User::find($this->userId);
        $this->username = $user->username;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;

    }

    public function updateUser()
    {
        $validated = $this->validate([
        'username' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'role_id' => 'required',

        ]);
        $user = User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        session()->flash('user-message', 'User successfully updated');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
	if(auth()->user()->id==$user->id){
            session()->flash('user-message', 'You Cannot Delete Yourself');
            return redirect()->route('users.index');
        }
        $user->delete();

        session()->flash('user-message', 'User successfully deleted');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        $this->reset();
    }

    public function render()
    {  
        
        $users = User::paginate(5);
        if (strlen($this->search) > 2) {
            $users = User::where('username', 'like', "%{$this->search}%")->orwhere('username', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.users.user-index', [
            'users' => $users
        ])
                 ->layout('layouts.main');
    }
}