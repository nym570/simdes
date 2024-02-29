
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Kedatangan') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addDatang">
	Tambah Data Kedatangan
  </button>

  

			</div>

			@include('menu.dinamika._partials.table')
	<!-- Create App Modal -->
	<div class="modal fade" id="addDatang" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg ">
		  <div class="modal-content p-2 p-md-4">
			<div class="modal-header">
				<h5 class="modal-title" id="judulModal">Tambah Data Kedatangan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			<div class="modal-body p-2">
			  
			  <!-- App Wizard -->
			  <div id="wizard-create-app" class="bs-stepper wizard-numbered mt-2 shadow-none border-0">
				<div class="bs-stepper-header p-1">
				  <div class="step p-2" data-target="#details">
					<button type="button" class="step-trigger">
					  <span class="bs-stepper-circle">1</span>
					  <span class="bs-stepper-label">
						<span class="bs-stepper-title text-uppercase">Kedatangan</span>
						<span class="bs-stepper-subtitle">Detail Kedatangan</span>
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
						<span class="bs-stepper-title text-uppercase">Identitas</span>
						<span class="bs-stepper-subtitle">Identitas Warga</span>
					  </span>
					</button>
				  </div>
				  <div class="line">
					<i class="bx bx-chevron-right"></i>
				  </div>
				  <div class="step p-2" data-target="#submit">
					<button type="button" class="step-trigger">
					  <span class="bs-stepper-circle">3</i></span>
					  <span class="bs-stepper-label">
						<span class="bs-stepper-title text-uppercase">Submit</span>
						<span class="bs-stepper-subtitle">Submit</span>
					  </span>
					</button>
				  </div>
				</div>
				<div class="bs-stepper-content mt-2">
					
					<!-- Details -->
					<div id="details" class="content pt-3 pt-lg-0">
	
						<div class="row">
							<div class="col mb-3">
								<x-label for="waktu" :value="__('Waktu Kedatangan*')" />
							  <x-input type="date" name="waktu" id="waktu"  :value="old('waktu')" required/>
							  <x-invalid error="waktu" />
							</div>
						</div>
						<x-label :value="__('Identitas Pendatang*')" />
						<div class="card">
							
							<div class="card-body accordion" id="accordionPendatang">
								<div class="card accordion-item mb-3 border border-2 clone-row">
									
									<h2 class="accordion-header" id="headingOptions">
										<div class="d-flex d-inline">
												<button class="btn btn-label-secondary btn-danger btn-sm btn-del-select m-2" type="button">
													<span class="align-middle d-sm-inline-block d-none">Hapus</span>
												  </button>

											<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOptions" aria-expanded="false" aria-controls="collapseOptions"> Tambah  </button>
											
										  </div>
										
									  
									  
									</h2>
									
									<div id="collapseOptions" class="accordion-collapse collapse" aria-labelledby="headingOptions" data-bs-parent="#accordionPendatang">
										<form id="formAuthentication" class="mb-3" action="{{ route('warga.store') }}" data-remote="true" method="POST">
											@csrf
										<div class="accordion-body" data-value="1">
										
											<div class="row ">
												<div class="col mb-3">
												  <x-label for="nik" :value="__('NIK*')" />
												  <x-input type="text" name="nik[]" id="nik" :placeholder="__('NIK 16 digit')" :value="old('nik')" required/>
												  <x-invalid error="nik" />
												</div>
												
												
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <x-label for="no_kk" :value="__('No Kartu Keluarga*')" />
													  <x-input type="text" name="no_kk[]" id="no_kk" :placeholder="__('No pada KK 16 digit')" :value="old('no_kk')" required/>
													  <x-invalid error="no_kk" />
													</div>
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <x-label for="nama" :value="__('Nama*')" />
													  <x-input type="text" name="nama[]" id="nama" :placeholder="__('Nama Lengkap Sesuai KTP')" :value="old('nama')" required/>
													  <x-invalid error="nama" />
													</div>
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <x-label for="no_telp" :value="__('No HP*')" />
													  <x-input type="text" name="no_telp[]" id="no_telp" :placeholder="__('62xxxxxx')" :value="old('no_telp')" required/>
													  <x-invalid error="no_telp" />
													</div>
											  </div>
											  <div class="row mb-3">
												  <div class="accordion col mb-2" id="accordionExample">
													  <div class="card accordion-item">
														  <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
															  <div class="row">
																  <div class="">
																	<x-label for="kode_wilayah" :value="__('Alamat KTP*')" />
																	<x-input type="text" name="kode_wilayah_ktp[]" :placeholder="__('Kode Wilayah')" id="kode_wilayah" :value="old('kode_wilayah_ktp')" readonly/>
																	<x-invalid error="kode_wilayah" />
																  </div>
																  
																</div>
															  
														  </button>
							  
													
														<div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
														  <div class="accordion-body">
															  <div class="row">
																  <div class="col mb-2">
																	  <label for="provinsi" class="form-label">Provinsi</label>
																	  <select  class="selectpicker w-100 provinsi" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="kode_provinsi" onch>
																		  
																	  </select>
																  </div>
															  </div>
															  <div class="row">
																  <div class="col mb-2">
																	  <label for="kabupaten" class="form-label">Kabupaten</label>
																	  <select id="kabupaten" class="selectpicker w-100 kabupaten" data-style="btn-default" data-live-search="true" title="Pilih kabupaten"  name="kode_kabupaten">
																		  
																	  </select>
																  </div>
															  </div>
							  
															  <div class="row">
																  <div class="col mb-2">
																	  <label for="kecamatan" class="form-label">Kecamatan</label>
																	  <select id="kecamatan" class="selectpicker w-100 kecamatan" data-style="btn-default" data-live-search="true" title="Pilih kecamatan" name="kode_kecamatan">
																		  
																	  </select>
																  </div>
															  </div>
							  
															  <div class="row">
																  <div class="col mb-2">
																	  <label for="desa" class="form-label">Desa</label>
																	  <select id="desa" class="selectpicker w-100 desa" data-style="btn-default" data-live-search="true" title="Pilih desa/kelurahan" name="kode_desa">
																		  
																	  </select>
																  </div>
															  </div>
															  <div class="row">
																  <div class="col mb-3">
																	  <x-label for="alamat_ktp" :value="__('Alamat*')" />
																	  <x-input type="text" name="alamat_ktp[]" id="alamat_ktp" :placeholder="__('Alamat Lengkap Sesuai KTP')" :value="old('alamat_ktp')" />
																	  <x-invalid error="alamat_ktp" />
																	</div>
															  </div>
															  
														  </div>
														</div>
													  </div>
							  
													  <div class="divider divider-dashed mb-2">
														  <div class="divider-text">Biodata Warga</div>
														</div>
											  <div class="row g-2 mb-3">
												  <label for="provinsi" class="form-label">Tempat Lahir</label>
												  <div class="col">
													  
													  <select id="provinsi-lahir" class="selectpicker w-100 provinsi-lahir" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="provinsi-lahir" required>
														  
													  </select>
												  </div>
												  <div class="col">
													  <select id="kabupaten-lahir" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kabupaten" name="kabupaten-lahir" required>
														  
													  </select>
													  <input class="d-none" type="text" name="tempat_lahir" id="tempat_lahir" required/>
												  </div>
												</div>
							  
												
											  <div class="row">
												  <div class="col mb-3">
													  <label for="tanggal_lahir" class="form-label">Tanggal Lahir*</label>
													  <x-input type="date" name="tanggal_lahir" id="tanggal_lahir" :value="old('tanggal_lahir')" required/>
													  <x-invalid error="tanggal_lahir" />
													</div>
											  </div>
							  
											  <div class="row">
												  <div class="col mb-3">
													  <label for="jenis_kelamin" class="form-label">Jenis Kelamin*</label>
													  <select id="jenis_kelamin" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih jenis kelamin"  name="jenis_kelamin" required>
														  <option value="laki-laki">Laki-Laki</option>
														  <option value="perempuan">Perempuan</option>
													  </select>
												  </div>
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <label for="agama" class="form-label">Agama*</label>
													  <select id="agama" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih agama"  name="agama" required>
														  <option value="Islam">Islam</option>
														  <option value="Kristen">Kristen (Protestan)</option>
														  <option value="Katolik">Katolik</option>
														  <option value="Hindu">Hindu</option>
														  <option value="Budha">Budha</option>
														  <option value="Konghucu">Konghucu</option>
													  </select>
												  </div>
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <label for="gol_darah" class="form-label">Golongan Darah*</label>
													  <select id="gol_darah" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Golongan Darah"  name="gol_darah" required>
														  <option value="A">A</option>
														  <option value="B">B</option>
														  <option value="AB">AB</option>
														  <option value="O">O</option>
														  <option value="Tidak Mengetahui">Tidak Mengetahui</option>
													  </select>
												  </div>
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <label for="pendidikan" class="form-label">Pendidikan Terakhir*</label>
													  <select class="selectpicker w-100 pendidikan" data-style="btn-default" data-live-search="true" title="Pilih pendidikan terakhir yang ditamatkan"  name="pendidikan[]" required>
														  
													  </select>
												  </div>
											  </div>
											  <div class="row">
												  <div class="col mb-3">
													  <label for="pekerjaan" class="form-label">Pekerjaan Saat Ini*</label>
													  <select id="pekerjaan" class="selectpicker w-100 pekerjaan" data-style="btn-default" data-live-search="true" title="Pilih pekerjaan saat ini"  name="pekerjaan" required>
														  
													  </select>
												  </div>
											  </div>
											  <x-button type="button" class="btn btn-primary d-grid w-100" :value="__('Tambah Pendatang')"/>
											</div>							  
										</div>	
									  </div>
									</form>
									</div>
								</div>
								<button class="btn btn-label-secondary btn-dark btn-sm add-select" type="button">
									<span class="align-middle d-sm-inline-block d-none">+ Tambah</span>
								  </button>
								
							</div>
						</div>
						
						
						
					  <div class="col-12 d-flex justify-content-between mt-4">
						<button class="btn btn-label-secondary btn-prev" disabled type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i>
						  <span class="align-middle d-sm-inline-block d-none">Previous</span>
						</button>
						<button class="btn btn-primary btn-next" type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
					<form id="formKedatangan" class="mb-3" action="{{ route('dinamika.kelahiran.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
						@csrf
					<!-- Frameworks -->
					<div id="frameworks" class="content pt-3 pt-lg-0">
					 
						<div class="row ">
							<div class="col mb-3">
							  <x-label for="nik" :value="__('NIK Bayi*')" />
							  <x-input type="text" name="nik" id="nik" :placeholder="__('NIK 16 digit')" :value="old('nik')" required/>
							  <x-invalid error="nik" />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<x-label for="no_kk" :value="__('No Kartu Keluarga Bayi*')" />
								<x-input type="text" name="no_kk" id="no_kk" :placeholder="__('No pada KK 16 digit')" :value="old('no_kk')" required/>
								<x-invalid error="no_kk" />
							  </div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<x-label for="nama" :value="__('Nama*')" />
								<x-input type="text" name="nama" id="nama" :placeholder="__('Nama Lengkap Sesuai Akta')" :value="old('nama')" required/>
								<x-invalid error="nama" />
							  </div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="agama" class="form-label">Agama Bayi*</label>
								<select id="agama" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih agama"  name="agama" required>
									<option value="Islam">Islam</option>
									<option value="Kristen">Kristen (Protestan)</option>
									<option value="Katolik">Katolik</option>
									<option value="Hindu">Hindu</option>
									<option value="Budha">Budha</option>
									<option value="Konghucu">Konghucu</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="gol_darah" class="form-label">Golongan Darah Bayi*</label>
								<select id="gol_darah" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Golongan Darah"  name="gol_darah" required>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="AB">AB</option>
									<option value="O">O</option>
									<option value="Tidak Mengetahui">Tidak Mengetahui</option>
								</select>
							</div>
						</div>
						
						<div class="row mb-3">
							<div class="accordion col mb-2" id="accordionExample">
								<div class="card accordion-item">
									<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
										<div class="row">
											<div class="">
											  <x-label for="kode_wilayah" :value="__('Alamat Bayi sesuai KK*')" />
											  <x-input type="text" name="kode_wilayah_ktp" id="kode_wilayah" :value="old('kode_wilayah_ktp')" readonly/>
											  <x-invalid error="kode_wilayah" />
											</div>
											
										  </div>
										
									</button>
		
							  
								  <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<div class="row">
											<div class="col mb-2">
												<label for="provinsi" class="form-label">Provinsi</label>
												<select id="provinsi" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="kode_provinsi">
													
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col mb-2">
												<label for="kabupaten" class="form-label">Kabupaten</label>
												<select id="kabupaten" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kabupaten"  name="kode_kabupaten">
													
												</select>
											</div>
										</div>
		
										<div class="row">
											<div class="col mb-2">
												<label for="kecamatan" class="form-label">Kecamatan</label>
												<select id="kecamatan" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kecamatan" name="kode_kecamatan">
													
												</select>
											</div>
										</div>
		
										<div class="row">
											<div class="col mb-2">
												<label for="desa" class="form-label">Desa</label>
												<select id="desa" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih desa/kelurahan" name="kode_desa">
													
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col mb-3">
												<x-label for="alamat_ktp" :value="__('Alamat*')" />
												<x-input type="text" name="alamat_ktp" id="alamat_ktp" :placeholder="__('Alamat Lengkap Sesuai KTP')" :value="old('alamat_ktp')" />
												<x-invalid error="alamat_ktp" />
											  </div>
										</div>
										
									</div>
								  </div>
								</div>
							</div>
						</div>
					  <div class="col-12 d-flex justify-content-between mt-4">
						<button class="btn btn-label-secondary btn-prev" type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span class="align-middle d-sm-inline-block d-none">Previous</span> </button>
						<button class="btn btn-primary btn-next" type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
				<!-- submit -->
				<div id="submit" class="content pt-3 pt-lg-0">
					<div class="row g-2 mb-3">
						<div class="col">
							<label for="kepala_nik" class="form-label">Kepala Rumah Tangga Bayi*</label>
						<select id="kepala_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Kepala Rumah Tangga" name="kepala_nik" required>
							
						</select>
							<x-invalid error="kepala_nik" />
						  </div>
						  <div class="col">
							<x-label for="hubungan_ruta" :value="__('hubungan dengan Kepala Rumah Tangga')" />
							<select id="hubungan_ruta" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Hubungan Rumah Tangga" name="hubungan_ruta" required>
								
							</select>
							<x-invalid error="hubungan_ruta" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
							<x-label for="bukti" :value="__('Bukti Kelahiran* (.pdf/.jpg/.png)')"/>
							<x-input class="" type="file" id="bukti" name="bukti" required/>
							<x-invalid error="bukti" />
						  </div>
					  </div>
					<div class="row ">
						<div class="col mb-3">
							<label for="keterangan" class="form-label">Keterangan</label>
							<textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
						  <x-invalid error="keterangan" />
						</div>
					</div>
				 
					  <div class="col-12 d-flex justify-content-between mt-4 pt-2">
						<button class="btn btn-label-secondary btn-prev" type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span class="align-middle d-sm-inline-block d-none">Previous</span> </button>
						<button class="btn btn-success btn-submit"> <span class="align-middle d-sm-inline-block d-none">Submit</span> <i class="bx bx-check bx-xs ms-sm-1 ms-0"></i> </button>
					  </div>
					</form>
					</div>
					
	  
					
						
				 
				</div>
			  </div>
			</div>
			<!--/ App Wizard -->
		  </div>
		</div>
	  </div>
	</div>

	  <!--/ Create App Modal -->
		</div>
	</div>
	

	<form method="POST" class="d-none" id="verif-form">
		@csrf
		@method("PUT")
	</form>

	<script>
		
	</script>

