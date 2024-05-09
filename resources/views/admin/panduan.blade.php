@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Manajemen Panduan') }}
			</h5>

			<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addInfo">
				Buat Panduan
			  </button>

			  <!-- Modal -->
  <div class="modal fade" id="addInfo" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Panduan</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action=" {{route('admin.panduan.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="judul" :value="__('Judul')" />
					<x-input type="text" name="judul" id="judul" :placeholder="__('Judul')" :value="old('judul')" autofocus />
					<x-invalid error="judul" />
				  </div>
				  
				  
				</div>
				<div class="row mb-3">
					<label class="form-label">Kategori</label>
					<div class="col">
						
						<select id="category" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Kategori" name="kategori" required>
							
						</select>
						<x-invalid error="kategori" />
					</div>
					
				</div>
				<div class="row ">
					<div class="col mb-3">
						<x-label for="keterangan" :value="__('Ringkasan & Keterangan')" />
						<input id="keterangan" type="hidden" name="keterangan" required :value="old('keterangan')">
						<trix-editor input="keterangan"></trix-editor>
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
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Submit')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

		
  
  
			<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title" id="judulView"></h4>
					  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body" id="isi">
						
					<div class="mb-3" id="textIsi">
			
					</div>
					  <div class="mb-3" id="pdfIsi">
					  </div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
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
					url: "{{route('master.panduan.get-kategori')}}",
					
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
	$(function() {
		$(document).on('click','.open_modal_info',function(){
			$('#textIsi').empty();
				$('#pdfIsi').empty();
				$('#judulModal').empty();
				let route= $(this).val();
				let pdf = $(this).attr("data-pdf");
				$.ajax({
					type : 'GET',
					url: route,
					success: function(msg){
						
						let data = JSON.parse(msg);
						$('#judulView').text(data.judul);
						if(data.lampiran){
							$("#pdfIsi").append('<iframe id="pdfIsi" src="'+pdf+'" width="100%" height="1000px"></iframe>');
							
						}
						if(data.keterangan){
							$('#textIsi').append('<h5>Ringkasan</h5>');
							$('#textIsi').append(data.keterangan);
						}
						$('#modalInfo').modal('show');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
			}); 	
	});
	
		
	</script>
<script>
	function change(element) {
	event.preventDefault()
	let form = document.getElementById('status-form');
	form.setAttribute('action', element.getAttribute('href'))
	swalConfirm('Ubah Status Informasi Publik ?', `Status informasi publik akan diubah`, 'Ubah', () => {
		form.submit()
	})
}

function del(element) {
		event.preventDefault()
		let form = document.getElementById('delete-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin hapus informasi publik ?', `Data yang dihapus tidak dapat dipulihkan`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
</script>

@endsection
