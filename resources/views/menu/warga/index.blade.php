
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Warga') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
@if(in_array('ketua rt',auth()->user()->getRoleNames()->toArray()))
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addWarga">
	Tambah Warga
  </button>
  <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#importExcel">
	Import Excel
  </button>


  
  
  <!-- Modal -->
  <div class="modal fade" id="addWarga" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Tambah Warga Baru</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('warga.store') }}" data-remote="true" method="POST">
			@csrf
			
			<div class="modal-body">
				
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
							<div class="divider-text">Biodata Warga</div>
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
  @include('menu.warga._partials.import')
@endif

			</div>

			
			@include('components.table')
			@include('menu.warga._partials.message')

		</div>
	</div>
</div>
<form method="POST" class="d-none" id="status-form">
	@csrf
	@method("PUT")
</form>
@if(auth()->user()->hasRole('kependudukan'))
	@include('menu.warga._partials.domisili')
	@include('menu.warga._partials.dokumen')
@endif

<script>
		
		$( document ).ready(function() {
			var now = new Date(),
			today = now.toISOString().split('T')[0];
			$('#tanggal_lahir').prop('max', today);
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
		function change(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Ubah Status ?', `Status warga akan diubah`, 'Ubah', () => {
			form.submit()
		})
	}
	</script>



@endsection

