
			
	<!-- Create App Modal -->
	<div class="modal fade" id="addDomisili" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg ">
		  <div class="modal-content p-2 p-md-4">
			<div class="modal-header">
				<h5 class="modal-title" id="judulModal">Surat Keterangan Domisili</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			
			  <form id="formAuthentication" class="mb-3" action="{{ route('suket.domisili.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@csrf

					<x-input class="d-none" type="text" name="jenis"  value="domisili"/>
					
				<div class="modal-body">
					<div class="row  mb-3">
						<div class="col">
							<label for="nik_domisili" class="form-label">Warga*</label>
							<select id="nik_domisili" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Warga" name="nik" required>
								
							</select>
							<x-invalid error="nik" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
							<label for="tingkat" class="form-label">Tingkat Surat*</label>
							<select  class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih tingkat surat keterangan" name="tingkat" required>
								<option value="desa">Desa</option>
								<option value="rw">RW</option>
								<option value="rt">RT</option>
							</select>
							<x-invalid error="tingkat" />
						</div>
					</div>
					<div class="row ">
						<div class="col mb-3">
							<x-label for="keperluan" :value="__('Keperluan*')" />
						<x-input type="text" name="keperluan"  :placeholder="__('Keperluan meminta suket')" :value="old('keperluan')" required/>
						<x-invalid error="keperluan" />
						</div>
					  </div>
					
					  <div class="row" id="domisiliDokumenKK" class="d-none">
						<div class="col mb-3">
							<x-label for="dokumen_kk" :value="__('Upload Kartu Keluarga (.jpg/.png)')"/>
							<x-input class="form-control" type="file"  name="dokumen_kk" />
							<x-invalid error="dokumen_kk" />
						  </div>
					  </div>
					<div class="row" id="domisiliDokumenKTP" class="d-none">
						<div class="col mb-3">
							<x-label for="dokumen_ktp" :value="__('Upload KTP (.jpg/.png)')"/>
							<x-input class="form-control" type="file"  name="dokumen_ktp" />
							<x-invalid error="dokumen_ktp" />
						  </div>
					  </div>

					 <div class="row" id="domisiliDokumenFOTO" class="d-none">
						 <div class="col mb-3">
							<x-label for="foto" :value="__('Upload Foto (.jpg/.png)')"/>
							<x-input class="form-control" type="file" name="foto" />
							<x-invalid error="foto" />
						   </div>
					   </div>
					  
					
				  </div>
				  <div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ajukan Surat Keterangan')"/>
				  </div>
			</form>

		  
		</div>
	  </div>

	  <!--/ Create App Modal -->
		</div>

