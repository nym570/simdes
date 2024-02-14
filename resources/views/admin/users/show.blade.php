@extends('admin.layouts.app')
@section('container')

	<div class="card">
		<div class="card-body">
			

			<div class="mb-4">
				<!-- Button trigger modal -->
    <a href="{{route('users.index')}}" class="btn btn-dark"> Kembali </a>
	<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#EditUser"> Edit </button>
	<button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditRole"> Atur Role</button>
	<!-- Icon Dropdown -->
<div class="btn-group">
	<button type="button" class="btn btn-light btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
	  <i class="bx bx-dots-vertical-rounded"></i>
	</button>
	<ul class="dropdown-menu">
		@if(is_null($user->email_verified_at))
			<li><a class="dropdown-item" href="{{route('verification.send', $user)}}" onclick='verif(this)'>Kirim Verifikasi Email</a></li>
		@endif
	  <li><a class="dropdown-item" href="{{route("users.status",$user)}}" onclick='change(this)'>{{$user->status=="aktif"?"Nonaktifkan":"Aktifkan"}}</a></li>
	  <li><a class="dropdown-item" href="{{route('password.email')}}" onclick='send(this)'>Reset Password</a></li>
	  <li>
		<hr class="dropdown-divider">
	  </li>
	  <li><a class="dropdown-item" href="{{route('users.delete', $user)}}" onclick='del(this)'>Hapus Pengguna</a></li>
	</ul>
  </div>

  

  <h3 class="card-title mt-5"> {{ $user->nama }} </h3>

  <h5> Roles </h5>
  <div>
	@forelse ($user->roles as $item)
		<a href="{{route('roles.show',Hashids::encode($item->id))}}"><span class="badge bg-primary">{{$item->name}}</span></a>
	@empty
		<p>Pengguna belum memiliki role</p>
	@endforelse
  </div>

	<!-- Modal -->
	<div class="modal fade" id="EditRole" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Atur Role</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="formAuthentication" class="mb-3" action="{{ route('users.role',$user) }}" data-remote="true" method="POST">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="mb-3">
							<label for="selectpickerMultiple" class="form-label">Username</label>
							<select id="selectpickerMultiple" class="selectpicker w-100" data-style="btn-default" multiple data-icon-base="bx" data-live-search="true" data-tick-icon="bx-check text-primary" title="Pilih satu atau lebih pengguna baru" required name="roles[]">
								@forelse ($roles->keys() as $category)
									@if($category == 'aparat desa')
									<optgroup label="{{$category}}">
										@forelse($roles[$category] as $item)
											<option value="{{$item->name}}" {{$user->getRoleNames()->contains($item->name) ? 'selected' : ''}}>{{$item->name}}</option>
										@empty
										@endforelse
									  </optgroup>
									@endif
								@empty
								@endforelse
							</select>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Atur Role')"/>
				</div>
			</form>
		</div>
		</div>
	</div>

  
  <!-- Modal -->
  <div class="modal fade" id="EditUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Ubah data Pengguna</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('users.update',$user) }}" data-remote="true" method="POST">
            @method("PUT")
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<x-label for="nik" :value="__('NIK')" />
						<x-input type="text" name="nik" id="nik" :placeholder="__('NIK 16 digit')" value="{{old('nik')? old('nik') : $user->nik}}" readonly/>
						<x-invalid error="nik" />
					  </div>
				  </div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="username" :value="__('Username')" />
					<x-input type="text" name="username" id="username" :placeholder="__('Username disarankan menggunakan nik')" value="{{old('username')? old('username') : $user->username}}" />
					<x-invalid error="username" />
				  </div>
				</div>
				
				
				<div class="row">
				  <div class="col mb-3">
					<x-label for="email" :value="__('Email')" />
					<x-input type="email" name="email" id="email" :placeholder="__('Email valid untuk pemberitahuan')" value="{{old('email')? old('email') : $user->email}}" />
					<x-invalid error="email" />
				  </div>
				</div>
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Pengguna')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>
			</div>

			

		</div>
	</div>

    <form method="POST" class="d-none" id="delete-form">
		@csrf
		@method("DELETE")
	</form>
@if (count($errors) > 0)
    <script type="text/javascript">
        $( document ).ready(function() {
             $('#EditUser').modal('show');
        });
    </script>
@endif
<form method="POST" class="d-none" id="verif-email">
	@csrf
</form>

<form method="POST" class="d-none" id="status-form">
	@csrf
	@method("PUT")
</form>

<form method="POST" class="d-none" id="reset-pass">
	@csrf
	<input type="hidden" name="email" id="email"  value="{{$user->email}}" >
</form>

<script>
	function del(element) {
		event.preventDefault()
		let form = document.getElementById('delete-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Hapus Pengguna?', `Tidak disarankan menghapus pengguna, seluruh data terkait pengguna akan hilang`, 'Ya, hapus data', () => {
			form.submit()
		})
	}
	function verif(element) {
		event.preventDefault()
		let form = document.getElementById('verif-email');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Kirim email verifikasi ?', `Email verifikasi akan dikirim ke email pengguna`, 'Kirim email!', () => {
			form.submit()
		})
	}
	function change(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Ubah Status ?', `Status pengguna akan diubah`, 'Ubah', () => {
			form.submit()
		})
	}
	function send(element) {
		event.preventDefault()
		let form = document.getElementById('reset-pass');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Kirim Email Reset Password ?', `Email akan dikirimkan ke pengguna`, 'Kirim email!', () => {
			form.submit()
		})
	}
</script>

@endsection
