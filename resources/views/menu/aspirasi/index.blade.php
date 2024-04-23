@extends('layouts.app')
@section('container')
<div class="row g-3 mb-3">
	<div class="col-sm-6 col-xl-4">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Total Aspirasi</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_sum($data)}}</h4>
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
	<div class="col-sm-6 col-xl-4">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Terbuka</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_key_exists("1", $data)?$data['1']:0}}</h4>
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
	<div class="col-sm-6 col-xl-4">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Telah Selesai</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_key_exists("0", $data)?$data['0']:0}}</h4>
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
	
  </div>
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Manajemen Aspirasi') }}
			</h5>

			@include('components.table')

		</div>
	</div>
	<form method="POST" class="d-none" id="status-form">
		@csrf
		@method("PUT")
	</form>
	<script>
		function change(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Ubah Status Aspirasi ?', `Status aspirasi akan diubah`, 'Ubah', () => {
			form.submit()
		})
	}
	</script>
@endsection