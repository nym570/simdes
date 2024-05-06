@extends('layouts.app')
@section('container')
@if (session()->has('url'))
    <script>
        window.open('{{session()->get('url')}}', "_blank");
    </script>
@endif
<div class="card">
	<div class="card-body">
		<h5 class="card-title">
			{{ __('Jenis Layanan Tersedia') }}
		</h5>
		<div class="row row-cols-2 row-cols-lg-4 g-4">
			
			<div class="col">
				<div class="card text-center h-100">
				  <div class="card-body">
					<i class='bx bx-home bx-lg'></i>
					<h5 class="card-title">Surat Keterangan Domisili</h5>
					<p class="card-text mb-0">syarat pengajuan: </p>
					<p class="card-text">(1) scan kk, (2) scan ktp, (3) foto</p>
					<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDomisili">
						Ajukan!
					  </button>
				  </div>
				</div>
			 </div>
			 <div class="col">
				<div class="card text-center  h-100">
				  <div class="card-body">
					<i class='bx bx-money bx-lg'></i>
					<h5 class="card-title">Surat Keterangan Umum</h5>
					<p class="card-text mb-0">syarat pengajuan:</p>
					<p class="card-text">(1) scan kk, (2) scan ktp, (3) foto</p>
					<button type="button" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#addUmum">
						Ajukan!
					  </button>
				  </div>
				</div>
			 </div>

		@include('menu.suket._partials.suket.domisili')
		@include('menu.suket._partials.suket.umum')
		<script>
			$( document ).ready(function() {
					$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
			});
			$.ajax({
					type : 'GET',
					url: "{{route('get-warga-ruta')}}",
					success: function(msg){
						$('#nik_umum').selectpicker('destroy');
						$('#nik_umum').html(msg);
						$('#nik_umum').selectpicker('render');
						$('#nik_domisili').selectpicker('destroy');
						$('#nik_domisili').html(msg);
						$('#nik_domisili').selectpicker('render');
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				$(function(){
			$('#nik_umum').on('change',function(){
				let nik = $('#nik_umum').val();
				$.ajax({
						type : 'POST',
						url: "{{route('warga.get-dokumen')}}",
						data : {'nik':nik},
						success: function(msg){
							let data = JSON.parse(msg);
						
						if(data.dokumen_kk==null){
							$('#umumDokumenKK').removeClass('d-none');
						}
						else{
							$('#umumDokumenKK').addClass('d-none');
						}
						if(data.dokumen_ktp==null){
							$('#umumDokumenKTP').removeClass('d-none');
						}
						else{
							$('#umumDokumenKTP').addClass('d-none');
						}
						if(data.foto==null){
							$('#umumDokumenFOTO').removeClass('d-none');
						}
						else{
							$('#umumDokumenFOTO').addClass('d-none');
						}
							
						},
						error: function (xhr) {
							var err = JSON.parse(xhr.responseText);
							alert(err.message);
						}
						
					})
			});
			$('#nik_domisili').on('change',function(){
				let nik = $('#nik_domisili').val();
				
				$.ajax({
						type : 'POST',
						url: "{{route('warga.get-dokumen')}}",
						data : {'nik':nik},
						success: function(msg){
							let data = JSON.parse(msg);
							if(data.dokumen_kk==null){
							$('#domisiliDokumenKK').removeClass('d-none');
						}
						else{
							$('#domisiliDokumenKK').addClass('d-none');
						}
						if(data.dokumen_ktp==null){
							$('#domisiliDokumenKTP').removeClass('d-none');
						}
						else{
							$('#domisiliDokumenKTP').addClass('d-none');
						}
						if(data.foto==null){
							$('#domisiliDokumenFOTO').removeClass('d-none');
						}
						else{
							$('#domisiliDokumenFOTO').addClass('d-none');
						}
							
						},
						error: function (xhr) {
							var err = JSON.parse(xhr.responseText);
							alert(err.message);
						}
						
					})
			});
			
		})
		</script>
		
	</div>
</div>

	<div class="card mt-3">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Manajemen Surat Keterangan') }}
			</h5>

			@include('components.table')
			@include('menu.suket._partials.message')

		</div>
	</div>
	<div class="modal  fade" id="umumModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabelUmum">Konfirmasi Surat Keterangan Umum</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
				<div class="modal-body">
					<form id="formUmum" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<h6><strong>Keterangan yang perlu dimuat</strong></h6>
						<div class="p-3 border mb-3" id="keterangan">
									  
									  
						</div>

						<div class="row ">
							<div class="col mb-3">
								<label for="keterangan" class="form-label"><strong>Tulis Keterangan pada surat</strong></label>
								<input id="x" type="hidden" name="keterangan" >
								<trix-editor input="x" ></trix-editor>
							  <x-invalid error="keterangan" />
							</div>
						  </div>
					
				  </div>
				  <div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Kirim Pesan')"/>
				  </div>
				</form>
			</form>
		  </div>
		</div>
	  </div>

	<form method="POST" class="d-none" id="status-form">
		@csrf
		@method("PUT")
	</form>

	  <!-- Modal -->
	  <div class="modal  fade" id="dokumenModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel1">Lihat Lampiran Surat Keterangan</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
				<div class="modal-body">
					<div class="mt-3" id="file">

					</div>
					<div class="divider divider-dashed mt-3">
						<div class="divider-text">Persyaratan</div>
					  </div>
						  <div class="row mt-3">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div>
									<h6>Dokumen KK</h6>
									<div class="p-3 border" id="kk_view">
									  
									  
								  </div>
							  </div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div>
									<h6>Dokumen KTP</h6>
									<div class="p-3 border" id="ktp_view">
									  
									  
								  </div>
							  </div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div>
									<h6>Dokumen Foto</h6>
									<div class="p-3 border" id="foto_view">
									  
									  
								  </div>
							  </div>
							</div>
						 
					 
							  
						  </div>
					
				  </div>
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
		});
		$(document).on('click','.open_modal_lihat',function(){
					let nik= $(this).attr('data-dokumen');
					let suket= $(this).attr('data-suket');
					$('#file').empty();
					$('#dokumenModal').modal('show');
					if(suket){
						$('#file').html('<div class="divider divider-dashed mt-3 mb-2"><div class="divider-text" >Dokumen Suket</div></div> <iframe src ="'+suket+'" width="100%" height="600px"></iframe>');
					}
					$.ajax({
						type : 'POST',
						url: "{{route('warga.get-dokumen')}}",
						data: {nik:nik},
						beforeSend: function(){
							$('#loading').show();
						},
						complete: function(){
							$('#loading').hide();
						},
						success: function(msg){
							let data = JSON.parse(msg);

								$('#kk_view').html('<div class="d-flex mb-3 w-100" ><img class="object-fit-fill w-100" src="/storage/' + data.dokumen_kk + '"/></div>');
								$('#ktp_view').html('<div class="d-flex mb-3 w-100"><img class="object-fit-fill w-100" src="/storage/' + data.dokumen_ktp + '"/></div>');
								$('#foto_view').html('<div class="d-flex mb-3 w-50"><img class="object-fit-fill w-100" src="/storage/' + data.foto + '"/></div>');
							
							
						},
						error: function (xhr) {
							var err = JSON.parse(xhr.responseText);
							alert(err.message);
						}
					});
					
					
				
					
				}); 
	</script>

	
	
	
	<script>
		function change(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Verifikasi Pengajuan Surat Keterangan ?', `Pengajuan Surat Keterangan yang telah di verifikasi tidak dapat dibatalkan`, 'verifikasi', () => {
			form.submit()
		})
	}
	function selesai(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'));
		swalConfirm('Surat Keterangan telah diambil dan proses selesai ?', `Pengajuan Surat Keterangan yang telah selesai tidak dapat dibatalkan`, 'selesaikan', () => {
			form.submit()
		})
	}
	$(document).on('click','.open_modal_umum',function(){
				let link= $(this).attr('data-link');
				let keterangan= $(this).attr('data-keterangan');
				$('#keterangan').html(keterangan);
				$('#formUmum').attr('action',link);
				$('#umumModal').modal('show');
				
			}); 
	</script>
@endsection