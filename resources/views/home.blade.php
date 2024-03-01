@extends('layouts.app')
@section('container')
<div class="row mb-4 g-4">
	<div class="col-md-6">
	  <div class="card h-100">
		<div class="card-body row widget-separator">
		  <div class="col-sm-5 border-shift border-end">
			<h1 class="text-primary text-center mb-0">{{$data['warga']['warga']+$data['warga']['tinggal ditempat lain karena bekerja/bersekolah']}}</h1>
			<h3 class=" text-center">Warga Desa Hidup</h3>
		  </div>
  
		  <div class="col-sm-7 gy-1 text-nowrap d-flex flex-column justify-content-between ps-4 gap-2 pe-3">
			@foreach ($data['warga'] as $key => $item)
			<div class="d-flex align-items-center gap-2">
				<small class="text-wrap" style="width: 40%">{{$key=='warga'?'tinggal':'sementara ditempat lain'}}</small>
				<div class="progress w-100" style="height:10px;">
				  <div class="progress-bar bg-primary" role="progressbar" style="width: {{$item*100/array_sum($data['warga']).'%'}}" aria-valuenow="{{$item*100/array_sum($data['warga'])}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<small class="w-px-20 text-end">{{$item}}</small>
			  </div>
			@endforeach

		  </div>
	    </div>
	</div>
	
</div><div class="col-md-6">
	<div class="card h-100">
	  <div class="card-body row widget-separator">
		<div class="col-sm-5 border-shift border-end">
		  <h1 class="text-primary text-center mb-0">{{$data['ruta']}}</h1>
		  <h3 class=" text-center">Rumah Tangga</h3>
		</div>

		<div class="col-sm-7 gy-1 text-nowrap d-flex flex-column justify-content-between ps-4 gap-2 pe-3">
		 	<p class="text-muted text-wrap">Rumah Tangga adalah seseorang atau sekelompok orang yang mendiami suatu bangunan</p>
			<small class="text-muted text-wrap">- Badan Pusat Statistik -</small>
		</div>
	  </div>
  </div>
</div>
	
  
<div class="row g-4 mb-4">
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Lahir</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kelahiran']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-primary">
				<i class="bx bx-user bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Mati</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kematian']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-danger">
				<i class="bx bx-user-check bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Datang</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kedatangan']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-success">
				<i class="bx bx-group bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Pindah</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kepindahan']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-warning">
				<i class="bx bx-user-voice bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
@endsection
