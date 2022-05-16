<?php

namespace App\Http\Livewire\Vehicule;

use App\Models\Vehicule;
use Livewire\Component;
use Livewire\WithPagination;

class VehiculeIndex extends Component
{
    use WithPagination;

    
    public $search = '';
    public $vehiculeId;
    public $editMode =false;
    public $type;
    public $matricule;

    protected $rules = [
        'type' => 'required',

        'matricule' => 'required',
    ];
    public function storeVehicule()
    {
        $this->validate();

        Vehicule::create([
            'type' =>  $this->type,
           'matricule' =>  $this->matricule,

       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#vehiculeModal', 'actionModal' => 'hide']);
        session()->flash('vehicule-message', 'Vehicule successfully created');
    }

    public function showVehiculeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#vehiculeModal', 'actionModal' => 'show']);
    }
    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;
        // find vehicule
        $this->vehiculeId = $id;
        // load vehicule
        $this->loadVehicule();
        // show Modal
        $this->dispatchBrowserEvent('modal', ['modalId' => '#vehiculeModal', 'actionModal' => 'show']);
    }
    public function loadVehicule()
    {
        $vehicule = Vehicule::find($this->vehiculeId);
        $this->type = $vehicule->type;

        $this->matricule = $vehicule->matricule;

    }

    public function updateVehicule()
    {
        $validated = $this->validate([
            'type' => 'required',

        'matricule' => 'required',

        ]);
        $vehicule = Vehicule::find($this->vehiculeId);
        $vehicule->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#vehiculeModal', 'actionModal' => 'hide']);
        session()->flash('vehicule-message', 'Vehicule successfully updated');
    }

    public function deleteVehicule($id)
    {
        $vehicule = Vehicule::find($id);
        $vehicule->delete();
        session()->flash('vehicule-message', 'Vehicule successfully deleted');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('modal', ['modalId' => '#vehiculeModal', 'actionModal' => 'hide']);
        $this->reset();
    }

    public function render()
    {  
        
        $vehicules = Vehicule::paginate(5);
        if (strlen($this->search) > 2) {
            $vehicules = Vehicule::where('type', 'like', "%{$this->search}%")->orwhere('type', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.vehicule.vehicule-index', [
            'vehicules' => $vehicules
        ])
                 ->layout('layouts.main');
    }
}