@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Pengguna') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
	Tambah Pengguna
  </button>
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importExcel">
	Import Excel
  </button>

  <!-- Modal -->
  <div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Tambah Pengguna Baru</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('users.store') }}" data-remote="true" method="POST">
			@csrf
			<input type="hidden" id="token" value="{{ csrf_token() }}">
			<div class="modal-body">
				<div class="row">
				  <div class="col mb-3">
					<x-label for="username" :value="__('Username*')" />
					<x-input type="text" name="username" id="username" :placeholder="__('Username disarankan menggunakan nik')" :value="old('username')" />
					<x-invalid error="username" />
				  </div>
				</div>
				
				<div class="row">
					<div class="col mb-3">
						<label for="nik" class="form-label">Warga</label>
						<select id="nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Warga" name="nik" required>
							
						</select>
						<x-invalid error="nik" />
					</div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="email" :value="__('Email*')" />
					<x-input type="email" name="email" id="email" :placeholder="__('Email valid untuk pemberitahuan')" :value="old('email')" />
					<x-invalid error="email" />
				  </div>
				</div>

				<div class="row g-2 mb-3">
				  <div class="col form-password-toggle">
					<label for="password" class="form-label">Password*</label>
					<div class="input-group input-group-merge">
					  <x-input type="password" name="password" id="password" :placeholder="__('Password')" aria-describedby="password" required/>
					  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
					  <x-invalid error="password" />
					 </div>
				  </div>
				  <div class="col form-password-toggle">
					  <label for="password_confirmation" class="form-label">Konfirmasi Password*</label>
					  <div class="input-group input-group-merge">
						  <x-input type="password" name="password_confirmation" id="password_confirmation" :placeholder="__('Ketik ulang password')" aria-describedby="password" required />
						  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
						  <x-invalid error="password_confirmation" />
					  </div>
				  </div>
				  <p><small>password terdiri dari minimal 8 karakter kombinasi huruf dan angka</small></p>
				</div>
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat Akun')"/>
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
		<form id="UpdateUser" class="mb-3"  data-remote="true" method="POST">
            @method("PUT")
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<x-label for="nik" :value="__('NIK')" />
						<x-input type="text" name="nik" id="nik_edit" :placeholder="__('NIK 16 digit')"  readonly/>
						<x-invalid error="nik" />
					  </div>
				  </div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="username" :value="__('Username')" />
					<x-input type="text" name="username" id="username_edit" :placeholder="__('Username disarankan menggunakan nik')"  />
					<x-invalid error="username" />
				  </div>
				</div>
				
				
				<div class="row">
				  <div class="col mb-3">
					<x-label for="email" :value="__('Email')" />
					<x-input type="email" name="email" id="email_edit" :placeholder="__('Email valid untuk pemberitahuan')"  />
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

  @include('admin.components.import')
			</div>

			@include('admin.components.table')


			<form method="POST" class="d-none"  id="reset-form">
				@csrf
				<input name="email" id="email_reset" >
				<input name="username" id="username_reset" >
			</form>
		</div>
	</div>

	<form method="POST" class="d-none" id="status-form">
		@csrf
		@method("PUT")
	</form>

<script>
	$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
					type : 'GET',
					url: "{{route('get-warga')}}",
					data: {tujuan:"user"},
					success: function(msg){
						$('#nik').selectpicker('destroy');
						$('#nik').html(msg);
						$('#nik').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
	});
	function send(element) {
		event.preventDefault()
		let form = document.getElementById('reset-form');
		$('#email_reset').val(element.getAttribute('data-email'));
		$('#username_reset').val(element.getAttribute('data-username'));
		form.setAttribute('action', element.getAttribute('href'));
		swalConfirm('Kirim Email Reset Password ?', `Pengguna akan menerima email reset password`, 'Ya! Kirim', () => {
			form.submit()
		})
	}
	function change(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Ubah Status ?', `Status user akan diubah`, 'Ubah', () => {
			form.submit()
		})
	}
	$(document).on('click','.open_modal_edit',function(){
		let linkData= $(this).attr('data-user');
		let link= $(this).attr('data-link');
		$.ajax({
					type : 'GET',
					url: linkData,
					success: function(msg){
						let data = JSON.parse(msg);
						$('#nik_edit').val(data.nama);
						$('#username_edit').val(data.username);
						$('#email_edit').val(data.email);
						$('#UpdateUser').attr('action',link);
						$('#EditUser').modal('show');	
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});

	}); 
</script>
@if (count($errors) > 0 && !$errors->has('import'))
    <script type="text/javascript">
	
        $( document ).ready(function() {
			
             $('#addUser').modal('show');
        });

    </script>
@endif
@if ($errors->has('import'))
    <script type="text/javascript">
	
        $( document ).ready(function() {
			
             $('#importExcel').modal('show');
        });

    </script>
	
@endif


@endsection

