
@extends('layouts.auth')
@push('js')
			
			{!! $rtDT->scripts() !!}
			{!! $rwDT->scripts() !!}
			
			{!! $dusunDT->scripts() !!}
@endpush
@section('container')

			<h3 class="card-title mb-4 text-center">
				{{ __('Konfigurasi Awal') }}
			</h3>
			   <!-- App Wizard -->
			   <div id="wizard-create-app" class="bs-stepper wizard-numbered mt-2 shadow-none border-0">
				<div class="bs-stepper-header p-1">
				  <div class="step p-2" data-target="#details">
					<button type="button" class="step-trigger">
					  <span class="bs-stepper-circle">1</span>
					  <span class="bs-stepper-label">
						<span class="bs-stepper-title text-uppercase">Wilayah Desa</span>
						<span class="bs-stepper-subtitle">Dusun, RW, RT</span>
					  </span>
					</button>
				  </div>
				  <div class="line">
					<i class="bx bx-chevron-right"></i>
				  </div>
				  
				  <div class="step p-2" data-target="#frameworks">
					<button type="button" class="step-trigger">
					  <span class="bs-stepper-circle">2</i></span>
					  <span class="bs-stepper-label">
						<span class="bs-stepper-title text-uppercase">Data Desa</span>
						<span class="bs-stepper-subtitle">Konfigurasi Desa</span>
					  </span>
					</button>
				  </div>
				 
				</div>
				<div class="bs-stepper-content mt-2">
					
					<!-- Details -->
					<div id="details" class="content pt-3 pt-lg-0">
					
						
			<div class="nav-align-top">
				<ul class="nav nav-pills mb-3" role="tablist">
				  <li class="nav-item">
					<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-dusun" aria-controls="navs-pills-top-dusun" aria-selected="true">Dusun</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-rw" aria-controls="navs-pills-top-rw" aria-selected="false">RW</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-rt" aria-controls="navs-pills-top-rt" aria-selected="false">RT</button>
				  </li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show " id="navs-pills-top-dusun" role="tabpanel">
						<div class="mb-4">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#tambahDusun">
								+ Buat Dusun
							</button>
							
							
							
						</div>
						<h5 class="mb-4">Daftar Dusun</h5>
						{!! $dusunDT->table() !!}
						
				  </div>
				  <div class="tab-pane fade " id="navs-pills-top-rw" role="tabpanel">
					<div class="mb-4">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#tambahRW" id="buttonRW">
							+ Buat RW
						</button>
						
					</div>
					<h5 class="mb-4">Daftar RW</h5>
					
						{!! $rwDT->table() !!}
						
						
					
				  </div>
				  <div class="tab-pane fade" id="navs-pills-top-rt" role="tabpanel">
					<div class="mb-4">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#tambahRT" id="buttonRT">
							+ Buat RT
						</button>
						
					</div>
					<h5 class="mb-4">Daftar RT</h5>
					
						{!! $rtDT->table() !!}
					
				  </div>
				  
				</div>
			  </div>

			  <!-- Modal -->
<div class="modal fade" id="tambahRT" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel1">Buat RT</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
		<form id="formAuthentication" class="mb-3" action="{{ route('m.lkd.rt.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" id="token" value="{{ csrf_token() }}">
			
			<div class="modal-body">
				
				<div class="row">
					<div class="col mb-3">
						<label for="dusunMRT" class="form-label">Dusun*</label>
						<select id="dusunMRT" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih dusun" name="dusun_id" required>
							
						</select>
						<x-invalid error="dusun_id" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="rwMRT" class="form-label">RW*</label>
						<select id="rwMRT" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih RW" name="rw_id" required>
							
						</select>
						<x-invalid error="rw_id" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
					  <x-label for="name" :value="__('Nomor RT*')" />
					  <x-input type="number" name="name" id="name"  :value="old('name')" min=1 :placeholder="__('Nomor RT')" required/>
					  <x-invalid error="name" />
					</div>
				  </div>
				  
				  
				
				
			</div>
			<div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat RT')"/>
			</div>
		</form>
	</div>
	</div>
