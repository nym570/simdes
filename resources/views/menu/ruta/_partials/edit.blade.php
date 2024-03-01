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
				<div class="row g-2 mb-3 {{in_array('rt',auth()->user()->roles->pluck('status')->toArray())?'d-none':''}}">
					<div class="col">
						<label for="rw_edit" class="form-label">RW*</label>
						<select id="rw_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" name="rw_id" {{in_array('rt',auth()->user()->roles->pluck('status')->toArray())?'':'required'}}>
							
						</select>
						<x-invalid error="rw_id" />
					</div>
					<div class="col">
						<label for="rt_edit" class="form-label">RT*</label>
						<select id="rt_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true"  name="rt_id" {{in_array('rt',auth()->user()->roles->pluck('status')->toArray())?'':'required'}}>
							
						</select>
						<x-invalid error="rt_id" />
					</div>
				</div>
				
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
					url: $(this).val(),
					success: function(msg){
						let data = JSON.parse(msg);
						 $('#judulEdit').text('Edit Rumah Tangga');
                        $('#rw_edit').val(data['keterangan']['rw_id']);
                        $('#rw_edit').selectpicker("refresh");
                        $('#rw_edit').trigger('change');
                        $('#rw_edit').selectpicker("render");
                        $('#alamat_domisili_edit').val(data['ruta']['alamat_domisili']);
                        $('#rt_edit').val(data['ruta']['rt_id']);
                        $('#rt_edit').selectpicker("refresh");
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
                $('#rw_edit').on('change',function(){
				$('#rw_edit').selectpicker('render');
				let id_rw = $('#rw_edit').val();

				$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rt')}}",
					
					data : {id:id_rw},

					success: function(msg){
						$('#rt_edit').selectpicker('destroy');
						$('#rt_edit').html(msg);
						$('#rt_edit').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
		});
  </script>