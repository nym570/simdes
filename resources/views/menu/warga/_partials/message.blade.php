  <!-- Modal -->
  <div class="modal  fade" id="messageModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Kirim Pesan</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formMessage" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf
					
					<div>
						<label for="exampleFormControlTextarea1" class="form-label">Pesan</label>
						<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
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

     



@push('js')
<script>

	$(document).on('click','.open_modal_message',function(){
				let link= $(this).attr('data-link');
				$('#formMessage').attr('action',link);
				$('#messageModal').modal('show');
				
			}); 
</script>
@endpush


