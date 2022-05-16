<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;

    
    public $search = '';
    public $name;
    public $route_id;
    public $employeeId;
    public $editMode =false;
    public $matricule;
    public $tagid;
    public $Presence;

    protected $rules = [
        'name' => 'required',
        'route_id' => 'required',
        'matricule' => 'required',
        'tagid' => 'required',
        'Presence' => 'required',
    ];
    public function storeEmployee()
    {
        $this->validate();

        Employee::create([
           'name' =>  $this->name,
           'route_id' => $this->route_id,
           'matricule' =>  $this->matricule,
           'tagid' =>  $this->tagid,
           'Presence' => $this->Presence,

       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee-message', 'Employee successfully created');
    }

    public function showEmployeeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }
    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;
        // find employee
        $this->employeeId = $id;
        // load employee
        $this->loadEmployee();
        // show Modal
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }
    public function loadEmployee()
    {
        $employee = Employee::find($this->employeeId);
        $this->name = $employee->name;
        $this->route_id = $employee->route_id;
        $this->matricule = $employee->matricule;
        $this->tagid = $employee->tagid;
        $this->Presence = $employee->Presence;

    }

    public function updateEmployee()
    {
        $validated = $this->validate([
        'name' => 'required',
        'route_id' => 'required',
        'matricule' => 'required',
        'tagid' => 'required',
        'Presence' => 'required',

        ]);
        $employee = Employee::find($this->employeeId);
        $employee->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee-message', 'Employee successfully updated');
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        session()->flash('employee-message', 'Employee successfully deleted');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        $this->reset();
    }

    public function render()
    {  
        
        $employees = Employee::paginate(5);
        if (strlen($this->search) > 2) {
            $employees = Employee::where('name', 'like', "%{$this->search}%")->orwhere('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.employee.employee-index', [
            'employees' => $employees
        ])
                 ->layout('layouts.main');
    }
}