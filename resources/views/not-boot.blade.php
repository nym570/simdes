
@extends('layouts.auth')
@section('container')
<div class="text-center">
	<h3>Sistem Informasi Manajemen Desa : </h3>
	<h4 class="text-danger">Konfigurasi Belum Dilakukan!</h4>
	<p>Silahkan login akun admin anda untuk melakukan konfigurasi</p>
	<a href="{{route('admin.login')}}" class="btn btn-primary d-grid gap-2 col-6 mx-auto">
		Login Admin
	  </a>
</div>
	
@endsection

