  <!-- Modal -->
  <div class="modal  fade" id="tolakModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Form Penolakan</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formTolak" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf
					
					<div class="row">
						<div class="col mb-3">
								<label for="penguasaan_tolak" class="form-label">Penguasaan Informasi</label>
								<select id="penguasaan_tolak" class="selectpicker w-100" data-style="btn-default" title="Penguasaan Informasi" name="kuasa" required>
								  <option value="desa">Desa</option>
								  <option value="badan/lembaga lain">Badan / Lembaga Lain</option>
								</select>
						</div>
					</div>
					<div class="row ">
						<div class="col mb-3">
							<label for="penolakan" class="form-label">Landasan Penolakan</label>
							<select id="penolakan" class="selectpicker w-100" data-style="btn-default" multiple data-icon-base="bx" title="Landasan Penolakan" data-tick-icon="bx-check text-primary" name="penolakan[]" data-live-search="true" required>
							  <option value="lain">Undang-Undang Lain</option>
							  <option value="a">UU KIP (a) - menghambat penegakan hukum</option>
							  <option value="b">UU KIP (b) - mengganggu perlindungan atas hak kekayaan intelektual dan perlindungan dari persaingan usaha tidak sehat</option>
							  <option value="c">UU KIP (c) - membahayakan pertahanan dan keamanan negara</option>
							  <option value="d">UU KIP (d) - mengungkapkan kekayaan indonesia</option>
							  <option value="e">UU KIP (e) - mengganggu ekonomi nasional</option>
							  <option value="f">UU KIP (f) - merugikan kepentingan hubungan luar negeri</option>
							  <option value="g">UU KIP (g) - mengungkapkan isi akta otentik yang bersifat pribadi</option>
							  <option value="h">UU KIP (h) - mengungkap rahasia pribadi</option>
							  <option value="i">UU KIP (i) - surat antar/intra Badan Publik yang sifatnya dirahasiakan</option>
							  <option value="j">UU KIP (j) - tidak boleh diungkapkan berdasarkan UU</option>
							</select>
						</div>
					  </div>
					<div class="row ">
						<div class="col mb-3">
						  <x-label for="keterangan" :value="__('Konsekuensi Membuka Informasi')" />
						  <textarea name="keterangan" id="penolakan" placeholder='Jelaskan konsekuensi pembukaan informasi sehingga mengharuskan penolakan'  class="form-control" rows="2" required>{{Request::old('keterangan')}}</textarea>
						  <x-invalid error="keterangan" />
						</div>
					  </div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tolak Permohonan')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

     
<!-- Modal -->
<div class="modal  fade" id="setujuModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Form Rincian</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formSetuju" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row mb-3">
						<div class="col">
							<label for="penguasaan_setuju" class="form-label">Penguasaan Informasi</label>
							<select id="penguasaan_setuju" class="selectpicker w-100" data-style="btn-default" title="Penguasaan Informasi" name="kuasa" required>
							  <option value="desa">Desa</option>
							  <option value="badan/lembaga lain">Badan / Lembaga Lain</option>
							</select>
					</div>
					  </div>

					<div class="row mb-3">
						<div class="col">
							<x-label for="biaya" :value="__('Biaya')" />
						<div class="input-group">
							<span class="input-group-text">Rp</span>
							<x-input type="number" name="biaya" id="biaya" :value="old('biaya')" min="0" step="1000" required/>
						</div>
						
						<x-invalid error="biaya" />
					</div>
						
					</div>
					<div class="row ">
						<div class="col mb-3">
						  <x-label for="keterangan_setuju" :value="__('Keterangan tambahan')" />
						  <textarea name="keterangan" id="keterangan_setuju" placeholder='Jelaskan cara pembayaran atau tindak lanjut permohonan'  class="form-control" rows="2" required>{{Request::old('keterangan')}}</textarea>
						  <x-invalid error="keterangan" />
						</div>
					  </div>
					
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Setujui Permohonan')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

  <!-- Modal -->
<div class="modal  fade" id="bayarModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Form Rincian</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formBayar" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="row mb-3">
						
					<div class="col">
							<label for="cara_bayar" class="form-label">Cara Pembayaran</label>
							<select id="cara_bayar" class="selectpicker w-100" data-style="btn-default" title="Cara Pembayaran" name="cara_bayar" required>
							  <option value="1">Tunai</option>
							  <option value="0">Transfer</option>
							</select>
					</div>
						
					</div>
					<div class="row ">
						<div class="col mb-3">
							<x-label for="bukti pembayaran" :value="__('Bukti Pembayaran (.jpg)')" />
							<input type="file" class="form-control" id="pembayaran" name="pembayaran" required>
							<x-invalid error="pembayaran" />
						</div>
					  </div>
					
					
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Selesaikan Permohonan')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

  <!-- Modal -->
<div class="modal  fade" id="verifSelesaiModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Form Rincian</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formVerifSelesai" class="mb-3" data-remote="true" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="row mb-3">
						
						
					</div>
					<div class="row ">
						<div class="col mb-3">
						  <x-label for="keterangan_selesai" :value="__('Keterangan tambahan')" />
						  <textarea name="keterangan" id="keterangan_selesai_verif" placeholder='Keterangan lainnya'  class="form-control" rows="2" required>{{Request::old('keterangan')}}</textarea>
						  <x-invalid error="keterangan" />
						</div>
					  </div>
					
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Selesaikan Permohonan')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

@push('js')
<script>

	$(document).on('click','.open_modal_tolak',function(){
				let link= $(this).attr('data-link');
				$('#formTolak').attr('action',link);
				$('#tolakModal').modal('show');
				
			}); 
			$(document).on('click','.open_modal_setuju',function(){
				let link= $(this).attr('data-link');
				$('#formSetuju').attr('action',link);
				$('#setujuModal').modal('show');
				
			}); 
			$(document).on('click','.open_modal_bayar',function(){
				let link= $(this).attr('data-link');
				$('#formBayar').attr('action',link);
				$('#bayarModal').modal('show');
				
			}); 
			$(document).on('click','.open_modal_verif_selesai',function(){
				let link= $(this).attr('data-link');
				$('#formVerifSelesai').attr('action',link);
				$('#verifSelesaiModal').modal('show');
				
			}); 
</script>
@endpush


