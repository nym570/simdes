@extends('admin.layouts.app')
@section('container')
    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <a href="{{ route('roles.index') }}" class="btn btn-dark">
                    {{ __('Kembali') }}
                </a>
						
				
                @if(!(in_array($role->name,['kepala desa','kepala dusun','ketua rw','ketua rt','warga'])))
                    <a href="{{ route('roles.index') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
                        {{ __('+ Tambah User') }}
                    </a>

                     <!-- Modal -->
                    <div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Tambah Pengguna : Role {{$role->name}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formAuthentication" class="mb-3" action="{{ route('roles.add-many') }}" data-remote="true" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <x-input type="text" name="role" id="role"  value="{{$role->name}}" class="d-none" />
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="selectpickerMultiple" class="form-label">Username</label>
                                            <select id="selectpickerMultiple" class="selectpicker w-100" data-style="btn-default" multiple data-icon-base="bx" data-live-search="true" data-tick-icon="bx-check text-primary" title="Pilih satu atau lebih pengguna baru" required name="users[]">
                                                @foreach($allUsers as $user)
                                                    <option data-tokens="{{$user->username.$user->warga->nama}}" value="{{$user->username}}">{{$user->username}} | {{$user->warga->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Assign role')"/>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    
                @endif
            </div>

        





            @include('admin.roles._partials.table')

        </div>
    </div>
@endsection