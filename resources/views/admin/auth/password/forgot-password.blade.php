@extends('admin.layouts.auth')
@section('container')
	<h4 class="mb-2">
		{{ __('Lupa password? 🔒') }}
	</h4>
	<p class="mb-4">
		{{ __("Masukkan email admin, link perubahan password akan dikirimkan melalui email") }}
	</p>

	<form id="formAuthentication" class="mb-3" action="{{ route('admin.password.email') }}" method="POST">
		@csrf
		<div class="mb-3">
			<x-label for="username" :value="__('Username')" />
			<x-input type="text" name="username" id="username" :placeholder="__('Masukkan username')" :value="old('username')" autofocus />
			<x-invalid error="username" />
		</div>
		<div class="mb-3">
			<x-label for="email" :value="__('Email')" />
			<x-input type="email" name="email" id="email" :placeholder="__('Masukkan email')" :value="old('email')" autofocus />
			<x-invalid error="email" />
		</div>
		<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Kirim Email')" onClickDisabled />
	</form>

	<div class="text-center">
		<a href="{{ route('admin.login') }}" class="d-flex align-items-center justify-content-center">
			<i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
			{{ __('Kembali Ke Panel Login Admin') }}
		</a>
	</div>
	@endsection