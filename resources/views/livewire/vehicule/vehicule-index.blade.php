<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Vehicules</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('vehicule-message'))
                    <div class="alert alert-success">
                        {{ session('vehicule-message') }}
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
                                    <div class="spinner-border" vehicule="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <button wire:click="showVehiculeModal" class="btn btn-primary">
                            New Vehicule
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">#Id</th>
                            <th scope="col">Type</th>
                            <th scope="col">Matricule</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicules as $vehicule)
                            <tr>
                                <th scope="row">{{ $vehicule->id }}</th>
                         
                                <td>{{ $vehicule->type }}</td>
                                <td>{{ $vehicule->matricule }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $vehicule->id }})"
                                        class="btn btn-success">Edit</button>
                                    <button wire:click="deleteVehicule({{ $vehicule->id }})"
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
                {{ $vehicules->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="vehiculeModal" tabindex="-1" aria-labelledby="vehiculeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($editMode)
                            <h5 class="modal-title" id="vehiculeModalLabel">Edit Vehicule</h5>
                        @else
                            <h5 class="modal-title" id="vehiculeModalLabel">Create Vehicule</h5>

                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            
                        <div class="form-group row">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                                <div class="col-md-6">
                                    <input id="type" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="type">

                                    @error('type')
                                        <span class="invalid-feedback" vehicule="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="matricule"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Matricule') }}</label>

                                <div class="col-md-6">
                                    <input id="matricule" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="matricule">

                                    @error('matricule')
                                        <span class="invalid-feedback" vehicule="alert">
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
                            <button type="button" class="btn btn-primary" wire:click="updateVehicule">Update
                                vehicule</button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="storeVehicule">Store
                                vehicule</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
