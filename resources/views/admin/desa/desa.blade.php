@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<div class="nav-align-top">
				<ul class="nav nav-pills mb-3" role="tablist">
				  <li class="nav-item">
					<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Profil</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Deskripsi</button>
				  </li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
						<div class="mb-4">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#editDesa">
								Edit Profil Desa
							</button>
							
							
							
						</div>
					<h5>Kode Wilayah : {{$desa->kode_wilayah}}</h5>
					<h5>Provinsi : {{$desa->provinsi}}</h5>
					<h5>Kabupaten : {{$desa->kabupaten}}</h5>
					<h5>Kecamatan : {{$desa->kecamatan}}</h5>
					<h5>Desa : {{$desa->desa}}</h5>
					<h5>Alamat Kantor : {{$desa->alamat_kantor}}</h5>
					<h5>Email Desa : {{$desa->email_desa}}</h5>
					<h5>Nomor Kantor Desa : {{$desa->no_telp}}</h5>
				  </div>
				  <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
					<div class="mb-4">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#deskripsiDesa">
							Edit Deskripsi Desa
						</button>
						
					</div>
					<h3 class="mb-4">Desa {{$desa->desa}}</h3>
					{!!$desa->deskripsi!!}
				  </div>
				  
				</div>
			  </div>

			

			

		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deskripsiDesa" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Deskripsi Desa</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<form id="formAuthentication" class="mb-3" action="{{ route('m.desa.deskripsi',$desa) }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@method('PUT')
				@csrf
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				
				<div class="modal-body">
					<input id="x" type="hidden" name="deskripsi" value="{{$desa->deskripsi}}">
					<trix-editor input="x" ></trix-editor>
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ubah')"/>
				</div>
			</form>
		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="editDesa" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Profil Desa</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<form id="formAuthentication" class="mb-3" action="{{ route('m.desa.update',$desa) }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@method('PUT')
				@csrf
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				
				<div class="modal-body">

					
					  <div class="row">
						<div class="accordion col mb-3" id="accordionExample">
							<div class="card accordion-item">
								<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
									<div class="row">
										<div class="mb-3">
										  <x-label for="kode_wilayah" :value="__('Kode Wilayah*')" />
										  <x-input type="text" name="kode_wilayah" id="kode_wilayah" value="{{$desa->kode_wilayah}}" readonly/>
										  <x-invalid error="kode_wilayah" />
										</div>
										
									  </div>
									
								</button>

						  
							  <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="row">
										<div class="col">
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

									<div class="row">
										<div class="col mb-3">
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
						  <x-input type="text" name="alamat_kantor" id="alamat_kantor"  value="{{$desa->alamat_kantor}}"/>
						  <x-invalid error="alamat_kantor" />
						</div>
					  </div>
					  <div class="row">
						<div class="col mb-3">
						  <x-label for="email_desa" :value="__('Email Kantor Desa*')" />
						  <x-input type="email" name="email_desa" id="email_desa" value="{{ $desa->email_desa}}" />
						  <x-invalid error="email_desa" />
						</div>
					  </div>
					  <div class="row">
						<div class="col mb-3">
							  <x-label for="no_telp" :value="__('No HP*')" />
							  <x-input type="text" name="no_telp" id="no_telp" :placeholder="__('628xxxxxxxxx')" value="{{$desa->no_telp}}" />
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
					
					
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ubah')"/>
				</div>
			</form>
		</div>
		</div>
	</div>
	
	


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
					
				})
			});
			$('#desa').on('change',function(){
				$('#desa').selectpicker('render');
				let id_desa = $('#desa').val();
				let el = $("#desa option:selected").attr("data-tokens");
				$('#nama_des').val(el);
				$('#kode_wilayah').val(id_desa);
			});
		})
	</script>



@endsection
