  <!-- Modal -->
  <div class="modal fade" id="addPindah" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Tambah Data Kepindahan</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('pengajuan.warga.kependudukan.kepindahan.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<label for="jenis" class="form-label">Jenis Kepindahan</label>
						<select id="jenis" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Jenis Kepindahan" name="jenis" required>
							<option value="Seluruh">Seluruh Rumah Tangga</option>
    						<option value="Sebagian">Sebagian Anggota Rumah Tangga</option>
						</select>
						<x-invalid error="jenis" />
					</div>
				</div>
				<div class="row  mb-3" id="warga_pindah">
					<div class="col">
						<label for="nik_pindah" class="form-label">Warga Pindah*</label>
						<select id="nik_pindah" class="selectpicker w-100" data-style="btn-default" multiple data-icon-base="bx" multiple data-actions-box="true" data-live-search="true" data-tick-icon="bx-check text-primary" title="Pilih Warga" name="nikpindah[]">
							
						</select>
						<x-invalid error="nikpindah" />
					</div>
				</div>
				<div class="row mb-3">
					<div class="accordion col mb-2" id="accordionExample">
						<div class="card accordion-item">
							<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
								<div class="row">
									<div class="">
									  <x-label for="kode_wilayah_pindah" :value="__('Alamat Pindah*')" />
									  <x-input type="text" name="kode_wilayah_pindah" id="kode_wilayah_pindah" :value="old('kode_wilayah_pindah')" readonly/>
									  <x-invalid error="kode_wilayah_pindah" />
									</div>
									
								  </div>
								
							</button>

					  
						  <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class="row">
									<div class="col mb-2">
										<label for="provinsi_pindah" class="form-label">Provinsi</label>
										<select id="provinsi_pindah" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="kode_provinsi_pindah">
											
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col mb-2">
										<label for="kabupaten_pindah" class="form-label">Kabupaten</label>
										<select id="kabupaten_pindah" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kabupaten"  name="kode_kabupaten_pindah">
											
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col mb-2">
										<label for="kecamatan_pindah" class="form-label">Kecamatan</label>
										<select id="kecamatan_pindah" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kecamatan" name="kode_kecamatan_pindah">
											
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col mb-2">
										<label for="desa_pindah" class="form-label">Desa</label>
										<select id="desa_pindah" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih desa/kelurahan" name="kode_desa_pindah">
											
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col mb-3">
										<x-label for="alamat_ktp" :value="__('Alamat*')" />
										<x-input type="text" name="alamat_pindah" id="alamat_pindah" :placeholder="__('Alamat Lengkap domisili baru')" :value="old('alamat_pindah')" />
										<x-invalid error="alamat_pindah" />
									  </div>
								</div>
								
							</div>
						  </div>
						</div>
					</div>
				
				
				<div class="row">
					<div class="col mb-3">
						<x-label for="waktu_pindah" :value="__('Waktu Kepindahan*')" />
					  <x-input type="date" name="waktu_pindah" id="waktu_pindah"  :value="old('waktu')" required/>
					  <x-invalid error="waktu" />
					</div>
				</div>
				

				<div class="row">
					<div class="col mb-3">
						<label for="penyebab_pindah" class="form-label">Alasan Pindah</label>
						<select id="penyebab_pindah" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Alasan Pindah" name="penyebab_pindah" required>
							<option value="Pekerjaan">Pekerjaan</option>
    						<option value="Pendidikan">Pendidikan</option>
							<option value="Keamanan">Keamanan</option>
							<option value="Kesehatan">Kesehatan</option>
							<option value="Keluarga">Keluarga</option>
							<option value="Lainnya">Lainnya</option>
						</select>
						<x-invalid error="penyebab" />
					</div>
				</div>

				
				
				  <div class="row">
					<div class="col mb-3">
						<x-label for="bukti_pindah" :value="__('Bukti* (.pdf/.jpg/.png)')"/>
						<x-input class="form-control" type="file" id="bukti_pindah" name="bukti_pindah" required/>
						<x-invalid error="bukti" />
					  </div>
				  </div>
				<div class="row ">
					<div class="col mb-3">
						<label for="keterangan_pindah" class="form-label">Keterangan</label>
						<textarea class="form-control" id="keterangan_pindah" name="keterangan_pindah" rows="3"></textarea>
					  <x-invalid error="keterangan" />
					</div>
				  </div>
				
				

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Data Kepindahan')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

  

</div>

<script>
		
	$( document ).ready(function() {
		
		
	$('#ruta_pindah').hide();
	$('#warga_pindah').addClass('d-none');
	$('#warga_pindah').prop('required',false);
	
	$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-prov')}}",
				success: function(msg){
					
					$('#provinsi_pindah').html(msg);
					$('#provinsi_pindah').selectpicker('refresh');
					
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
			});
			
	
});

$(function(){
	$('#jenis').on('change',function(){
			$('#jenis').selectpicker('render');
			let jenis = $('#jenis').val();
				$('#ruta_pindah').show();
				if(jenis == 'Seluruh'){
					$('#warga_pindah').addClass('d-none');
					$('#warga_pindah').prop('required',false);
				}
				else if(jenis == 'Sebagian'){
					$('#warga_pindah').removeClass('d-none');
					$('#warga_pindah').prop('required',true);
				
				}
				$.ajax({
					type : 'POST',
					url: "{{route('ruta.anggota-get')}}",
					data : {id:<?=$ruta->id?>},
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
					success: function(msg){
						$('#nik_pindah').selectpicker('destroy');
						$('#nik_pindah').html(msg);
						$('#nik_pindah').selectpicker('render');
						let jenis = $('#jenis').val();
						if(jenis == 'Seluruh'){
							$('#nik_pindah').selectpicker('selectAll');
						}
						else if (jenis == 'Sebagian'){
							$('#nik_pindah').selectpicker('deselectAll');
						}
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
			
		});
		$('#provinsi_pindah').on('change',function(){
			$('#provinsi_pindah').selectpicker('render');
			let id_prov = $('#provinsi_pindah').val();
			
			$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-kab')}}",
				data : {'id_prov':id_prov},
				beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
				success: function(msg){
					$('#kabupaten_pindah').selectpicker('destroy');
					$('#kabupaten_pindah').html(msg);
					$('#kabupaten_pindah').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#kabupaten_pindah').on('change',function(){
			$('#kabupaten_pindah').selectpicker('render');
			let id_kab = $('#kabupaten_pindah').val();

			$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-kec')}}",
				
				data : {id_kab:id_kab},
				beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
				success: function(msg){
					$('#kecamatan_pindah').selectpicker('destroy');
					$('#kecamatan_pindah').html(msg);
					$('#kecamatan_pindah').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#kecamatan_pindah').on('change',function(){
			$('#kecamatan_pindah').selectpicker('render');
			let id_kec = $('#kecamatan_pindah').val();
			$.ajax({
				type : 'GET',
				url: "{{route('wilayah.get-des')}}",
				
				data : {id_kec:id_kec},
				beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
				success: function(msg){
					$('#desa_pindah').selectpicker('destroy');
					$('#desa_pindah').html(msg);
					$('#desa_pindah').selectpicker('render');
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#desa_pindah').on('change',function(){
			$('#desa_pindah').selectpicker('render');
			let id_desa = $('#desa_pindah').val();
			$('#kode_wilayah_pindah').val(id_desa);
		});
	});
		
	
</script>
