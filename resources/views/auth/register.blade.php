
@extends('layouts.auth')
@section('container')
	<h4 class="mb-2">{{ is_null($desa) ?  __('Sistem Manajemen Desa') : __('Sistem Manajemen Desa '.$desa->desa)}}</h4>
	<p class="mb-4">
		{{ __('Buat akun warga desa') }}
	</p>

	<form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
		@csrf
		<input type="hidden" id="token" value="{{ csrf_token() }}">
		
		  <div class="row g-2 mb-2">
			<div class="col">
			  <x-label for="nik" :value="__('NIK')" />
			  <x-input type="text" name="nik" id="nik" :placeholder="__('NIK 16 digit')" :value="old('nik')" />
			  <x-invalid error="nik" />
			  <p><small class="text-danger" id="error_check_nik"></small></p>
			</div>
			<div class="col">
			  <x-label for="no_kk" :value="__('No Kartu Keluarga')" />
			  <x-input type="text" name="no_kk" id="no_kk" :placeholder="__('No pada KK 16 digit')" :value="old('no_kk')" readonly />
			  <x-invalid error="no_kk" />
			  <p><small class="text-danger" id="error_check_kk"></small></p>
			</div>
		  </div>
		  <div class="row">
			<div class="col mb-3">
			  <x-label for="email" :value="__('Email')" />
			  <x-input type="email" name="email" id="email" :placeholder="__('Email valid untuk pemberitahuan')" :value="old('email')" />
			  <x-invalid error="email" />
			</div>
		  </div>
		
		  <div class="row g-2 mb-5">
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
		  </div>
		<div class="mb-3">
			<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat Akun')" onClickDisabled />
		</div>
	</form>

	<p class="text-center">
		<span>{{ __('Sudah punya akun?') }}</span>
		<a href="{{ route('login') }}">
			<span>{{ __('Masuk') }}</span>
		</a>
	</p>

	<script>
		$( document ).ready(function() {
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		});
		$(function(){
			$('#nik').on('keyup',function(){
				let nik = $('#nik').val();
				$.ajax({
						type : 'POST',
						url: "{{route('users.nik')}}",
						data : {'nik':nik},
						success: function(msg){
							if($.isEmptyObject(msg.error)){
								$('#error_check_nik').empty();
								$('#no_kk').prop('readonly', false);
							}
							else{
								
									$('#error_check_nik').text(msg.error);
									$('#no_kk').prop('readonly', true);
								
							}
							
						},
						error: function (xhr) {
							var err = JSON.parse(xhr.responseText);
							alert(err.message);
						}
						
					})
			});
			$('#no_kk').on('keyup',function(){
				let nik = $('#nik').val();
				let no_kk = $('#no_kk').val();
				$.ajax({
						type : 'POST',
						url: "{{route('users.kk')}}",
						data : {'nik':nik, 'no_kk':no_kk},
						success: function(msg){
							if($.isEmptyObject(msg.error)){
								$('#error_check_kk').empty();
							}
							else{
								$('#error_check_kk').text(msg.error);
							}
							
						},
						error: function (xhr) {
							var err = JSON.parse(xhr.responseText);
							alert(err.message);
						}
						
					})
			});
			
		})
	</script>
@if($errors->has('nik'))
	<script type="text/javascript">

	$('#no_kk').prop('readonly', false);

	</script>
@endif
@endsection

