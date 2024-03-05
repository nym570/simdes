@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Perangkat Pemerintahan Desa') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPemerintahan">
	Tambah Perangkat
  </button>

  <!-- Modal -->
  <div class="modal fade" id="addPemerintahan" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Tambah Perangkat Desa</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('m.pemerintahan.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" id="token" value="{{ csrf_token() }}">
			<div class="modal-body">
				<div class="row mb-3">
					<div class="col">
						<label for="nik" class="form-label">NIK Perangkat</label>
						<select id="nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih NIK" name="nik" required>
							
						</select>
						<x-invalid error="nik" />
					</div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="jabatan" :value="__('Jabatan*')" />
					<x-input type="text" name="jabatan" id="jabatan" :placeholder="__('Nama Jabatan')" :value="old('jabatan')" required/>
					<x-invalid error="jabatan" />
				  </div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<label for="tugas" class="form-label">Tugas*</label>
					<input id="tugas" type="hidden" name="tugas" value="{{old('tugas')}}" required>
					<trix-editor input="tugas" ></trix-editor>
				  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
					  <label for="wewenang" class="form-label">Wewenang*</label>
					  <input id="wewenang" type="hidden" name="wewenang" value="{{old('wewenang')}}" required>
					  <trix-editor input="wewenang" ></trix-editor>
					</div>
				  </div>

				  <div class="row">
					<div class="col mb-3">
						<x-label for="foto" :value="__('Foto (.png/.jpg)*')"/>
						<x-input class="foto" type="file" id="foto" name="foto" required/>
						<x-invalid error="foto" />
					  </div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Perangkat')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>
			</div>

			@include('admin.components.table')

			<!-- Modal -->
  <div class="modal fade" id="editPemerintahan" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Edit Perangkat Desa</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formEdit" class="mb-3" action="" data-remote="true" method="POST" enctype="multipart/form-data">
			@method('PUT')
			@csrf
			<input type="hidden" id="token" value="{{ csrf_token() }}">
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
					  <x-label for="nik_current" :value="__('Perangkat Saat Ini')" />
					  <x-input type="text" name="nik_current" id="nik_current"  readonly required/>
					  <x-invalid error="nik_current" />
					</div>
				  </div>
				<div class="row mb-3">
					<div class="col">
						<label for="edit_nik" class="form-label">NIK Perangkat Baru</label>
						<select id="edit_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih jika berubah" name="nik">
							
						</select>
						<x-invalid error="nik" />
					</div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="edit_jabatan" :value="__('Jabatan*')" />
					<x-input type="text" name="jabatan" id="edit_jabatan" :placeholder="__('Nama Jabatan')" :value="old('jabatan')" required/>
					<x-invalid error="jabatan" />
				  </div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<label for="edit_tugas" class="form-label">Tugas*</label>
					<input id="edit_tugas" type="hidden" name="tugas" value="{{old('tugas')}}" required>
					<trix-editor input="edit_tugas" id="x_t"></trix-editor>
				  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
					  <label for="edit_wewenang" class="form-label">Wewenang*</label>
					  <input id="edit_wewenang" type="hidden" name="wewenang" value="{{old('wewenang')}}" required>
					  <trix-editor input="edit_wewenang" id="x_w"></trix-editor>
					</div>
				  </div>
				  <div class="row" id="foto_current">
				  </div>
				  <div class="row d-none">
					<div class="col mb-3">
					  <x-input type="text" name="current_foto_path" id="current_foto_path" />
					</div>
				  </div>
				  <div class="row">
					<div class="col mb-3">
						<x-label for="foto" :value="__('Ubah Foto (.png/.jpg)')"/>
						<x-input class="foto" type="file" id="foto" name="foto"/>
						<x-invalid error="foto" />
					  </div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Perangkat')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

		</div>
	</div>

	<!-- Modal -->
<div class="modal fade" id="modalPemerintahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="jabatan-pem"></h4>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<div class="modal-body">
		<div class="mb-3" id="biodata">

		</div>
		  <div class="mb-3" id="tugas-pem">

		  </div>
		  <div class="mb-3" id="wewenang-pem">

		  </div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
  </div>

  <form method="POST" class="d-none" id="delete-form">
	@csrf
	@method("DELETE")
</form>

@if (count($errors) > 0)
    <script type="text/javascript">
	
        $( document ).ready(function() {
			
             $('#addPemerintahan').modal('show');
        });

    </script>
@endif
@push('js')
<script>
	$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
				$.ajax({
					type : 'GET',
					url: "{{route('get-warga')}}",
					data: {tujuan:"pemerintahan"},
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
		
	});
</script>

<script>
	function del(element) {
		event.preventDefault()
		let form = document.getElementById('delete-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin Perangkat Desa ?', `Data perangkat desa tidak dapat dipulihkan`, 'Ya! Hapus', () => {
			form.submit()
		})
	}

	$(document).on('click','.open_modal_edit',function(){
				let id= $(this).attr('data-pemerintahan');
				let link= $(this).attr('data-link');
				$('#foto_current').empty();
				var ajax1 = $.ajax({
					type : 'GET',
					url: "{{route('get-warga')}}",
					data: {tujuan:"pemerintahan"},
					success: function(msg){
						$('#edit_nik').selectpicker('destroy');
						$('#edit_nik').html(msg);
						$('#edit_nik').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				var ajax2 = $.ajax({
					type : 'GET',
					url: "{{route('pemerintahan.get')}}",
					data : {id:id},
					success: function(msg){
						let data = JSON.parse(msg);
						$('#nik_current').val(data.nik);
						$('#edit_jabatan').val(data.jabatan);
						$('#x_t').val(data.tugas);
						$('#x_w').val(data.wewenang);
						
						$('#current_foto_path').val(data.foto);
						$('#formEdit').attr('action',link);
						$('#foto_current').append('<label class="form-label">Foto Saat Ini</label><div class="d-flex mb-3" style="height:150px"><img class="object-fit-fill" src="/storage/' + data.foto + '"/></div>');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$.when(ajax1, ajax2).done(function(data, data1) {
				$('#editPemerintahan').modal('show');
			});
				
			}); 

			$(document).on('click','.open_modal_pemerintahan',function(){
			$('#biodata').empty();
				$('#jabatan-pem').empty();
				$('#tugas-pem').empty();
				$('#wewenang-pem').empty();
				let id= $(this).val();
				$.ajax({
					type : 'GET',
					url: "{{route('pemerintahan.get')}}",
					data : {id:id},
					success: function(msg){
						
						let data = JSON.parse(msg);
						
						$('#biodata').append('<div class="d-flex justify-content-center mb-3" style="height:150px"><img class="object-fit-fill" src="/storage/' + data.foto + '"/></div>');
						$('#biodata').append('<p class="text-center"><strong>'+data.warga.nama+'</strong></p>');
						$('#biodata').append('<p class="text-muted text-center">'+data.warga.nik+'</p>');
						$('#jabatan-pem').append(data.jabatan);
						$('#tugas-pem').append('<h5>Tugas</h5>');
						$('#tugas-pem').append(data.tugas);
						$('#wewenang-pem').append('<h5>Wewenang</h5>');
						$('#wewenang-pem').append(data.wewenang);
						$('#modalPemerintahan').modal('show');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
			}); 
</script>
@endpush



@endsection

