
@extends('admin.layouts.auth')
@section('container')
	<h4 class="mb-2">{{ is_null($desa) ?  __('Sistem Manajemen Desa') : __('Sistem Manajemen Desa '.$desa->desa)}}</h4>
	<p class="mb-4">
		{{ __('Silahkan masuk dengan akun anda') }}
	</p>

	<form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
		@csrf
		<div class="mb-3">
			<x-label for="username" :value="__('username')" />
			<x-input type="text" name="username" id="username" :value="old('username')" :placeholder="__('Masukkan username')" autofocus />
			<x-invalid error="username" />
		</div>
		<div class="mb-3 form-password-toggle">
			<div class="d-flex justify-content-between">
				<x-label for="password" :value="__('Password')" />
				@if (Route::has('password.request'))
				<a href="{{ route('password.request') }}">
					<small>{{ __('Lupa Password?') }}</small>
				</a>
				@endif
			</div>
			<div class="input-group input-group-merge">
				<x-input type="password" name="password" id="password" :placeholder="__('Password')" aria-describedby="password" />
				<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
				<x-invalid error="password" />
			</div>
		</div>
		<div class="mb-3">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : ''}} />
				<label class="form-check-label" for="remember">
					{{ __('ingat saya') }}
				</label>
			</div>
		</div>
		<div class="mb-3">
			<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Masuk')" onClickDisabled />
		</div>
	</form>
@endsection

