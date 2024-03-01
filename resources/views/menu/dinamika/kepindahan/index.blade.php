
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Kepindahan Warga') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addPindah">
	Tambah Kepindahan
  </button>


  
  
  <!-- Modal -->
  <div class="modal fade" id="addPindah" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Tambah Data Kepindahan</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('dinamika.kepindahan.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="jenis" class="form-label">Jenis Kepindahan</label>
						<select id="jenis" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Jenis Kepindahan" name="jenis" required>
							<option value="Seluruh">Seluruh Rumah Tangga</option>
    						<option value="Sebagian">Sebagian Anggota Rumah Tangga</option>
							<option value="Perorangan">Perorangan</option>
						</select>
						<x-invalid error="jenis" />
					</div>
				</div>
				<div class="row mb-3" id="ruta_pindah">
					<div class="col">
						<label for="kepala_nik" class="form-label">Kepala Rumah Tangga*</label>
						<select id="kepala_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true"  title="Pilih Rumah Tangga" name="kepala_nik">
							
						</select>
						<x-invalid error="kepala_nik" />
					</div>
				</div>
				<div class="row  mb-3" id="warga_pindah">
					<div class="col">
						<label for="nik" class="form-label">Warga Pindah*</label>
						<select id="nik" class="selectpicker w-100" data-style="btn-default" multiple data-icon-base="bx" multiple data-actions-box="true" data-live-search="true" data-tick-icon="bx-check text-primary" title="Pilih Warga" name="nik[]">
							
						</select>
						<x-invalid error="nik" />
					</div>
				</div>
				<div class="row mb-3">
					<div class="accordion col mb-2" id="accordionExample">
						<div class="card accordion-item">
							<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
								<div class="row">
									<div class="">
									  <x-label for="kode_wilayah" :value="__('Alamat Pindah*')" />
									  <x-input type="text" name="kode_wilayah_pindah" id="kode_wilayah" :value="old('kode_wilayah_pindah')" readonly/>
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
										<x-input type="text" name="alamat_pindah" id="alamat_pindah" :placeholder="__('Alamat Lengkap domisili baru')" :value="old('alamat_pindah')" />
										<x-invalid error="alamat_pindah" />
									  </div>
								</div>
								
							</div>
						  </div>
						</div>
					</div>
				
				
				<div class="row">
					<div class="col mb-3">
						<x-label for="waktu" :value="__('Waktu Kepindahan*')" />
					  <x-input type="date" name="waktu" id="waktu"  :value="old('waktu')" required/>
					  <x-invalid error="waktu" />
					</div>
				</div>
				

				<div class="row">
					<div class="col mb-3">
						<label for="penyebab" class="form-label">Alasan Pindah</label>
						<select id="penyebab" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Alasan Pindah" name="penyebab" required>
							<option value="Pekerjaan">Pekerjaan</option>
    						<option value="Pendidikan">Pendidikan</option>
							<option value="Keamanan">Keamanan</option>
							<option value="Kesehatan">Kesehatan</option>
							<option value="Keluarga">Keluarga</option>
							<option value="Lainnya">Lainnya</option>
						</select>
						<x-invalid error="penyebab" />
					</div>
				</div>

				
				
				  <div class="row">
					<div class="col mb-3">
						<x-label for="bukti" :value="__('Bukti* (.pdf/.jpg/.png)')"/>
						<x-input class="form-control" type="file" id="bukti" name="bukti" required/>
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
				
				

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Data Kepindahan')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

  

  

			</div>

			@include('menu.dinamika._partials.table')

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
		$('#ruta_pindah').hide();
		$('#warga_pindah').addClass('d-none');
		$('#warga_pindah').prop('required',false);
		
		$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-prov')}}",
					success: function(msg){
						
						$('#provinsi').html(msg);
						$('#provinsi').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				
		
	});
	$(function(){
		$('#jenis').on('change',function(){
				$('#jenis').selectpicker('render');
				let jenis = $('#jenis').val();
				if(jenis == 'Perorangan'){
					$('#ruta_pindah').hide();
					$('#warga_pindah').removeClass('d-none');
					$('#warga_pindah').prop('required',true);
					$.ajax({
						type : 'GET',
						url: "{{route('warga.get-warga')}}",
						success: function(msg){
							$('#nik').selectpicker('destroy');
							$('#nik').html(msg);
							$('#nik').selectpicker('render');	
						},
						error: function (xhr) {
							var err = JSON.parse(xhr.responseText);
							alert(err.message);
						}
					});
				}
				else{
					$('#ruta_pindah').show();
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
					if(jenis == 'Seluruh'){
						$('#warga_pindah').addClass('d-none');
						$('#warga_pindah').prop('required',false);
					}
					else if(jenis == 'Sebagian'){
						$('#warga_pindah').removeClass('d-none');
						$('#warga_pindah').prop('required',true);
					
					}
				}
				
			});
			$('#kepala_nik').on('change',function(){
				$('#kepala_nik').selectpicker('render');
				let kepala = $('#kepala_nik').val();
				
				$.ajax({
					type : 'POST',
					url: "{{route('ruta.anggota-get')}}",
					data : {'kepala':kepala},
					success: function(msg){
						$('#nik').selectpicker('destroy');
						$('#nik').html(msg);
						$('#nik').selectpicker('render');
						let jenis = $('#jenis').val();
						if(jenis == 'Seluruh'){
							$('#nik').selectpicker('selectAll');
							console.log()
						}
						else if (jenis == 'Sebagian'){
							$('#nik').selectpicker('deselectAll');
						}
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#provinsi').on('change',function(){
				$('#provinsi').selectpicker('render');
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
		swalConfirm('Yakin ingin verifikasi data kepindahan ?', `Setelah verifikasi, warga akan diubah status dan rutanya`, 'Ya! verif', () => {
			form.submit()
		})
	}
</script>



@endsection

