@extends('admin.layouts.app')
@section('container')

	<div class="card">
		<div class="card-body">
			

			<div class="mb-4">
				<!-- Button trigger modal -->
    <a href="{{route('users.index')}}" class="btn btn-dark"> Kembali </a>
	<!-- Icon Dropdown -->
<div class="btn-group">
	<button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Aksi
	  </button>
	<ul class="dropdown-menu">
		<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditUser">Edit</a></li>
	  <li><a class="dropdown-item" href="{{route("users.status",$user)}}" onclick='change(this)'>{{$user->is_active?"Nonaktifkan":"Aktifkan"}}</a></li>

	  
	</ul>
  </div>

  
  <div class="text-center mb-3">
	<h4 >Pengguna {{$user->username}}}</h4>
	@forelse ($user->roles as $item)
		<span class="badge bg-primary">{{$item->name}}</span>
	@empty
		<p>Pengguna belum memiliki role</p>
	@endforelse
</div>
<div class="card">
	<div class="card-header">
		<h5>Keterangan Pengguna</h5>
	</div>
  <div class="card-body">
	
		<div class="mb-2">
			<strong>Username : </strong>
			<p>{{$user->username}}</p>
		</div>
		<div class="mb-2">
			<strong>Email : </strong>
			<p>{{$user->email}}</p>
		</div>
		<div class="mb-2">
			<strong>Dibuat Sejak: </strong>
			<p>{{$user->created_at}}</p>
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
