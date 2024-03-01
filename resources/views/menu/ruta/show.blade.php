@extends('layouts.app')
@section('container')

	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Anggota Rumah Tangga') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
				<a href="{{route('ruta.index')}}" class="btn btn-dark"> Kembali </a>
@if(in_array('rt',auth()->user()->roles->pluck('status')->toArray()))
<button type="button" class="btn btn-primary" id="buttonAdd">
	Tambah Anggota
  </button>
 


  
  
  <!-- Modal -->
  <div class="modal fade" id="addAnggota" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Tambah Anggota Rumah Tangga Baru</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('ruta.anggota.store',$ruta) }}" data-remote="true" method="POST">
			@csrf
			
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="anggota_nik" class="form-label">Anggota</label>
						<select id="anggota_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Anggota Rumah Tangga Baru" name="anggota_nik" required>
							
						</select>
						<x-invalid error="anggota_nik" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="hubungan" class="form-label">Hubungan</label>
						<select id="hubungan" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih hubungan" name="hubungan" required>
							
						</select>
						<x-invalid error="hubungan" />
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
  @if(is_null($kepala)||$ruta->jumlah_art>1)

  <button type="button" class="btn btn-warning" id="buttonKepala">
	Ganti Kepala Keluarga
  </button>
  <!-- Modal -->
  <div class="modal fade" id="updateKepala" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Ganti Kepala Rumah Tangga</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('ruta.anggota.update-kepala',$ruta) }}" data-remote="true" method="POST">
			@csrf
			
			<div class="modal-body">
				@if($kepala)
				<div class="row g-2 mb-3">
					<label  class="form-label">Kepala Rumah Tangga Lama</label>
					<div class="col">
						<x-label for="nik_lama" :value="__('NIK')" />
						<x-input type="text" name="nik_lama" id="nik_lama"  value="{{$kepala}}" readonly required/>
						<x-invalid error="nik_lama" />
					  </div>
					<div class="col">
						<x-label for="hubungan_lama" :value="__('hubungan')" />
						<select id="hubungan_lama" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Hubungan Baru" name="hubungan_lama" required>
							
						</select>
						<x-invalid error="hubungan_lama" />
					</div>
					
				</div>
				@endif
				
				<div class="row">
					<div class="col mb-3">
						<label for="kepala_nik" class="form-label">Kepala Rumah Tangga Baru</label>
						<select id="kepala_nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Kepala Rumah Tangga Baru" name="kepala_nik" required>
							
						</select>
						<x-invalid error="kepala_nik" />
					</div>
				</div>

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ganti Kepala Rumah Tangga')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>
@endif

			
			<form method="POST" class="d-none" id="delete-form">
				@csrf
				@method("DELETE")
			</form>
			@endif	
		</div>	
			@include('menu.warga._partials.table')

		</div>
	</div>
	
	<script>
		
		$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
	$('#buttonAdd').on('click',function(){
		
		var ajax1=$.ajax({
					type : 'GET',
					url: "{{route('get-warga-nonruta')}}",
					success: function(msg){
						$('#anggota_nik').selectpicker('destroy');
						$('#anggota_nik').html(msg);
						$('#anggota_nik').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				var ajax2=$.ajax({
					type : 'GET',
					url: "{{route('master.ruta.get-hubungan')}}",
					data:{uncheck:[1]},
					success: function(msg){
						$('#hubungan').selectpicker('destroy');
						$('#hubungan').html(msg);
						$('#hubungan').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$.when(ajax1, ajax2).done(function(data, data1) {
				$('#addAnggota').modal('show');
			});
		
	});
	$('#buttonKepala').on('click',function(){
		
		var ajax1=$.ajax({
					type : 'POST',
					url: "{{route('ruta.anggota-get')}}",
					data:{id:<?=$ruta->id?>},
					success: function(msg){
						$('#kepala_nik').selectpicker('destroy');
						$('#kepala_nik').html(msg);
						$('#kepala_nik').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				var ajax2=$.ajax({
					type : 'GET',
					url: "{{route('master.ruta.get-hubungan')}}",
					data:{uncheck:1},
					success: function(msg){
						$('#hubungan_lama').selectpicker('destroy');
						$('#hubungan_lama').html(msg);
						$('#hubungan_lama').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$.when(ajax1, ajax2).done(function(data, data1) {
				$('#updateKepala').modal('show');
			});
		
	});
	
		
	</script>
<script>
	function del(element) {
		event.preventDefault()
		let form = document.getElementById('delete-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin menghapus anggota rumah tangga ?', `Warga akan dihapus dari rumah tangga`, 'Ya! Hapus', () => {
			form.submit()
		})
	}
</script>

@endsection
