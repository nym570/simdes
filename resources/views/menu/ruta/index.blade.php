
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Rumah Tangga') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->

@if(in_array('rt',auth()->user()->roles->pluck('status')->toArray()))
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addRuta">
	Tambah Rumah Tangga
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
				<div id = "domisili" class="row g-2 mb-3 {{in_array('rt',auth()->user()->roles->pluck('status')->toArray())?'d-none':''}}">
					<div class="col">
						<label for="rw_id" class="form-label">RW*</label>
						<select id="rw_id" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih RW" name="rw_id" {{in_array('rt',auth()->user()->roles->pluck('status')->toArray())?'':'required'}}>
							
						</select>
						<x-invalid error="rw" />
					</div>
					<div class="col">
						<label for="rt_id" class="form-label">RT*</label>
						<select id="rt_id" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih RT" name="rt_id" {{in_array('rt',auth()->user()->roles->pluck('status')->toArray())?'':'required'}}>
							
						</select>
						<x-invalid error="rt_id" />
					</div>
				</div>
				
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

  
@include('menu.ruta._partials.edit')
@endif
  

			</div>

			@include('menu.ruta._partials.table')

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
		if(!$('#domisili').hasClass('d-none')){
			$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rw')}}",
					success: function(msg){
						$('#rw_id').selectpicker('destroy');
						$('#rw_id').html(msg);
						$('#rw_id').selectpicker('render');
						$('#rw_edit').selectpicker('destroy');
						$('#rw_edit').html(msg);
						$('#rw_edit').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		}
		
		
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
	$('#rw_id').on('change',function(){
				$('#rw_id').selectpicker('render');
				let id_rw = $('#rw_id').val();

				$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rt')}}",
					
					data : {id:id_rw},

					success: function(msg){
						$('#rt_id').selectpicker('destroy');
						$('#rt_id').html(msg);
						$('#rt_id').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
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

