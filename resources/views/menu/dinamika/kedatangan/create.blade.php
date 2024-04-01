
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title mb-4">
				{{ __('Tambah Data Kedatangan') }}
			</h5>
			   <!-- App Wizard -->
			   <div id="wizard-create-app" class="bs-stepper wizard-numbered mt-2 shadow-none border-0">
				<div class="bs-stepper-header p-1">
				  <div class="step p-2" data-target="#details">
					<button type="button" class="step-trigger">
					  <span class="bs-stepper-circle">1</span>
					  <span class="bs-stepper-label">
						<span class="bs-stepper-title text-uppercase">Identitas</span>
						<span class="bs-stepper-subtitle">Identitas Pendatang</span>
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
						<span class="bs-stepper-title text-uppercase">Kedatangan</span>
						<span class="bs-stepper-subtitle">Detail Kedatangan</span>
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
						<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addWarga">
							Tambah Identitas Pendatang
						  </button>

						  <div class="table-responsive">
							<table class="table table-striped table-bordered mb-4">
								<thead>
									<tr>
										<th>{{ __('#') }}</th>
										<th>{{ __('NIK') }}</th>
										<th>{{ __('No KK') }}</th>
										<th>{{ __('Nama') }}</th>
									</tr>
								</thead>
								<tbody id="pendatangTable">
									
								</tbody>
							</table>
						
						</div>
						
						   <!-- Modal -->
  <div class="modal fade" id="addWarga" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Tambah Identitas Pendatang</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formPendatang" class="mb-3" action="{{ route('dinamika.kedatangan.pendatang') }}" data-remote="true" method="POST">
			@csrf
			
			<div class="modal-body">
				<div class="card" id="errorCon">
					<h6 class="text-danger">Terjadi Kesalahan!</h6>
					<p class='mx-3'><small class="text-danger" id="error_msg"></small></p>
				</div>
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="nik" :value="__('NIK*')" />
					<x-input type="text" name="nik" id="nik" :placeholder="__('NIK 16 digit')" :value="old('nik')" required/>
					<x-invalid error="nik" />
				  </div>
				  
				  
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="no_kk" :value="__('No Kartu Keluarga*')" />
						<x-input type="text" name="no_kk" id="no_kk" :placeholder="__('No pada KK 16 digit')" :value="old('no_kk')" required/>
						<x-invalid error="no_kk" />
					  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="nama" :value="__('Nama*')" />
						<x-input type="text" name="nama" id="nama" :placeholder="__('Nama Lengkap Sesuai KTP')" :value="old('nama')" required/>
						<x-invalid error="nama" />
					  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="no_telp" :value="__('No HP*')" />
						<x-input type="text" name="no_telp" id="no_telp" :placeholder="__('62xxxxxx')" :value="old('no_telp')" required/>
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

						<div class="divider divider-dashed mb-2">
							<div class="divider-text">Biodata Pendatang</div>
						  </div>
				<div class="row g-2 mb-3">
					<label for="provinsi" class="form-label">Tempat Lahir</label>
					<div class="col">
						
						<select id="provinsi-lahir" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="provinsi-lahir" required>
							
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
						<select id="pendidikan" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pendidikan terakhir yang ditamatkan"  name="pendidikan" required>
							
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="pekerjaan" class="form-label">Pekerjaan Saat Ini*</label>
						<select id="pekerjaan" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pekerjaan saat ini"  name="pekerjaan" required>
							
						</select>
					</div>
				</div>

				</div>

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Warga')"/>
			  </div>
		</form>
	  </div>
	</div>
