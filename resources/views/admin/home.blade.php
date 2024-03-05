@extends('admin.layouts.app')
@section('container')

<!-- Card Border Shadow -->
<div class="row">
	<div class="col-sm-6 col-lg-3 mb-4">
	  <div class="card card-border-shadow-primary h-100">
		<div class="card-body">
		  <div class="d-flex align-items-center mb-2 pb-1">
			<div class="avatar me-2">
			  <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-truck"></i></span>
			</div>
			<h4 class="ms-1 mb-0">{{$data['user']}}</h4>
		  </div>
		  <p class="mb-1">Jumlah pengguna aktif</p>
		  <p class="mb-0">
			<span class="fw-medium me-1 text-success">+ {{$data['last_month_user']}} </span>
			<small class="text-muted">pengguna bulan ini</small>
		  </p>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-lg-3 mb-4">
	  <div class="card card-border-shadow-warning h-100">
		<div class="card-body">
		  <div class="d-flex align-items-center mb-2 pb-1">
			<div class="avatar me-2">
			  <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-error'></i></span>
			</div>
			<h4 class="ms-1 mb-0">{{$data['login']}}</h4>
		  </div>
		  <p class="mb-1">Pengguna Login Hari ini</p>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-lg-6 mb-4">
		<div class="card card-border-shadow-warning h-100">
			<div class="card-body row widget-separator">
				<div class="col-sm-5 border-shift border-end">
					<h1 class="text-primary text-center mb-0">{{array_sum($data['activities'])}}</h1>
					<h4 class=" text-center mb-0">Aktivitas Anda</h4>
					<p class=" text-center mb-0">bulan ini</p>
				  </div>
		  
				  <div class="col-sm-7 gy-1 text-nowrap d-flex flex-column justify-content-between ps-4 gap-2 pe-3">
					@foreach ($data['activities'] as $key => $item)
					<div class="d-flex align-items-center gap-2">
						<small class="text-wrap" style="width: 40%">{{$key==''? 'lainnya' :$key}}</small>
						<div class="progress w-100 bg-transparent" style="height:10px;">
						  <div class="progress-bar bg-primary" role="progressbar" style="width: {{$item*100/array_sum($data['activities']).'%'}}" aria-valuenow="{{$item*100/array_sum($data['activities'])}}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<small class="w-px-20 text-end">{{$item}}</small>
					  </div>
					@endforeach
		
				  </div>
			</div>
		  </div>
  </div>
  <!--/ Card Border Shadow -->

  <div class="row">
	<!-- Delivery Performance -->
	<div class="col-lg-6 col-xxl-4 mb-4 order-2 order-xxl-2">
	  <div class="card h-100">
		<div class="card-header d-flex align-items-center justify-content-between">
		  <div class="card-title mb-0">
			<h5 class="m-0 me-2">Delivery Performance</h5>
			<small class="text-muted">12% increase in this month</small>
		  </div>
		  <div class="dropdown">
			<button class="btn p-0" type="button" id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <i class="bx bx-dots-vertical-rounded"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
			  <a class="dropdown-item" href="javascript:void(0);">Select All</a>
			  <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
			  <a class="dropdown-item" href="javascript:void(0);">Share</a>
			</div>
		  </div>
		</div>
		<div class="card-body">
		  <ul class="p-0 m-0">
			<li class="d-flex mb-4 pb-1">
			  <div class="avatar flex-shrink-0 me-3">
				<span class="avatar-initial rounded bg-label-primary"><i class="bx bx-package"></i></span>
			  </div>
			  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				<div class="me-2">
				  <h6 class="mb-1 fw-normal">Packages in transit</h6>
				  <small class="text-success fw-normal d-block">
					<i class="bx bx-chevron-up"></i>
					25.8%
				  </small>
				</div>
				<div class="user-progress">
				  <h6 class="mb-0">10k</h6>
				</div>
			  </div>
			</li>
			<li class="d-flex mb-4 pb-1">
			  <div class="avatar flex-shrink-0 me-3">
				<span class="avatar-initial rounded bg-label-info"><i class="bx bxs-truck"></i></span>
			  </div>
			  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				<div class="me-2">
				  <h6 class="mb-1 fw-normal">Packages out for delivery</h6>
				  <small class="text-success fw-normal d-block">
					<i class="bx bx-chevron-up"></i>
					4.3%
				  </small>
				</div>
				<div class="user-progress">
				  <h6 class="mb-0">5k</h6>
				</div>
			  </div>
			</li>
			<li class="d-flex mb-4 pb-1">
			  <div class="avatar flex-shrink-0 me-3">
				<span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
			  </div>
			  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				<div class="me-2">
				  <h6 class="mb-1 fw-normal">Packages delivered</h6>
				  <small class="text-danger fw-normal d-block">
					<i class="bx bx-chevron-down"></i>
					12.5
				  </small>
				</div>
				<div class="user-progress">
				  <h6 class="mb-0">15k</h6>
				</div>
			  </div>
			</li>
			<li class="d-flex mb-4 pb-1">
			  <div class="avatar flex-shrink-0 me-3">
				<span class="avatar-initial rounded bg-label-warning"><i>%</i></span>
			  </div>
			  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				<div class="me-2">
				  <h6 class="mb-1 fw-normal">Delivery success rate</h6>
				  <small class="text-success fw-normal d-block">
					<i class="bx bx-chevron-up"></i>
					35.6%
				  </small>
				</div>
				<div class="user-progress">
				  <h6 class="mb-0">95%</h6>
				</div>
			  </div>
			</li>
			<li class="d-flex mb-4 pb-1">
			  <div class="avatar flex-shrink-0 me-3">
				<span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-time-five"></i></span>
			  </div>
			  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				<div class="me-2">
				  <h6 class="mb-1 fw-normal">Average delivery time</h6>
				  <small class="text-danger fw-normal d-block">
					<i class="bx bx-chevron-down"></i>
					2.15
				  </small>
				</div>
				<div class="user-progress">
				  <h6 class="mb-0">2.5 Days</h6>
				</div>
			  </div>
			</li>
			<li class="d-flex">
			  <div class="avatar flex-shrink-0 me-3">
				<span class="avatar-initial rounded bg-label-danger"><i class="bx bx-group"></i></span>
			  </div>
			  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				<div class="me-2">
				  <h6 class="mb-1 fw-normal">Customer satisfaction</h6>
				  <small class="text-success fw-normal d-block">
					<i class="bx bx-chevron-up"></i>
					5.7%
				  </small>
				</div>
				<div class="user-progress">
				  <h6 class="mb-0">4.5/5</h6>
				</div>
			  </div>
			</li>
		  </ul>
		</div>
	  </div>
	</div>
	<!-- Shipment statistics-->
	<div class="col-lg-6 col-xxl-6 mb-4 order-1 order-xxl-1">
	  <div class="card h-100">
		<div class="card-header d-flex align-items-center justify-content-between">
		  <div class="card-title mb-0">
			<h5 class="m-0 me-2">Statistik Pengguna Aktif</h5>
		  </div>
		 
		</div>
		<div class="card-body">
			<div class="row g-3">
				<div class="col mb-3">
					<select id="dusun" class="selectpicker w-100" data-style="btn-default" data-live-search="false" name="dusun_id" required>
						
					</select>
				</div>
				<div class="col mb-3">
					<select id="rw" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="RW" name="rw_id" required>
						
					</select>
				</div>
				<div class="col mb-3">
					<select id="rt" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="RT" name="rt_id" required>
						
					</select>
				</div>

				  

				 
				  
			</div>
		  <div id="shipmentStatisticsChart"></div>
		</div>
	  </div>
	</div>
	<!--/ Shipment statistics -->
