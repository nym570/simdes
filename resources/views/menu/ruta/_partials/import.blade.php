  <!-- Modal -->
  <div class="modal fade" id="importExcel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Import dari Excel</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				
				<form id="formAuthentication" class="mb-3" action="{{ route('ruta.import') }}" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" id="token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="col mt-3">
							<a href="/import_format/ruta.xlsx" download>Download Format Excel Ruta</a>
							<x-label for="import" :value="__('Upload File Ruta .xlsx')"/>
							<x-input class="form-control" type="file"  name="ruta" />
							<x-invalid error="ruta" />
						  </div>
					  </div>
					  <div class="row">
						<div class="col mt-3">
							<a href="/import_format/anggota.xlsx" download>Download Format Excel Anggota Ruta</a>
							<x-label for="import" :value="__('Upload File Anggota Ruta .xlsx')"/>
							<x-input class="form-control" type="file"  name="anggota" />
							<x-invalid error="anggota" />
						  </div>
					  </div>
				
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