</div>
</div>
						
					  <div class="col-12 d-flex justify-content-between mt-4">
						{{-- <button class="btn btn-label-secondary btn-prev" disabled type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i>
						  <span class="align-middle d-sm-inline-block d-none">Previous</span>
						</button> --}}
						<button class="btn btn-primary btn-next" id="pendatangBTN" type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
					<form id="formKedatangan" class="mb-3" action="{{ route('dinamika.kedatangan.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
						@csrf
					<!-- Frameworks -->
					<div id="frameworks" class="content pt-3 pt-lg-0">
						<x-input type="type" class="d-none" name="pendatang" id="pendatangField" required/>
						<div class="row">
							<div class="col mb-3">
								<x-label for="waktu" :value="__('Waktu Kedatangan*')" />
							  <x-input type="date" name="waktu" id="waktu"  :value="old('waktu')" required/>
							  <x-invalid error="waktu" />
							</div>
						</div>
						<div class="row g-2 mb-3">
							<div class="col">
								<label for="is_new_ruta" class="form-label">Kepala Rumah Tangga*</label>
								<select id="is_new_ruta" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Rumah Tangga Baru/Menumpang"  name="is_new_ruta" required>
									<option value=true>Dari Pendatang</option>
									<option value=false>Warga Desa</option>
								</select>
							</div>
							<div class="col">
								<label for="kepala_nik" class="form-label">Kepala Rumah Tangga*</label>
							<select id="kepala_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Kepala Rumah Tangga" name="kepala" required>
								
							</select>
								<x-invalid error="kepala" />
							  </div>
						</div>
						<div class="new_ruta" id="new_ruta">
							
							<div class="row ">
							  <div class="col mb-3">
								<x-label for="alamat_domisili" :value="__('Alamat Domisili*')" />
								<x-input type="text" name="alamat_domisili" id="alamat_domisili" :placeholder="__('Alamat Domisili Lengkap')" :value="old('alamat_domisili')"/>
								<x-invalid error="alamat_domisili" />
							  </div>
						</div>
					</div>
						<div class="table-responsive" id="hubunganTable">
							<table class="table table-striped table-bordered mb-4">
								<thead>
									<tr>
										<th>{{ __('Hubungan') }}</th>
										<th>{{ __('NIK') }}</th>
										<th>{{ __('No KK') }}</th>
										<th>{{ __('Nama') }}</th>
									</tr>
								</thead>
								<tbody id="hubunganIsiTable">
									
								</tbody>
							</table>
						
						</div>
					  <div class="col-12 d-flex justify-content-between mt-4">
						{{-- <button class="btn btn-label-secondary btn-prev" type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span class="align-middle d-sm-inline-block d-none">Previous</span> </button> --}}
						<button class="btn btn-primary btn-next" type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
				<!-- submit -->
				<div id="submit" class="content pt-3 pt-lg-0">
					
					<div class="row">
						<div class="col mb-3">
							<x-label for="bukti" :value="__('Bukti Kedatangan* (.pdf/.jpg/.png)')"/>
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
						{{-- <button class="btn btn-label-secondary btn-prev" type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span class="align-middle d-sm-inline-block d-none">Previous</span> </button> --}}
						<button class="btn btn-success btn-submit"> <span class="align-middle d-sm-inline-block d-none">Submit</span> <i class="bx bx-check bx-xs ms-sm-1 ms-0"></i> </button>
					  </div>
					</div>
					
	  
					
						
				  </form>
				</div>
			  </div>
			</div>
			<!--/ App Wizard -->
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
		var now = new Date(),
		today = now.toISOString().split('T')[0];
		$('#tanggal_lahir').prop('max', today);
		$('#errorCon').hide();
		$('#hubunganTable').hide();
		$('#new_ruta').hide();
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
					$('#provinsi-lahir').html(msg);
					$('#provinsi-lahir').selectpicker('refresh');
					
					
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
					
					$('#pendidikan').html(msg);
					$('#pendidikan').selectpicker('refresh');
					
					
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
					
					$('#pekerjaan').html(msg);
					$('#pekerjaan').selectpicker('refresh');
					
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
			})
	});
	
	
	
	$(function(){
		$('#provinsi-lahir').on('change',function(){
			$('#provinsi-lahir').selectpicker('render');
			let id_prov = $('#provinsi-lahir').val();

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
			let el = $("#kabupaten-lahir option:selected").text();
			$('#tempat_lahir').val(el);

			
		});
	});
