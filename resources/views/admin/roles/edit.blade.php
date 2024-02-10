<x-app-layout title="Roles edit">
    <div class="card">
        <div class="card-body">

            <div class="mb-4">
                <a href="{{ route('roles.index') }}" class="btn btn-dark">
                    {{ __('Kembali') }}
                </a>
            </div>

            @include('management.roles._partials.form')

        </div>
    </div>
</x-app-layout>