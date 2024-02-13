@extends('layouts.auth')
@section('container')
	<h4 class="mb-2">
		{{ __('Verifikasi Email') }}
	</h4>
	<p class="mb-4">
		{{ __('Sebelum memulai, silahkan lakukan verifikasi email terlebih dahulu') }}
	</p>

	<form id="formAuthentication" class="mb-3" action="{{ route('verification.send') }}" method="POST">
		@csrf
		<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Kirim email verifikasi')" onClickDisabled />
	</form>

	<form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
		@csrf
	</form>

	<div class="text-center">
		<a href="{{ route('logout') }}" class="d-flex align-items-center justify-content-center" onclick="logout()">
			<i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
			{{ __('Logout') }}
		</a>
	</div>

	@push('js')
	<script>
		function logout() {
			event.preventDefault()
			swalConfirm('Apakah anda yakin?', "Anda akan keluar dari akun", 'Ya! Keluar', () => {
				document.getElementById('logout-form').submit();
			});
		}
	</script>
	@endpush
@endsection