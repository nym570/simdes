
@extends('layouts.auth')
@section('container')
	<h4 class="mb-2">Konfigurasi Desa</h4>
	<p class="mb-4">
		
	</p>


		@csrf
		<form id="formAuthentication" class="mb-3" action="{{ route('m.desa.update',$desa) }}" data-remote="true" method="POST" enctype="multipart/form-data">
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
				  <x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ubah')"/>
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
									
									$('#provinsi').html(msg);
									$('#provinsi').selectpicker('refresh');
									
									
								},
							})
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

