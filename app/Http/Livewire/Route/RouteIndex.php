<?php

namespace App\Http\Livewire\Route;

use App\Models\Route;
use Livewire\Component;

class RouteIndex extends Component
{
    public $search = '';
    public $route;
    public $editMode = false;
    public $routeId;

    protected $rules = [
        'route' => 'required',
    ];

    public function showEditModal($id)
    {
        $this->reset();
        $this->routeId = $id;
        $this->loadRoutes();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#routeModal', 'actionModal' => 'show']);
    }

    public function loadRoutes()
    {
        $route = Route::find($this->routeId);
        $this->route = $route->route;
    }
    public function deleteRoute($id)
    {
        $route = Route::find($id);
        $route->delete();
        session()->flash('route-message', 'Route successfully deleted');
    }
    public function showRouteModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#routeModal', 'actionModal' => 'show']);
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#routeModal', 'actionModal' => 'hide']);
    }
    public function storeRoute()
    {
        $this->validate();
        Route::create([
           'route'         => $this->route
       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#routeModal', 'actionModal' => 'hide']);
        session()->flash('route-message', 'Route successfully created');
    }
    public function updateRoute()
    {
        $validated = $this->validate([
            'route'        => 'required'
        ]);
        $route = Route::find($this->routeId);
        $route->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#routeModal', 'actionModal' => 'hide']);
        session()->flash('route-message', 'Route successfully updated');
    }
    public function render()
    {
        $routes = Route::paginate(5);
        if (strlen($this->search) > 2) {
            $routes = Route::where('route', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.route.route-index', [
            'routes' => $routes
        ])->layout('layouts.main');
    }
}