<script>
		
		$( document ).ready(function() {
			var c=1;
			$('.btn-del-select').hide();
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$(document).on('click','.add-select', function(){
			c++;
			let temp = $(this).parent().parent().find(".clone-row").clone().insertBefore($(this)).removeClass("clone-row");
			temp.find('.btn-del-select').fadeIn();
			temp.find('.accordion-header').attr("id", "headingOptions"+c);
			temp.find('.accordion-button').attr("data-bs-target", "#headingCollapse"+c);
			temp.find('.accordion-button').attr("aria-controls", "headingCollapse"+c);
			temp.find('.accordion-collapse').attr("aria-labelledby", "headingOptions"+c);
			temp.find('.accordion-collapse').attr("id", "headingCollapse"+c);
			temp.find('.accordion-body').attr("data-value", ""+c);
			temp.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
			temp.find('select').selectpicker('refresh');
			
			$(this).parent().parent().find(".btn-del-select").click(function(e) {
				$(this).parent().parent().parent().remove(); 
			});
		});
		

		

		$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-prov')}}",
					success: function(msg){
						
						$('select.provinsi').each(function(){
							$(this).html(msg);
							$(this).selectpicker('refresh');
						});
						$('select.provinsi-lahir').each(function(){
							$(this).html(msg);
							$(this).selectpicker('refresh');
						});
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$.ajax({
					type : 'GET',
					url: "{{route('master.identitas.get-pendidikan')}}",
					success: function(msg){
						
						$('select.pendidikan').each(function(){
							$(this).html(msg);
							$(this).selectpicker('refresh');
						});
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$.ajax({
					type : 'GET',
					url: "{{route('master.identitas.get-pekerjaan')}}",
					success: function(msg){
						
						$('select.pekerjaan').each(function(){
							$(this).html(msg);
							$(this).selectpicker('refresh');
						});
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				})

				$.ajax({
					type : 'GET',
					url: "{{route('get-kepala-ruta')}}",
					success: function(msg){

						$('#kepala_nik').html(msg);
						$('#kepala_nik').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$.ajax({
					type : 'GET',
					url: "{{route('master.ruta.get-hubungan')}}",
					success: function(msg){
						$('#hubungan_ruta').html(msg);
						$('#hubungan_ruta').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		var now = new Date(),
			date = now.toISOString().split('T');
			today = date[0];
			$('#waktu').prop('max', today);
	});
	$(function(){
			$('.provinsi-lahir').on('change',function(){
				console.log(this);
				$(this).selectpicker('render');
				let id_prov = $('#provinsi-lahir').val();
				let el = $("#provinsi-lahir option:selected").attr("data-tokens");

				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-kab')}}",
					data : {'id_prov':id_prov},
					success: function(msg){
						$('#kabupaten-lahir').selectpicker('destroy');
						$('#kabupaten-lahir').html(msg);
						$('#kabupaten-lahir').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#kabupaten-lahir').on('change',function(){
				$('#kabupaten-lahir').selectpicker('render');
				let id_kab = $('#kabupaten-lahir').val();
				let el = $("#kabupaten-lahir option:selected").attr("data-tokens");
				$('#tempat_lahir').val(el);

				
			});
		});
		$(function(){
			$('.provinsi').on('change',function(){
				console.log(this.val());
				$('.provinsi').selectpicker('render');
				let id_prov = $('#provinsi').val();
				let el = $("#provinsi option:selected").attr("data-tokens");
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
				let el = $("#kabupaten option:selected").attr("data-tokens");
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
				let el = $("#kecamatan option:selected").attr("data-tokens");
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
				let el = $("#desa option:selected").attr("data-tokens");
				$('#nama_des').val(el);
				$('#kode_wilayah').val(id_desa);
			});
		});
	</script>
<script>
	function verif(element) {
		event.preventDefault()
		let form = document.getElementById('verif-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin ingin verifikasi data kelahiran ?', `Setelah verifikasi, warga akan diubah status dan rutanya`, 'Ya! verif', () => {
			form.submit()
		})
	}
</script>
<script>
	/**
 *  Modal Example Wizard
 */

'use strict';

$(function () {
  // Modal id
  const appModal = document.getElementById('addDatang');
  let formLahir = document.getElementById('formKedatangan');



  appModal.addEventListener('show.bs.modal', function (event) {
    const wizardCreateApp = document.querySelector('#wizard-create-app');
    if (typeof wizardCreateApp !== undefined && wizardCreateApp !== null) {
      // Wizard next prev button
      const wizardCreateAppNextList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-next'));
      const wizardCreateAppPrevList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-prev'));
      const wizardCreateAppBtnSubmit = wizardCreateApp.querySelector('.btn-submit');

      const createAppStepper = new Stepper(wizardCreateApp, {
        linear: false
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

      if (wizardCreateAppBtnSubmit) {
        wizardCreateAppBtnSubmit.addEventListener('click', event => {
			formLahir.submit()
        });
      }
    }
  });
});

</script>



@endsection

