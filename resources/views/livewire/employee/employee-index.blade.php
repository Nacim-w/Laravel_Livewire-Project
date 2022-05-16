<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('employee-message'))
                    <div class="alert alert-success">
                        {{ session('employee-message') }}
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
                        <button wire:click="showEmployeeModal" class="btn btn-primary">
                            New Employee
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">#Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Matricule</th>
                            <th scope="col">Tag ID</th>
                            <th scope="col">Route</th>
                            <th scope="col">Presence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr>
                                <th scope="row">{{ $employee->id }}</th>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->matricule }}</td>
                                <td>{{ $employee->tagid}}</td>
                                <td>{{ $employee->route->route }}</td>
                                <td>{{ $employee->Presence}}</td>


                                <td>
                                    <button wire:click="showEditModal({{ $employee->id }})"
                                        class="btn btn-success">Edit</button>
                                    <button wire:click="deleteEmployee({{ $employee->id }})"
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
                {{ $employees->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="name">

                                    @error('name')
                                        <span class="invalid-feedback" route="alert">
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
                                        <span class="invalid-feedback" route="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tagid"
                                    class="col-md-4 col-form-label text-md-right">{{ __('tagid') }}</label>

                                <div class="col-md-6">
                                    <input id="tagid" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="tagid">

                                    @error('tagid')
                                        <span class="invalid-feedback" route="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                           

                            

                          

                            <div class="form-group row">
                                <label for="route_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Route') }}</label>

                                <div class="col-md-6">
                                    <select wire:model.defer="route_id" class="custom-select">
                                        <option selected>Choose</option>

                                        @foreach (App\Models\Route::all() as $route)
                                            <option value="{{ $route->id }}">{{ $route->route }}</option>
                                        @endforeach
                                    </select>
                                    @error('route_id')
                                        <span class="invalid-feedback" route="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label for="Presence"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Presence') }}</label>

                                <div class="col-md-6">
                                    <input id="Presence" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="Presence">

                                    @error('Presence')
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
                            <button type="button" class="btn btn-primary" wire:click="updateEmployee">Update Employee</button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="storeEmployee">Store Employee</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
