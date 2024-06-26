  <!-- Modal -->
  <div class="modal fade" id="importExcel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Import dari Excel</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<a href="{{$import['format']}}" download>Download Format Excel</a>
				<a href="{{$import['csv']}}" download>Download Format csv</a>
				<form id="formAuthentication" class="mb-3" action="{{ $import['link'] }}" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" id="token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="col mt-3">
							<x-label for="import" :value="__('Upload File .xlsx')"/>
							<x-input class="form-control" type="file" id="import" name="import" required/>
							<x-invalid error="import" />
						  </div>
					  </div>
					  <small>Disarankan menggunakan .csv untuk import lebih cepat</small>
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Import')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

     



@push('js')

@endpush