</div>
	<!--/ Delivery Performance -->

	<!--/ Reasons for delivery exceptions -->


</div>

@push('js')
	<script>
		$( document ).ready(function() {
			
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-dusun')}}",
					success: function(msg){
						msg = "<option data-tokens='all' value='all'>All Dusun</option>" + msg;
						$('#dusun').selectpicker('destroy');
						$('#dusun').html(msg);
						$('#dusun').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
		    
		});
		$('#dusun').on('change',function(){
				$('#dusun').selectpicker('render');
				let id_dusun = $('#dusun').val();

				if(id_dusun != 'all'){
					$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rw')}}",
					
					data : {id:id_dusun},

					success: function(msg){
						msg = "<option data-tokens='all' value='all'>All RW</option>" + msg
						$('#rw').selectpicker('destroy');
						$('#rw').html(msg);
						$('#rw').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
				}
				else{
					$('#rw').selectpicker('destroy');
					$('#rw').html('');
					$('#rw').selectpicker('refresh');
					$('#rt').selectpicker('destroy');
					$('#rt').html('');
					$('#rt').selectpicker('refresh');
				}
				
			});
			$('#rw').on('change',function(){
				$('#rw').selectpicker('render');
				let id_rw = $('#rw').val();

				if(id_rw != 'all'){
					$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rt')}}",
					
					data : {id:id_rw},

					success: function(msg){
						msg = "<option data-tokens='all' value='all'>All RT</option>" + msg
						$('#rt').selectpicker('destroy');
						$('#rt').html(msg);
						$('#rt').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
				}
				else{
					$('#rt').selectpicker('destroy');
					$('#rt').html('');
					$('#rt').selectpicker('refresh');
					
				}
				
			});

	</script>
@endpush

@endsection