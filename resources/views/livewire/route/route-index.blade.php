<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Routes</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('route-message'))
                    <div class="alert alert-success">
                        {{ session('route-message') }}
                    </div>
                @endif
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" wire:model="search" class="form-control mb-2"
                                        id="inlineFormInput" placeholder="Search">
                                </div>
                                <div class="col" wire:loading>
                                    <div class="spinner-border" route="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <button wire:click="showRouteModal" class="btn btn-primary">
                            New Route
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">#Id</th>
                            <th scope="col">Route</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($routes as $route)
                            <tr>
                                <th scope="row">{{ $route->id }}</th>
                         
                                <td>{{ $route->route }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $route->id }})"
                                        class="btn btn-success">Edit</button>
                                    <button wire:click="deleteRoute({{ $route->id }})"
                                        class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th>No Results</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $routes->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="routeModal" tabindex="-1" aria-labelledby="routeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($editMode)
                            <h5 class="modal-title" id="routeModalLabel">Edit Route</h5>
                        @else
                            <h5 class="modal-title" id="routeModalLabel">Create Route</h5>

                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            

                            <div class="form-group row">
                                <label for="route"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Route') }}</label>

                                <div class="col-md-6">
                                    <input id="route" type="text"
                                        class="form-control @error('route') is-invalid @enderror"
                                        wire:model.defer="route">

                                    @error('route')
                                        <span class="invalid-feedback" route="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                        @if ($editMode)
                            <button type="button" class="btn btn-primary" wire:click="updateRoute">Update
                                route</button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="storeRoute">Store
                                route</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
