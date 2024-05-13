
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Kelahiran') }}
			</h5>

			
				<!-- Button trigger modal -->
@if(auth()->user()->hasRole('ketua rt'))
<div class="mb-4">
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addLahir">
	Tambah Data Kelahiran
  </button>

</div>

			
	<!-- Create App Modal -->
	<div class="modal fade" id="addLahir" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg ">
		  <div class="modal-content p-2 p-md-4">
			<div class="modal-header">
				<h5 class="modal-title" id="judulModal">Tambah Data Kelahiran</h5>
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
						<span class="bs-stepper-title text-uppercase">Kelahiran</span>
						<span class="bs-stepper-subtitle">Detail Kelahiran</span>
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
						<span class="bs-stepper-subtitle">Identitas Bayi</span>
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
					<form id="formKelahiran" class="mb-3" action="{{ route('dinamika.kelahiran.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
						@csrf
					<!-- Details -->
					<div id="details" class="content pt-3 pt-lg-0">
						
						<div class="row">
							<div class="col mb-3">
								<label for="tempat" class="form-label">Tempat Dilahirkan</label>
								<select id="tempat" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Tempat Kematian" name="tempat" required>
									<option value="Rumah Sakit">Rumah Sakit</option>
									<option value="Puskesmas">Puskesmas</option>
									<option value="Rumah">Rumah</option>
									<option value="Lainnya">Lainnya</option>
								</select>
								<x-invalid error="tempat" />
							</div>
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
								<x-label for="waktu" :value="__('Waktu Kelahiran*')" />
							  <x-input type="datetime-local" name="waktu" id="waktu"  :value="old('waktu')" required/>
							  <x-invalid error="waktu" />
							</div>
						</div>
						<div class="row g-2 mb-3">
							<div class="col">
							  <x-label for="berat" :value="__('Berat Bayi*')" />
							  <x-input type="number" name="berat" id="berat" min="0" step="0.01" :value="old('berat')" required/>
							  <x-invalid error="berat" />
							</div>
							<div class="col">
								<x-label for="panjang" :value="__('Panjang Bayi*')" />
								<x-input type="number" name="panjang" id="panjang" min="0" step="0.01" :value="old('panjang')" required/>
								<x-invalid error="panjang" />
							  </div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="jenis_kelamin" class="form-label">Jenis Kelamin Bayi*</label>
								<select id="jenis_kelamin" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih jenis kelamin"  name="jenis_kelamin" required>
									<option value="laki-laki">Laki-Laki</option>
									<option value="perempuan">Perempuan</option>
								</select>
							</div>
						</div>
					
						<div class="row g-2 mb-3">
							<div class="col">
							  <x-label for="ibu_nik" :value="__('NIK Ibu*')" />
							  <x-input type="text" name="ibu_nik" id="ibu_nik" :placeholder="__('NIK 16 digit')" :value="old('ibu_nik')" required/>
							  <x-invalid error="ibu_nik" />
							</div>
							<div class="col">
								<x-label for="bapak_nik" :value="__('NIK Ayah*')" />
								<x-input type="text" name="bapak_nik" id="bapak_nik" :placeholder="__('NIK 16 digit')" :value="old('bapak_nik')" required/>
								<x-invalid error="bapak_nik" />
							</div>
						</div>
						
					  <div class="col-12 d-flex justify-content-between mt-4">
						<button class="btn btn-label-secondary btn-prev" disabled type="button"> <i class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i>
						  <span class="align-middle d-sm-inline-block d-none">Previous</span>
						</button>
						<button class="btn btn-primary btn-next" type="button"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-right-arrow-alt bx-xs"></i></button>
					  </div>
					</div>
	  
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
						<select id="kepala_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Kepala Rumah Tangga" name="ruta_id" required>
							
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
							<x-label for="bukti" :value="__('Bukti Kelahiran* (.jpg/.png)')"/>
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
					</div>
					
	  
					
						
				  </form>
				</div>
			  </div>
			</div>
			<!--/ App Wizard -->
		  </div>
		</div>
	  </div>
	
	  <div class="modal  fade" id="messageModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel1">Alasan Penolakan</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
				<div class="modal-body">
					<form id="formMessage" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
						@csrf
						
						<div>
							<label for="exampleFormControlTextarea1" class="form-label">Pesan</label>
							<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
						  </div>
						  <small class="mb-2 text-muted">Setelah data ditolak, data akan terhapus. Pesan penolakan akan dikirm ke email pengaju</small>
				  </div>
				  <div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Kirim Pesan')"/>
				  </div>
				</form>
			</form>
		  </div>
		</div>
	  </div>
