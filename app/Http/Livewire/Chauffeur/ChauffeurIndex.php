<?php

namespace App\Http\Livewire\Chauffeur;

use App\Models\Chauffeur;
use Livewire\Component;

class ChauffeurIndex extends Component
{
    public $search = '';
    public $first_name;
    public $last_name;
    public $cin;
    public $name;
    public $address;
    public $editMode = false;
    public $chauffeurId;

    protected $rules = [
        'name' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'cin' => 'required',
        'address' => 'required',

    ];

    public function showEditModal($id)
    {
        $this->reset();
        $this->chauffeurId = $id;
        $this->loadChauffeurs();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#chauffeurModal', 'actionModal' => 'show']);
    }

    public function loadChauffeurs()
    {
        $chauffeur = Chauffeur::find($this->chauffeurId);
        $this->name = $chauffeur->name;
        $this->cin = $chauffeur->cin;
        $this->first_name = $chauffeur->first_name;
        $this->last_name = $chauffeur->last_name;
        $this->address= $chauffeur->address;
    }
    public function deleteChauffeur($id)
    {
        $chauffeur = Chauffeur::find($id);
        $chauffeur->delete();
        session()->flash('chauffeur-message', 'Chauffeur successfully deleted');
    }
    public function showChauffeurModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#chauffeurModal', 'actionModal' => 'show']);
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#chauffeurModal', 'actionModal' => 'hide']);
    }
    public function storeChauffeur()
    {
        $this->validate();
        Chauffeur::create([
           'name'         => $this->name,
           'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'cin' => $this->cin,
        'address' => $this->address,

       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#chauffeurModal', 'actionModal' => 'hide']);
        session()->flash('chauffeur-message', 'Chauffeur successfully created');
    }
    public function updateChauffeur()
    {
        $validated = $this->validate([
            'name'        => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'cin' => 'required',
            'address' => 'required',
        ]);
        $chauffeur = Chauffeur::find($this->chauffeurId);
        $chauffeur->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#chauffeurModal', 'actionModal' => 'hide']);
        session()->flash('chauffeur-message', 'Chauffeur successfully updated');
    }
    public function render()
    {
        $chauffeurs = Chauffeur::paginate(5);
        if (strlen($this->search) > 2) {
            $chauffeurs = Chauffeur::where('name', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.chauffeur.chauffeur-index', [
            'chauffeurs' => $chauffeurs
        ])->layout('layouts.main');
    }
}
