<!-- Modal -->
<div class="modal fade" id="editRuta" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulEdit">Edit Rumah Tangga Baru</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formUpdate" class="mb-3" action="" data-remote="true" method="POST">
			@method("PUT")
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="alamat_domisili_edit" :value="__('Alamat Domisili*')" />
					<x-input type="text" name="alamat_domisili" id="alamat_domisili_edit" :placeholder="__('Alamat Domisili Lengkap')" :value="old('alamat_domisili')" required/>
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
						 $('#judulEdit').text('Edit Rumah Tangga');
                        $('#alamat_domisili_edit').val(data['ruta']['alamat_domisili']);
                        $('#formUpdate').attr('action',data['keterangan']['link'] );
                        
                       

                        
                        
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
				$.when(ajax1).done(function(data, data1) {
				$('#editRuta').modal('show');
			});
				}); 
                
  </script>