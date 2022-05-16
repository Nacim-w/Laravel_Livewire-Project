<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chauffeurs</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('chauffeur-message'))
                    <div class="alert alert-success">
                        {{ session('chauffeur-message') }}
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
                                    <div class="spinner-border" chauffeur="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <button wire:click="showChauffeurModal" class="btn btn-primary">
                            New Chauffeur
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">#Id</th>
                            <th scope="col">Code</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">CIN</th>
                            <th scope="col">Address</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($chauffeurs as $chauffeur)
                            <tr>
                                <th scope="row">{{ $chauffeur->id }}</th>
                                <td>{{ $chauffeur->name }}</td>
                                <td>{{ $chauffeur->first_name }}</td>
                                <td>{{ $chauffeur->last_name }}</td>
                                <td>{{ $chauffeur->address }}</td>
                                <td>{{ $chauffeur->cin }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $chauffeur->id }})"
                                        class="btn btn-success">Edit</button>
                                    <button wire:click="deleteChauffeur({{ $chauffeur->id }})"
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
                {{ $chauffeurs->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="chauffeurModal" tabindex="-1" aria-labelledby="chauffeurModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($editMode)
                            <h5 class="modal-title" id="chauffeurModalLabel">Edit Chauffeur</h5>
                        @else
                            <h5 class="modal-title" id="chauffeurModalLabel">Create Chauffeur</h5>

                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                        <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="first_name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="first_name">

                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="last_name">

                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cin"
                                    class="col-md-4 col-form-label text-md-right">{{ __('CIN') }}</label>

                                <div class="col-md-6">
                                    <input id="cin" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="cin">

                                    @error('cin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
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
                            <button type="button" class="btn btn-primary" wire:click="updateChauffeur">Update
                                chauffeur</button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="storeChauffeur">Store
                                chauffeur</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
