  <!-- Modal -->
  <div class="modal  fade" id="dokumenModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Upload Dokumen</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formDokumen" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
					@method('PUT')
					@csrf
					<input type="hidden" id="token" value="{{ csrf_token() }}">
					
					  <div class="row mt-3">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<x-label for="dokumen_kk" :value="__('Upload Kartu Keluarga (.jpg/.png)')"/>
							<x-input class="form-control" type="file" id="dokumen_kk" name="dokumen_kk" />
							<x-invalid error="dokumen_kk" />
							<button class="btn btn-sm btn-primary me-1 mt-2 d-none" id="btn-kk" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKK" aria-expanded="false" aria-controls="collapseKK">
								Lihat KK
							  </button>
						  </div>
						  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<x-label for="dokumen_ktp" :value="__('Upload KTP (.jpg/.png)')"/>
							<x-input class="form-control" type="file" id="dokumen_ktp" name="dokumen_ktp" />
							<x-invalid error="dokumen_ktp" />
							<button class="btn btn-sm btn-primary me-1 mt-2 d-none" type="button" id="btn-ktp" data-bs-toggle="collapse" data-bs-target="#collapseKTP" aria-expanded="false" aria-controls="collapseKTP">
								Lihat KTP
							  </button>
						  </div>
						  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<x-label for="foto" :value="__('Upload Foto (.jpg/.png)')"/>
							<x-input class="form-control" type="file" id="foto" name="foto" />
							<x-invalid error="foto" />
							<button class="btn btn-sm btn-primary me-1 mt-2 d-none" type="button" id="btn-foto" data-bs-toggle="collapse" data-bs-target="#collapseFoto" aria-expanded="false" aria-controls="collapseFoto">
								Lihat Foto
							  </button>
						  </div>

					  </div>
					  <div class="row mt-3">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="collapse" id="collapseKK">
								<div class="p-3 border" id="kk_view">
								  
								  
							  </div>
						  </div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="collapse" id="collapseKTP">
								<div class="p-3 border" id="ktp_view">
								  
								  
							  </div>
						  </div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="collapse" id="collapseFoto">
								<div class="p-3 border" id="foto_view">
								  
								  
							  </div>
						  </div>
						</div>
					 
				 
						  
					  </div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Upload dokumen')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

     



@push('js')
<script>
	$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
	$(document).on('click','.open_modal_dokumen',function(){
				let nik= $(this).attr('data-dokumen');
				let link= $(this).attr('data-link');
				$('#formDokumen').attr('action',link);
				$('#dokumenModal').modal('show');
				$.ajax({
					type : 'POST',
					url: "{{route('profil.warga.get-dokumen')}}",
					data: {nik:nik},
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
					success: function(msg){
						let data = JSON.parse(msg);
						
						if(data.dokumen_kk){
							$('#kk_view').html('<label class="form-label">KK Saat Ini</label><div class="d-flex mb-3 w-100" ><img class="object-fit-fill w-100" src="/storage/' + data.dokumen_kk + '"/></div>');
							$('#btn-kk').removeClass('d-none');
						}
						else{
							$('#btn-kk').addClass('d-none');
						}
						if(data.dokumen_ktp){
							$('#ktp_view').html('<label class="form-label">KTP Saat Ini</label><div class="d-flex mb-3 w-100"><img class="object-fit-fill w-100" src="/storage/' + data.dokumen_ktp + '"/></div>');
							$('#btn-ktp').removeClass('d-none');
						}
						else{
							$('#btn-ktp').addClass('d-none');
						}
						if(data.foto){
							$('#foto_view').html('<label class="form-label">Foto Saat Ini</label><div class="d-flex mb-3 w-100"><img class="object-fit-fill w-100" src="/storage/' + data.foto + '"/></div>');
							$('#btn-foto').removeClass('d-none');
						}
						else{
							$('#btn-foto').addClass('d-none');
						}
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				
				
			
				
			}); 
</script>
@endpush


