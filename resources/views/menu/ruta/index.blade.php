
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Rumah Tangga') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->

@if(auth()->user()->hasRole('ketua rt'))
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addRuta">
	Tambah Rumah Tangga
  </button>
  <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#importExcel">
	Import Excel
  </button>


  
  
  <!-- Modal -->
  <div class="modal fade" id="addRuta" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Tambah Rumah Tangga Baru</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('ruta.store') }}" data-remote="true" method="POST">
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="alamat_domisili" :value="__('Alamat Domisili*')" />
					<x-input type="text" name="alamat_domisili" id="alamat_domisili" :placeholder="__('Alamat Domisili Lengkap')" :value="old('alamat_domisili')" required/>
					<x-invalid error="alamat_domisili" />
				  </div>
				  
				  
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="kepala_ruta" class="form-label">Kepala Rumah Tangga</label>
						<select id="kepala_ruta" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Kepala Rumah Tangga" name="kepala_ruta" required>
							
						</select>
						<x-invalid error="kepala_ruta" />
					</div>
				</div>
				
				

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Rumah Tangga')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

@include('menu.ruta._partials.import')
@include('menu.ruta._partials.edit')
@endif
  

			</div>

			@include('components.table')

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
		
		
		
				$.ajax({
					type : 'GET',
					url: "{{route('get-warga-nonruta')}}",
					
					success: function(msg){
						$('#kepala_ruta').selectpicker('destroy');
						$('#kepala_ruta').html(msg);
						$('#kepala_ruta').selectpicker('render');
						
						
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
		swalConfirm('Yakin menghapus rumah tangga ?', `Data rumah tangga akan terhapus, namun data warga tetap ada`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
</script>



@endsection

