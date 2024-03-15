
@extends('layouts.app')
@section('container')
@if(auth()->user()->hasRole('warga')&&!is_null(\App\Models\AnggotaRuta::where('anggota_nik',auth()->user()->nik)->where('hubungan','Kepala Keluarga')->first()))
<div class="card">
	<div class="card-body">
		<div class="mb-4">
			<a href="{{route('pengajuan.warga.kependudukan.index')}}" class="btn btn-dark"> Kembali </a>
			<button data-bs-toggle="modal" data-bs-target="#editRuta" class="btn btn-warning">Ubah Alamat</button>
		</div>
		<div class="card mb-5">
			<div class="card-header">
				<h5>Keterangan Rumah Tangga</h5>
			</div>
		  <div class="card-body">
			
				<div class="mb-2">
					<strong>Alamat : </strong>
					<p>{{$ruta->alamat_domisili}}</p>
				</div>
				<div class="mb-2">
					<strong>Jumlah Anggota : </strong>
					<p>{{$ruta->jumlah_art}}</p>
				</div>
				
		  </div>
		</div>
		@include('components.table')
		
	</div>
</div>
<div class="modal fade" id="editRuta" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulEdit">Edit Rumah Tangga </h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formUpdate" class="mb-3" action="{{route('pengajuan.warga.ruta.update',$ruta)}}" data-remote="true" method="POST">
			@method("PUT")
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="alamat_domisili_edit" :value="__('Alamat Domisili*')" />
					<x-input type="text" name="alamat_domisili" id="alamat_domisili_edit" :placeholder="__('Alamat Domisili Lengkap')" :value="$ruta->alamat_domisili" required/>
					<x-invalid error="alamat_domisili" />
				  </div>
				  
				  
				</div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Rumah Tangga')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

<div class="modal fade" id="editAnggota" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Edit Hubungan</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formEdit" class="mb-3"  data-remote="true" method="POST">
			@method('PUT')
			@csrf
			
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="hubungan_edit" class="form-label">Hubungan</label>
						<select id="hubungan_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih hubungan" name="hubungan" required>
							
						</select>
						<x-invalid error="hubungan" />
					</div>
				</div>

			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Hubungan')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

  <form method="POST" class="d-none" id="delete-form">
	@csrf
	@method("DELETE")
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
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin menghapus anggota rumah tangga ?', `Warga akan dihapus dari rumah tangga`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
	$(document).on('click','.open_modal_hubungan',function(){
		console.log('hai');
	let link= $(this).attr('data-link');
	$('#formEdit').attr('action',link);
	$.ajax({
				type : 'GET',
				url: "{{route('master.ruta.get-hubungan')}}",
				data:{uncheck:[1]},
				beforeSend: function(){
					$('#loading').show();
				},
				complete: function(){
					$('#loading').hide();
				},
				success: function(msg){
					$('#hubungan_edit').selectpicker('destroy');
					$('#hubungan_edit').html(msg);
					$('#hubungan_edit').selectpicker('render');
					$('#editAnggota').modal('show');
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
			});
			
			
			
			
		}); 
  </script>

@endif
@endsection

