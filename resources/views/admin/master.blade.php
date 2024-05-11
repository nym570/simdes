@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{$title}}
			</h5>

			<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addInfo">
				Tambah Kategori
			  </button>

			  <!-- Modal -->
  <div class="modal fade" id="addInfo" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Kategori</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action=" {{$link}}" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="nama" :value="__('Nama*')" />
					<x-input type="text" name="name" id="name" :placeholder="__('Nama')" :value="old('name')" autofocus />
					<x-invalid error="name" />
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

		
  
  
		
			  @include('components.table')
		</div>
	</div>
	<!-- Modal -->
<div class="modal fade" id="editKategori" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulEdit">Edit Kategori</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formUpdate" class="mb-3" action="" data-remote="true" method="POST">
			@method("PUT")
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="nama_edit" :value="__('Nama*')" />
					<x-input type="text" name="name" id="name_edit" :value="old('name')" required/>
					<x-invalid error="name" />
				  </div>
				  
				  
				</div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Kategori')"/>
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
		swalConfirm('Yakin hapus kategori ?', `Kategori yang dihapus tidak dapat dipulihkan`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
</script>

<script>
    $(document).on('click','.open_modal',function(){
				var ajax1= $.ajax({
					type : 'GET',
					url: $(this).attr('data-link'),
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
					success: function(msg){
						let data = JSON.parse(msg);
                        $('#name_edit').val(data['name']);
                        $('#formUpdate').attr('action',data['link'] );
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
				$.when(ajax1).done(function(data, data1) {
				$('#editKategori').modal('show');
			});
				}); 
                
  </script>

@endsection
