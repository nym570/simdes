
@extends('layouts.app')
@section('container')
@if(auth()->user()->hasRole('warga')&&!is_null(\App\Models\AnggotaRuta::where('anggota_nik',auth()->user()->nik)->where('hubungan','Kepala Keluarga')->first()))
<div class="card">
	<div class="card-body">
		<div class="row row-cols-2 row-cols-lg-4 g-4">
			
			<div class="col">
				<div class="card text-center h-100">
				  <div class="card-body">
					<i class='bx bxs-baby-carriage bx-lg'></i>
					<h5 class="card-title">Kelahiran</h5>
					<p class="card-text">Ajukan data kelahiran pada rumah tangga anda</p>
					<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addLahir">
						Ajukan!
					  </button>
				  </div>
				</div>
			 </div>
			 <div class="col">
				<div class="card text-center  h-100">
				  <div class="card-body">
					<i class='bx bxs-user-x bx-lg'></i>
					<h5 class="card-title">Kematian</h5>
					<p class="card-text">Ajukan data kematian anggota rumah tangga anda</p>
					<button type="button" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#addMati">
						Ajukan!
					  </button>
				  </div>
				</div>
			 </div>
			 <div class="col">
				<div class="card text-center  h-100">
				  <div class="card-body">
					<i class='bx bxs-truck bx-lg'></i>
					<h5 class="card-title">Kepindahan</h5>
					<p class="card-text">Ajukan kepindahan anda / anggota anda</p>
					<button type="button" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#addPindah">
						Ajukan!
					  </button>
				  </div>
				</div>
			 </div>
			 <div class="col">
				<div class="card text-center  h-100">
				  <div class="card-body">
					<i class='bx bxs-user-detail bx-lg'></i>
					<h5 class="card-title">Rumah Tangga</h5>
					<p class="card-text">Atur anggota rumah tangga anda</p>
					<a href="{{route('pengajuan.warga.ruta.index',$ruta)}}" class="btn btn-sm btn-primary">Ubah!</a>
				  </div>
				</div>
			 </div>
		</div>
		<script>
			$( document ).ready(function() {
					$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
			});
		</script>
		@include('menu.pengajuan.kependudukan.kelahiran')
		@include('menu.pengajuan.kependudukan.kematian')
		@include('menu.pengajuan.kependudukan.kepindahan')
	</div>
</div>

@endif
@endsection

