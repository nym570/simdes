
@extends('layouts.app')
@section('container')
<div class="card">
	<div class="card-body">
		<h5 class="card-title">
			{{ __('Jenis Layanan Tersedia') }}
		</h5>
		<div class="row row-cols-2 row-cols-lg-4 g-4">
			
			<div class="col">
				<div class="card text-center h-100">
				  <div class="card-body">
					<i class='bx bx-home bx-lg'></i>
					<h5 class="card-title">Surat Keterangan Domisili</h5>
					<p class="card-text mb-0">syarat pengajuan: </p>
					<p class="card-text">(1) scan kk, (2) scan ktp, (3) foto</p>
					<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDomisili">
						Ajukan!
					  </button>
				  </div>
				</div>
			 </div>
			 <div class="col">
				<div class="card text-center  h-100">
				  <div class="card-body">
					<i class='bx bx-money bx-lg'></i>
					<h5 class="card-title">Surat Keterangan Umum</h5>
					<p class="card-text mb-0">syarat pengajuan:</p>
					<p class="card-text">(1) scan kk, (2) scan ktp, (3) foto</p>
					<button type="button" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#addUmum">
						Ajukan!
					  </button>
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
		@include('menu.pengajuan.suket.domisili')
		@include('menu.pengajuan.suket.umum')
	</div>
</div>

<div class="card mt-3">
	<div class="card-body">
		<div class="card mt-3 mb-5">
			<div class="card-body">
				<h6 class="card-title">
					{{ __('Status Pengajuan') }}
				</h6>
				<div>
					<div class='m-2'>
						<span class="badge bg-dark">diajukan</span>
						<small> : Pengajuan belum disetujui</small>
					</div>
					<div class="m-2">
						<span class="badge bg-primary">diproses</span>
						<small> : Pengajuan telah disetujui dan sedang diproses</small>
					</div>
					<div class="m-2">
						<span class="badge bg-success">dapat diambil</span>
						<small> : Pengajuan telah selesai diproses dan dapat diambil</small>
					</div>
					<div class="m-2">
						<span class="badge bg-secondary">selesai</span>
						<small> : Surat Keterangan telah diambil oleh pemohon</small>
					</div>
					<div class="m-2">
						<span class="badge bg-danger">ditolak</span>
						<small> : Pengajuan ditolak</small>
					</div>
				</div>
		
			</div>
		</div>
		<h5 class="card-title">
			{{ __('Pengajuan Surat Keterangan Saya') }}
		</h5>

		@include('components.table')

	</div>
</div>
@endsection

