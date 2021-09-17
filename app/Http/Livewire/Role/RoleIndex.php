<?php

namespace App\Http\Livewire\Role;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class RoleIndex extends Component
{
    public $search = '';
    public $name;
    public $editMode = false;
    public $roleId;

    protected $rules = [
        'name' => 'required',
    ];

    public function showEditModal($id)
    {
        $this->reset();
        $this->roleId = $id;
        $this->loadRoles();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#roleModal', 'actionModal' => 'show']);
    }

    public function loadRoles()
    {
        $role = Role::find($this->roleId);
        $this->name = $role->name;
    }
    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();
        session()->flash('role-message', 'Role successfully deleted');
    }
    public function showRoleModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#roleModal', 'actionModal' => 'show']);
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#roleModal', 'actionModal' => 'hide']);
    }
    public function storeRole()
    {
        $this->validate();
        Role::create([
           'name'         => $this->name
       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#roleModal', 'actionModal' => 'hide']);
        session()->flash('role-message', 'Role successfully created');
    }
    public function updateRole()
    {
        $validated = $this->validate([
            'name'        => 'required'
        ]);
        $role = Role::find($this->roleId);
        $role->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#roleModal', 'actionModal' => 'hide']);
        session()->flash('role-message', 'Role successfully updated');
    }
    public function render()
    {
        $roles = Role::paginate(5);
        if (strlen($this->search) > 2) {
            $roles = Role::where('name', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.role.role-index', [
            'roles' => $roles
        ])->layout('layouts.main');
    }
}
