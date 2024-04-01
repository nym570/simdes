
  <!-- Modal -->
  <div class="modal fade" id="addMati"  tabindex="-1" aria-hidden="true">
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Tambah Data Kematian</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('pengajuan.warga.kependudukan.kematian.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				<div class="row  mb-3">
					<div class="col">
						<label for="nik" class="form-label">Warga*</label>
						<select id="nik_anggota" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih Warga" name="nik" required>
							
						</select>
						<x-invalid error="nik" />
					</div>
				</div>
				
				
				<div class="row">
					<div class="col mb-3">
						<label for="tempat" class="form-label">Tempat Kematian</label>
						<select id="tempat" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Tempat Kematian" name="tempat" required>
							<option value="Rumah">Rumah</option>
    						<option value="Rumah Sakit">Rumah Sakit</option>
							<option value="Lainnya">Lainnya</option>
						</select>
						<x-invalid error="tempat" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="waktu" :value="__('Waktu Kematian*')" />
					  <x-input type="datetime-local" name="waktu" id="waktu"  :value="old('waktu')" required/>
					  <x-invalid error="waktu" />
					</div>
				</div>
				

				<div class="row">
					<div class="col mb-3">
						<label for="penyebab" class="form-label">Sebab Kematian</label>
						<select id="penyebab" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Sebab Kematian" name="penyebab" required>
							<option value="Sakit Biasa/Tua">Sakit Biasa/Tua</option>
    						<option value="Wabah Penyakit">Wabah Penyakit</option>
							<option value="Kecelakaan">Kecelakaan</option>
							<option value="Kriminalitas">Kriminalitas</option>
							<option value="Bunuh Diri">Bunuh Diri</option>
							<option value="Lainnya">Lainnya</option>
						</select>
						<x-invalid error="penyebab" />
					</div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="saksi" class="form-label">Yang Menerangkan</label>
						<select id="saksi" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih orang yang menerangkan" name="saksi" required>
							<option value="Dokter">Dokter</option>
    						<option value="Tenaga Kesehatan">Tenaga Kesehatan</option>
							<option value="Kepolisian">Kepolisian</option>
							<option value="Lainnya">Lainnya</option>
						</select>
						<x-invalid error="saksi" />
					</div>
				</div>
				
				  <div class="row">
					<div class="col mb-3">
						<x-label for="bukti" :value="__('Bukti* (.pdf/.jpg/.png)')"/>
						<x-input class="form-control" type="file" id="bukti" name="bukti" required/>
						<x-invalid error="bukti" />
					  </div>
				  </div>
				<div class="row ">
					<div class="col mb-3">
						<label for="keterangan" class="form-label">Keterangan</label>
						<textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
					  <x-invalid error="keterangan" />
					</div>
				  </div>
				
				

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Data Kematian')"/>
			  </div>
		</form>
	  </div>
	</div>

</div>


<script>
		
		$( document ).ready(function() {
			
		var now = new Date(),
			date = now.toISOString().split('T');
			today = date[0];
			time = 'T'+date[1].split('.')[0];
			
			$('#waktu').prop('max', today+time);
				$.ajax({
					type : 'POST',
					url: "{{route('ruta.anggota-get')}}",
					data : {id:<?=$ruta->id?>,all:1},
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
					success: function(msg){
						$('#nik_anggota').selectpicker('destroy');
						$('#nik_anggota').html(msg);
						$('#nik_anggota').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		
	});
			
		
	</script>