</script>
<script>
	$(function(){
		
		$('#is_new_ruta').on('change',function(){
			$('#is_new_ruta').selectpicker('render');
			let is_new = $('#is_new_ruta').val();
			if(is_new=="true"){
			
				const anggota = data.map((value,index) => {
				return (
					`<option data-tokens='${value.nik}+${value.nama}' value='${value.nik}'>${value.nik} | ${value.nama}</option>`
				);
				}).join('');
				$('#kepala_nik').selectpicker('destroy');
				$('#kepala_nik').html(anggota);
				$('#kepala_nik').selectpicker('render');
				$('#new_ruta').show();
			}
			else{
			
				$.ajax({
					type : 'GET',
					url: "{{route('get-kepala-ruta')}}",
					success: function(msg){
						$('#kepala_nik').selectpicker('destroy');
						$('#kepala_nik').html(msg);
						$('#kepala_nik').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$('#new_ruta').hide();
				$('#alamat_domisili').val('');
				$('#rw_id').val('default').trigger('change');
				$('#rw_id').selectpicker('refresh');
				$('#rw_id').selectpicker("render");

			}			
			
		});
		$('#kepala_nik').on('change',function(){
			$('#kepala_nik').selectpicker('render');
			let is_new = $('#is_new_ruta').val();
			let nik = $('#kepala_nik').val();
			$('#hubunganTable').show();
			if(is_new=="true"){
				
				makeHubungan(nik);
			}
			else{
				makeHubungan(0);
				
			}			
			
		});
		$('#provinsi').on('change',function(){
			$('#provinsi').selectpicker('render');
			let id_prov = $('#provinsi').val();
			
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
			$('#kode_wilayah').val(id_desa);
		});
	})
</script>


<script>
	var data =[];
	/**
 *  Modal Example Wizard
 */

 function makeHubungan(nik) {
		const tableData = data.map((value,index) => {
			if(value.nik != nik){
				return (
		`<tr>
		<td>Lainnya</td>
		<td>${value.nik}</td>
		<td>${value.no_kk}</td>
		<td>${value.nama}</td>
		</tr>`
	);
			}
			else{
				return (
					`<tr>
		<td>Kepala Rumah Tangga</td>
		<td>${value.nik}</td>
		<td>${value.no_kk}</td>
		<td>${value.nama}</td>
		</tr>`
	);
			}
	
	}).join('');

	const tableBody = document.querySelector("#hubunganIsiTable");
	tableBody.innerHTML = tableData;
}
 function makeTable() {
		const tableData = data.map((value,index) => {
	return (
		`<tr>
		<td><button class="btn btn-sm btn-danger m-1" onclick="remove(${index})">Hapus</button></td>
		<td>${value.nik}</td>
		<td>${value.no_kk}</td>
		<td>${value.nama}</td>
		</tr>`
	);
	}).join('');

	const tableBody = document.querySelector("#pendatangTable");
	tableBody.innerHTML = tableData;
}
function remove(element) {
	data.splice(element, 1);
	makeTable();
}
 $('#formPendatang').submit(function( event ) {
    event.preventDefault();
    $.ajax({
        url: '{{route("dinamika.kedatangan.pendatang")}}',
        type: 'post',
        data: $('#formPendatang').serialize(), // Remember that you need to have your csrf token included
        success: function(msg ){
			if($.isEmptyObject(msg.error)){
				$('#errorCon').hide();
								$('#error_msg').empty();
								$("#formPendatang")[0].reset();
			$("#addWarga").modal('hide');	
			
			$('.selectpicker').val('default').trigger('change');
			$('.selectpicker').selectpicker('refresh');

			data.push(JSON.parse(msg));
			makeTable();
							}
							else{
								$('#errorCon').show();
								$('#error_msg').text(msg.error);

							}
        },
        error: function( _response ){
            // Handle error
        }
    });
});


$("#pendatangBTN").click(function(){
	$('#pendatangField').val(JSON.stringify(data));
}); 

'use strict';

$(function () {
  // Modal id
  let formLahir = document.getElementById('formKedatangan');




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
    //   if (wizardCreateAppPrevList) {
    //     wizardCreateAppPrevList.forEach(wizardCreateAppPrev => {
    //       wizardCreateAppPrev.addEventListener('click', event => {
    //         createAppStepper.previous();
           
    //       });
    //     });
    //   }

      if (wizardCreateAppBtnSubmit) {
        wizardCreateAppBtnSubmit.addEventListener('click', event => {
			formLahir.submit()
        });
      }
    }
  });


</script>


@endsection

