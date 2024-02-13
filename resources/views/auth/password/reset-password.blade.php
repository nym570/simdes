@extends('layouts.auth')
@section('container')
	<h4 class="mb-2">
		{{ __('Reset Password') }}
	</h4>
	<p class="mb-4">
		{{ __('masukkan email dan password baru') }}
	</p>

	<form id="formAuthentication" class="mb-3" action="{{ route('password.update') }}" method="POST">
		@csrf

		<x-input type="hidden" name="token" id="token" :placeholder="__('Token')" :value="$request->route('token')" />

		<div class="mb-3">
			<x-label for="email" :value="__('Email')" />
			<x-input type="email" name="email" id="email" :placeholder="__('Enter your email')" :value="old('email', $request->email)" readonly />
			<x-invalid error="email" />
		</div>

		<div class="mb-3 form-password-toggle">
			<div class="d-flex justify-content-between">
				<x-label for="password" :value="__('Password')" />
			</div>
			<div class="input-group input-group-merge">
				<x-input type="password" name="password" id="password" :placeholder="__('Password')" aria-describedby="password" autofocus/>
				<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
				<x-invalid error="password" />
			</div>
		</div>

		<div class="mb-3 form-password-toggle">
			<div class="d-flex justify-content-between">
				<x-label for="password_confirmation" :value="__('Konfirmasi Password')" />
			</div>
			<div class="input-group input-group-merge">
				<x-input type="password" name="password_confirmation" id="password_confirmation" :placeholder="__('Ketik ulang password')" aria-describedby="password" />
				<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
				<x-invalid error="password_confirmation" />
			</div>
		</div>

		<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Reset password')" onClickDisabled />
	</form>


@endsection