@endif	
	@include('components.table')
	@include('menu.dinamika._partials.show')
	<!-- Modal -->

		
	</div>
</div>


	<form method="POST" class="d-none" id="verif-form">
		@csrf
		@method("PUT")
	</form>
	
	

<script>
		
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

						$('#provinsi-lahir').html(msg);
						$('#provinsi-lahir').selectpicker('refresh');
						$('#provinsi').html(msg);
						$('#provinsi').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
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
					data:{uncheck:[1,2,3,5,7]},
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
			time = 'T'+date[1].split('.')[0];
			$('#waktu').prop('max', today+time);
	});
	$(document).on('click','.open_modal_lihat',function(){
			$('#biodata').empty();
				let url= $(this).val();
				$.ajax({
					type : 'GET',
					url: url,
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
					success: function(msg){
						
						let data = JSON.parse(msg);
						$('#title').html('Detail Kelahiran')
						$('#biodata').append('<p><strong>Nama : </strong>'+data.dinamika.warga.nama+'</p>');
						$('#biodata').append('<p><strong>NIK : </strong>'+data.dinamika.warga.nik+'</p>');
						$('#biodata').append('<p><strong>Waktu Kelahiran : </strong>'+data.waktu+'</p>');
						$('#biodata').append('<p><strong>Berat Lahir : </strong>'+data.berat+'</p>');
						$('#biodata').append('<p><strong>Panjang Lahir : </strong>'+data.panjang+'</p>');
						if(data.bapak!=null){
							$('#biodata').append('<p><strong>Ayah : </strong>'+data.bapak_nik+' ['+data.bapak+']</p>');
						}
						else{
							$('#biodata').append('<p><strong>Ayah : </strong>'+data.bapak_nik+' [warga luar]</p>');
						}
						if(data.ibu!=null){
							$('#biodata').append('<p><strong>Ibu : </strong>'+data.ibu_nik+' ['+data.ibu+']</p>');
						}
						else{
							$('#biodata').append('<p><strong>Ibu : </strong>'+data.ibu_nik+' [warga luar]</p>');
						}
						
						if(data.keterangan!=null){
							$('#biodata').append('<p><strong>Keterangan : </strong></p><p>'+data.keterangan+'</p>');
						}
						$('#biodata').append('<div class="mt-2"><h5 class=" text-center">Foto Bukti</h5><img class="w-75 mx-auto d-block" src="/storage/' + data.bukti + '"/></div>');
	
						$('#modalLihat').modal('show');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
			}); 
	</script>
@if(in_array('ketua rt',auth()->user()->getRoleNames()->toArray()))
<script>
	function verif(element) {
		event.preventDefault()
		let form = document.getElementById('verif-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin ingin verifikasi data kelahiran ?', `Setelah verifikasi, warga akan diubah status dan rutanya`, 'Ya! verif', () => {
			form.submit()
		})
	}
	
	$(function(){
		$(document).on('click','.open_modal_tolak',function(){
				let link= $(this).attr('data-link');
				$('#formMessage').attr('action',link);
				$('#messageModal').modal('show');
				
			}); 
			$('#provinsi-lahir').on('change',function(){
				$('#provinsi-lahir').selectpicker('render');
				let id_prov = $('#provinsi-lahir').val();

				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-kab')}}",
					data : {'id_prov':id_prov},
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
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
		$(function(){
			$('#provinsi').on('change',function(){
				$('#provinsi').selectpicker('render');
				let id_prov = $('#provinsi').val();

				
				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-kab')}}",
					data : {'id_prov':id_prov},
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
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
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},

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

					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
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
		});
		
</script>
<script>
	/**
 *  Modal Example Wizard
 */

'use strict';

$(function () {
  // Modal id
  const appModal = document.getElementById('addLahir');
  let formLahir = document.getElementById('formKelahiran');



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
@endif




@endsection

