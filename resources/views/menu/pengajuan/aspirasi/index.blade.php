@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Manajemen Aspirasi') }}
			</h5>

			<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addAspirasi">
				Ajukan Aspirasi!
			  </button>

			  <!-- Modal -->
  <div class="modal fade" id="addAspirasi" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Ajukan Aspirasi!</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action=" {{route('pengajuan.warga.aspirasi.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="judul" :value="__('Judul')" />
					<x-input type="text" name="judul" id="judul" :placeholder="__('Judul')" :value="old('judul')" autofocus />
					<x-invalid error="judul" />
				  </div>
				  
				  
				</div>
				<div class="row g-2 mb-3">
					<label class="form-label">Kategori & Tujuan</label>
					<div class="col">
						<select id="category" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Kategori" name="kategori" required>
							
						</select>
						<x-invalid error="kategori" />
					</div>
					<div class="col">
						<select id="tingkat" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Tujuan" name="tingkat" required>
							<option value="desa">Desa</option>
    						<option value="dusun">Dusun</option>
							<option value="RW">RW</option>
							<option value="RT">RT</option>
						</select>
						<x-invalid error="tingkat" />
					</div>
				</div>
				<div class="row ">
					<div class="col mb-3">
						<x-label for="isi" :value="__('Isi Aspirasi')" />
						<input id="isi" type="hidden" name="isi" required :value="old('isi')">
						<trix-editor input="isi"></trix-editor>
					</div>
				</div>
				<div class="row ">
					<div class="col mb-3">
						<x-label for="lampiran" :value="__('Lampiran')" />
						<input type="file" class="form-control" id="lampiran" name="lampiran">
						<x-invalid error="lampiran" />
					</div>
				</div>

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ajukan Aspirasi')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

			@include('components.table')

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
					url: "{{route('master.aspirasi.get-kategori')}}",
					
					success: function(msg){
						$('#category').selectpicker('destroy');
						$('#category').html(msg);
						$('#category').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		
	});
	
		
		
	</script>


@endsection