</div>

	<!-- Modal -->
	<div class="modal fade" id="tambahRW" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Buat RW</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<form id="formAuthentication" class="mb-3" action="{{ route('m.lkd.rw.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				
				<div class="modal-body">
					
					<div class="row">
						<div class="col mb-3">
							<label for="dusunMRW" class="form-label">Dusun*</label>
							<select id="dusunMRW" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih dusun" name="dusun_id" required>
								
							</select>
							<x-invalid error="dusun_id" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
						  <x-label for="name" :value="__('Nomor RW*')" />
						  <x-input type="number" name="name" id="name"  :value="old('name')" min=1 :placeholder="__('Nomor RW')" required/>
						  <x-invalid error="name" />
						</div>
					  </div>
					  
					  
					
					
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat RW')"/>
				</div>
			</form>
		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="tambahDusun" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Buat Dusun</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<form id="formAuthentication" class="mb-3" action="{{ route('m.lkd.dusun.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				
				<div class="modal-body">

				
					<div class="row">
						<div class="col mb-3">
						  <x-label for="name" :value="__('Nama Dusun*')" />
						  <x-input type="text" name="name" id="name"  :value="old('name')" :placeholder="__('Masukkan nama dusun (contoh: Suko)')" required/>
						  <x-invalid error="name" />
						</div>
					  </div>
					  
					  
					
					
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat Dusun')"/>
				</div>
			</form>
		</div>
		</div>
	</div>

					
					
						

						
					  <div class="col-12 d-flex justify-content-between mt-4">
						
						
						<button class="btn btn-primary btn-next"  type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
					
					<!-- Frameworks -->
					<div id="frameworks" class="content pt-3 pt-lg-0">
						@csrf
						<form id="desaForm" class="mb-3" action="{{ route('m.desa.update',$desa) }}" data-remote="true" method="POST" enctype="multipart/form-data">
							@method('PUT')
							@csrf
							<input type="hidden" id="token" value="{{ csrf_token() }}">
				
								
								  <div class="row">
									<div class="accordion col mb-3" id="accordionExample">
										<div class="card accordion-item">
											<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
												<div class="row">
													<div class="mb-3">
													  <x-label for="kode_wilayah" :value="__('Kode Wilayah*')" />
													  <x-input type="text" name="kode_wilayah" id="kode_wilayah" :value="old('kode_wilayah')" readonly/>
													  <x-invalid error="kode_wilayah" />
													</div>
													
												  </div>
												
											</button>
				
									  
										  <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<div class="row">
													<div class="col mb-3">
														<label for="provinsi" class="form-label">Provinsi</label>
														<select id="provinsi" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="kode_provinsi">
															
														</select>
														<input class="d-none" type="text" name="provinsi" id="nama_prov"/>
													</div>
												</div>
												<div class="row">
													<div class="col mb-3">
														<label for="kabupaten" class="form-label">Kabupaten</label>
														<select id="kabupaten" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kabupaten"  name="kode_kabupaten">
															
														</select>
														<input class="d-none" type="text" name="kabupaten" id="nama_kab"/>
													</div>
												</div>
				
												<div class="row">
													<div class="col mb-3">
														<label for="kecamatan" class="form-label">Kecamatan</label>
														<select id="kecamatan" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kecamatan" name="kode_kecamatan">
															
														</select>
														<input class="d-none" type="text" name="kecamatan" id="nama_kec"/>
													</div>
												</div>
												
				
												<div class="row g-2 mb-3">
													<div class="col">
														<label for="sebutan" class="form-label">Sebutan</label>
														<select id="sebutan" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Penyebutan" name="sebutan">
															<option value="Desa">Desa</option>
															<option value="Kelurahan">Kelurahan</option>
															<option value="Nagari">Nagari</option>
														</select>
													</div>
													<div class="col">
														<label for="desa" class="form-label">Desa</label>
														<select id="desa" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih desa/kelurahan" name="kode_desa">
															
														</select>
														<input class="d-none" type="text" name="desa" id="nama_des"/>
													</div>
												</div>
											</div>
										  </div>
										</div>
								</div>
				
								
				
								<div class="row">
									<div class="col mb-3">
									  <x-label for="alamat_kantor" :value="__('Alamat Kantor*')" />
									  <x-input type="text" name="alamat_kantor" id="alamat_kantor"  :value="old('alamat_kantor')"/>
									  <x-invalid error="alamat_kantor" />
									</div>
								  </div>
								  <div class="row">
									<div class="col mb-3">
									  <x-label for="email_desa" :value="__('Email Kantor Desa*')" />
									  <x-input type="email" name="email_desa" id="email_desa" :value="old('email_desa')" />
									  <x-invalid error="email_desa" />
									</div>
								  </div>
								  <div class="row">
									<div class="col mb-3">
										  <x-label for="no_telp" :value="__('No HP*')" />
										  <x-input type="text" name="no_telp" id="no_telp" :placeholder="__('628xxxxxxxxx')" :value="old('no_telp')" />
										  <x-invalid error="no_telp" />
									</div>
								  </div>
								  <div class="row">
									<div class="col mb-3">
										<x-label for="formFile" :value="__('Logo (.png)')"/>
										<x-input class="form-control" type="file" id="formFile" name="logo"/>
										<x-invalid error="logo" />
									  </div>
								  </div>
								  <div class="row">
									<div class="col mb-3">
										<x-label for="formFile" :value="__('Icon (.ico)')"/>
										<x-input class="form-control" type="file" id="formFile" name="icon"/>
										<x-invalid error="icon" />
									  </div>
								  </div>
								  
								</form>
					  <div class="col-12 d-flex justify-content-between mt-4">
						<button class="btn btn-label-secondary btn-prev" type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i>
						  <span class="align-middle d-sm-inline-block d-none">Previous</span>
						</button>
						<button class="btn btn-primary btn-next" id="desaBTN" type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
				
				</div>
			  </div>
			</div>
			
			<!--/ App Wizard -->

			<form method="POST" class="d-none" id="delete-dusun">
				@csrf
				@method("DELETE")
			</form>
			<form method="POST" class="d-none" id="delete-rw">
				@csrf
				@method("DELETE")
			</form>
			<form method="POST" class="d-none" id="delete-rt">
				@csrf
				@method("DELETE")
			</form>
				

			
		
			
	
	<script>
		function delDusun(element) {
		event.preventDefault()
		let form = document.getElementById('delete-dusun');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin hapus dusun ?', `Dusun yang dihapus tidak dapat dipulihkan`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
	function delRW(element) {
		event.preventDefault()
		let form = document.getElementById('delete-rw');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin hapus RW ?', `RW yang dihapus tidak dapat dipulihkan`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
	function delRT(element) {
		event.preventDefault()
		let form = document.getElementById('delete-rt');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin hapus RT ?', `RT yang dihapus tidak dapat dipulihkan`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
		$( document ).ready(function() {
			
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
								type : 'GET',
								url: "{{route('wilayah.get-prov')}}",
								success: function(msg){
									
									$('#provinsi').html(msg);
									$('#provinsi').selectpicker('refresh');
									
									
								},
							})

		const wizardCreateApp = document.querySelector('#wizard-create-app');
    if (typeof wizardCreateApp !== undefined && wizardCreateApp !== null) {
      // Wizard next prev button
      const wizardCreateAppNextList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-next'));
      const wizardCreateAppPrevList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-prev'));
      const wizardCreateAppBtnSubmit = wizardCreateApp.querySelector('.btn-submit');

      const createAppStepper = new Stepper(wizardCreateApp, {
        linear: true
      });

      if (wizardCreateAppNextList) {
        wizardCreateAppNextList.forEach(wizardCreateAppNext => {
          wizardCreateAppNext.addEventListener('click', event => {
            createAppStepper.next();
           
          });
        });
      }
      if (wizardCreateAppPrevList) {
        wizardCreateAppPrevList.forEach(wizardCreateAppPrev => {
          wizardCreateAppPrev.addEventListener('click', event => {
            createAppStepper.previous();
           
          });
        });
      }

      
    }
	});
	
		
		


	
	</script>
	

<script>

$(function(){
		$('#buttonRW').on('click',function(){
			
			$.ajax({
				type : 'GET',
				url: "{{route('master-desa.get-dusun')}}",
				success: function(msg){
					$('#dusunMRW').selectpicker('destroy');
					$('#dusunMRW').html(msg);
					$('#dusunMRW').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#buttonRT').on('click',function(){
			
			$.ajax({
				type : 'GET',
				url: "{{route('master-desa.get-dusun')}}",
				success: function(msg){
					$('#dusunMRT').selectpicker('destroy');
					$('#dusunMRT').html(msg);
					$('#dusunMRT').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#dusunMRT').on('change',function(){
			$('#dusunMRT').selectpicker('render');
			let id_dusun = $('#dusunMRT').val();

			$.ajax({
				type : 'GET',
				url: "{{route('master-desa.get-rw')}}",
				
				data : {id:id_dusun},

				success: function(msg){
					$('#rwMRT').selectpicker('destroy');
					$('#rwMRT').html(msg);
					$('#rwMRT').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		
	})
$("#desaBTN").click(function(){
	$('#desaForm').submit();
}); 

document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
			
			el.addEventListener('shown.bs.tab', () => {
				DataTable.tables({ visible: true, api: true }).columns.adjust();
				DataTable.tables({ visible: true, api: true }).columns.adjust();
				
			});
			
		});

</script>
<script>
	$(function(){
		$('#provinsi').on('change',function(){
			$('#provinsi').selectpicker('render');
			let id_prov = $('#provinsi').val();
			let el = $("#provinsi option:selected").text();
			$('#nama_prov').val(el);
			
			$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-kab')}}",
				data : {'id_prov':id_prov},
				success: function(msg){
					$('#kabupaten').selectpicker('destroy');
					$('#kabupaten').html(msg);
					$('#kabupaten').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#kabupaten').on('change',function(){
			$('#kabupaten').selectpicker('render');
			let id_kab = $('#kabupaten').val();
			let el = $("#kabupaten option:selected").text();
			$('#nama_kab').val(el);

			$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-kec')}}",
				
				data : {id_kab:id_kab},

				success: function(msg){
					$('#kecamatan').selectpicker('destroy');
					$('#kecamatan').html(msg);
					$('#kecamatan').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#kecamatan').on('change',function(){
			$('#kecamatan').selectpicker('render');
			let id_kec = $('#kecamatan').val();
			let el = $("#kecamatan option:selected").text();
			$('#nama_kec').val(el);
			$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-des')}}",
				
				data : {id_kec:id_kec},

				success: function(msg){
					$('#desa').selectpicker('destroy');
					$('#desa').html(msg);
					$('#desa').selectpicker('render');
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#desa').on('change',function(){
			$('#desa').selectpicker('render');
			let id_desa = $('#desa').val();
			let el = $("#desa option:selected").text();
			$('#nama_des').val(el);
			$('#kode_wilayah').val(id_desa);
		});
	})
</script>




@endsection	
