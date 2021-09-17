<x-app-layout>
<div class="container">
    <div class="row justify-content-center" style ="text-align:center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Welcome to the Users Management') }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
