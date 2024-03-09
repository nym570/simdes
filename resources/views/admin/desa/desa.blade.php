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
							<button class="btn btn-dark mb-4 open_modal" value="{{$desa->pemimpin}}"> Kepala Desa</button>

							


							
							
							
							
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
<div class="modal fade" id="AssignRole" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="judulModal"></h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formRole" class="mb-3" action="{{ route('m.desa.kades') }}" data-remote="true" method="POST">
			@method('PUT')
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<x-input type="text" name="user" id="userLKD"  value="" placeholder="Tidak Ditemukan" readonly />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="selectpickerLiveSearch" class="form-label">Username</label>
						<select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pengguna baru" required name="pemimpin">
							
						</select>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Assign')"/>
				<x-button type="button" id="remove" class="btn btn-danger d-grid w-100 d-none" onclick="del(this)" href="{{route('m.desa.kades.hapus')}}" :value="__('Hapus Kepala Desa')"/>
			</div>
		</form>
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
	




	<form method="POST" class="d-none" id="delete-form">
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
			
		});
		function del(element) {
		event.preventDefault()
		let form = document.getElementById('delete-form');
		form.setAttribute('action', element.getAttribute('href'));
		$('#AssignRole').modal('hide');
		swalConfirm('Yakin menghapus Kepala Desa ?', `Posisi Kepala Desa akan Kosong`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
		
	</script>
	

<script>
		
	$(document).on('click','.open_modal',function(){
			
			var ajax1 = $.ajax({
				type : 'GET',
				url: "{{route('m.desa.get')}}",
				success: function(msg){
					let data = JSON.parse(msg);
					$('#judulModal').text('Assign Kepala Desa : '+data.desa);
					if(data.pemimpin){
						$('#userLKD').val(data.pemimpin.username);
						$('#remove').removeClass('d-none');
					}
					else{
						$('#userLKD').val('');
						$('#remove').addClass('d-none');
					}
					
					
				},
				error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				
				
			});
			var ajax2 = $.ajax({
				type : 'GET',
				url: "{{route('roles.user-list.pemimpin')}}",
				data: {kode:1},
				success: function(msg){
					$('#selectpickerLiveSearch').selectpicker('destroy');
					$('#selectpickerLiveSearch').html(msg);
					$('#selectpickerLiveSearch').selectpicker('render');
				},
				error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				
				
			});
			$.when(ajax1, ajax2).done(function(data, data1) {
				$('#AssignRole').modal('show');
			});
			
		}); 
			
</script>



@endsection
