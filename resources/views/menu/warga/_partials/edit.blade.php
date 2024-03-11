
  <!-- Modal -->
  <div class="modal fade" id="editWarga" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Edit Warga</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formEdit" class="mb-3"  data-remote="true" method="POST">
            @method('PUT')
			@csrf
			
			<div class="modal-body">
				
				<div class="row ">
				  <div class="col mb-3">
					<x-label for="nik_edit" :value="__('NIK*')" />
					<x-input type="text" name="nik" id="nik_edit" :placeholder="__('NIK 16 digit')" readonly required/>
					<x-invalid error="nik" />
				  </div>
				  
				  
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="no_kk_edit" :value="__('No Kartu Keluarga*')" />
						<x-input type="text" name="no_kk" id="no_kk_edit" :placeholder="__('No pada KK 16 digit')"  required/>
						<x-invalid error="no_kk" />
					  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="nama_edit" :value="__('Nama*')" />
						<x-input type="text" name="nama" id="nama_edit" :placeholder="__('Nama Lengkap Sesuai KTP')"  required/>
						<x-invalid error="nama" />
					  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<x-label for="no_telp_edit" :value="__('No HP*')" />
						<x-input type="text" name="no_telp" id="no_telp_edit" :placeholder="__('62xxxxxx')"  required/>
						<x-invalid error="no_telp" />
					  </div>
				</div>
				<div class="row mb-3">
					<div class="accordion col mb-2" id="accordionExample">
						<div class="card accordion-item">
							<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne" role="tabpanel">
								<div class="row">
									<div class="">
									  <x-label for="kode_wilayah_edit" :value="__('Alamat KTP*')" />
									  <x-input type="text" name="kode_wilayah_ktp" id="kode_wilayah_edit"  readonly/>
									  <x-invalid error="kode_wilayah" />
									</div>
									
								  </div>
								
							</button>

					  
						  <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class="row">
									<div class="col mb-2">
										<label for="provinsi_edit" class="form-label">Provinsi</label>
										<select id="provinsi_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="kode_provinsi">
											
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col mb-2">
										<label for="kabupaten_edit" class="form-label">Kabupaten</label>
										<select id="kabupaten_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kabupaten"  name="kode_kabupaten">
											
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col mb-2">
										<label for="kecamatan_edit" class="form-label">Kecamatan</label>
										<select id="kecamatan_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kecamatan" name="kode_kecamatan">
											
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col mb-2">
										<label for="desa_edit" class="form-label">Desa</label>
										<select id="desa_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih desa/kelurahan" name="kode_desa">
											
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col mb-3">
										<x-label for="alamat_ktp_edit" :value="__('Alamat*')" />
										<x-input type="text" name="alamat_ktp" id="alamat_ktp_edit" :placeholder="__('Alamat Lengkap Sesuai KTP')" />
										<x-invalid error="alamat_ktp" />
									  </div>
								</div>
								
							</div>
						  </div>
						</div>
						
						<div class="divider divider-dashed mb-2">
							<div class="divider-text">Biodata Warga</div>
						  </div>
				<div class="row g-2 mb-3">
					<label for="provinsi-lahir-edit" class="form-label">Tempat Lahir</label>
					<div class="col">
						
						<select id="provinsi-lahir_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih provinsi" name="provinsi-lahir" required>
							
						</select>
					</div>
					<div class="col">
						<select id="kabupaten-lahir_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih kabupaten" name="kabupaten-lahir" required>
							
						</select>
						<input class="d-none" type="text" name="tempat_lahir" id="tempat_lahir_edit" required/>
					</div>
				  </div>

				  
				<div class="row">
					<div class="col mb-3">
						<label for="tanggal_lahir_edit" class="form-label">Tanggal Lahir*</label>
						<x-input type="date" name="tanggal_lahir" id="tanggal_lahir_edit"  required/>
						<x-invalid error="tanggal_lahir" />
					  </div>
				</div>

				<div class="row">
					<div class="col mb-3">
						<label for="jenis_kelamin_edit" class="form-label">Jenis Kelamin*</label>
						<select id="jenis_kelamin_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih jenis kelamin"  name="jenis_kelamin" required>
							<option value="laki-laki">Laki-Laki</option>
    						<option value="perempuan">Perempuan</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="agama_edit" class="form-label">Agama*</label>
						<select id="agama_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih agama"  name="agama" required>
							<option value="Islam">Islam</option>
    						<option value="Kristen">Kristen (Protestan)</option>
							<option value="Katolik">Katolik</option>
							<option value="Hindu">Hindu</option>
							<option value="Budha">Budha</option>
							<option value="Konghucu">Konghucu</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="gol_darah_edit" class="form-label">Golongan Darah*</label>
						<select id="gol_darah_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="false" title="Pilih Golongan Darah"  name="gol_darah" required>
							<option value="A">A</option>
    						<option value="B">B</option>
							<option value="AB">AB</option>
							<option value="O">O</option>
							<option value="Tidak Mengetahui">Tidak Mengetahui</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="pendidikan_edit" class="form-label">Pendidikan Terakhir*</label>
						<select id="pendidikan_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pendidikan terakhir yang ditamatkan"  name="pendidikan" required>
							
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="pekerjaan_edit" class="form-label">Pekerjaan Saat Ini*</label>
						<select id="pekerjaan_edit" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pekerjaan saat ini"  name="pekerjaan" required>
							
						</select>
					</div>
				</div>

				</div>
			</div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Warga')"/>
			  </div>
			
		</form>
	  </div>
	</div>
  </div>

  <script>
    $(document).on('click','.open_modal_update',function(){
        var now = new Date(),
			today = now.toISOString().split('T')[0];
			$('#tanggal_lahir_edit').prop('max', today);
        let get = $(this).attr('data-get')
        let link= $(this).attr('data-link');
        var ajax11 = $.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-prov')}}",
					success: function(msg){
						
						$('#provinsi_edit').html(msg);
						$('#provinsi_edit').selectpicker('refresh');
						$('#provinsi-lahir_edit').html(msg);
						$('#provinsi-lahir_edit').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				var ajax12 = $.ajax({
					type : 'GET',
					url: "{{route('master.identitas.get-pendidikan')}}",
					success: function(msg){
						
						$('#pendidikan_edit').html(msg);
						$('#pendidikan_edit').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
				var ajax13 = $.ajax({
					type : 'GET',
					url: "{{route('master.identitas.get-pekerjaan')}}",
					success: function(msg){
						
						$('#pekerjaan_edit').html(msg);
						$('#pekerjaan_edit').selectpicker('refresh');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
            $.when(ajax11, ajax12, ajax13).done(function() {
                    $.ajax({
					type : 'GET',
					url: get,
					success: function(msg){
						
						let data = JSON.parse(msg);
						$('#nik_edit').val(data.nik);
                        $('#no_kk_edit').val(data.no_kk);
                        $('#nama_edit').val(data.nama);
                        if(data.no_telp!=null){
                            $('#no_telp_edit').val(data.no_telp);
                        }
                        let wilayah = data.kode_wilayah_ktp.split('.');
                        
                        $('#provinsi_edit').val(wilayah[0]);
                        $('#provinsi_edit').selectpicker('refresh').trigger('change',[wilayah]);
                        $('#alamat_ktp_edit').val(data.alamat_ktp);
                        $('#tanggal_lahir_edit').val(data.tanggal_format.split('T')[0]);
                        $('#jenis_kelamin_edit').val(data.jenis_kelamin);
                        $('#jenis_kelamin_edit').selectpicker('refresh').trigger('change');
                        $('#agama_edit').val(data.agama);
                        $('#agama_edit').selectpicker('refresh').trigger('change');
                        $('#pekerjaan_edit').val(data.pekerjaan);
                        $('#pekerjaan_edit').selectpicker('refresh').trigger('change');
                        $('#pendidikan_edit').val(data.pendidikan);
                        $('#pendidikan_edit').selectpicker('refresh').trigger('change');
                        $('#gol_darah_edit').val(data.gol_darah);
                        $('#gol_darah_edit').selectpicker('refresh').trigger('change');
                        $('#formEdit').attr('action',link);
                        $('#editWarga').modal('show');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
			});
       
        
    });
    $(function(){
			$('#provinsi-lahir_edit').on('change',function(event, a){
				$('#provinsi-lahir_edit').selectpicker('render');
				let id_prov = $('#provinsi-lahir_edit').val();


				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-kab')}}",
					data : {'id_prov':id_prov},
					success: function(msg){
						$('#kabupaten-lahir_edit').selectpicker('destroy');
						$('#kabupaten-lahir_edit').html(msg);
						$('#kabupaten-lahir_edit').selectpicker('render');
                        
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#kabupaten-lahir_edit').on('change',function(){
				$('#kabupaten-lahir_edit').selectpicker('render');
				let id_kab = $('#kabupaten-lahir_edit').val();
				let el = $("#kabupaten-lahir_edit option:selected").text();
				$('#tempat_lahir_edit').val(el);

				
			});
		});
        $(function(){
			$('#provinsi_edit').on('change',function(event,a){
				$('#provinsi_edit').selectpicker('render');
				let id_prov = $('#provinsi_edit').val();

				
				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-kab')}}",
					data : {'id_prov':id_prov},
					success: function(msg){
						$('#kabupaten_edit').selectpicker('destroy');
						$('#kabupaten_edit').html(msg);
						$('#kabupaten_edit').selectpicker('render');
                        if(a!=null){
                            $('#kabupaten_edit').val(a[0]+'.'+a[1]);
                            $('#kabupaten_edit').selectpicker('refresh').trigger('change',[a]);
                        }
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#kabupaten_edit').on('change',function(event,a){
				$('#kabupaten_edit').selectpicker('render');
				let id_kab = $('#kabupaten_edit').val();


				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-kec')}}",
					
					data : {id_kab:id_kab},

					success: function(msg){
						$('#kecamatan_edit').selectpicker('destroy');
						$('#kecamatan_edit').html(msg);
						$('#kecamatan_edit').selectpicker('render');
                        if(a!=null){
                            $('#kecamatan_edit').val(a[0]+'.'+a[1]+'.'+a[2]);
                            $('#kecamatan_edit').selectpicker('refresh').trigger('change',[a]);
                        }
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#kecamatan_edit').on('change',function(event, a){
				$('#kecamatan_edit').selectpicker('render');
				let id_kec = $('#kecamatan_edit').val();

				$.ajax({
					type : 'GET',
					url: "{{route('wilayah.get-des')}}",
					
					data : {id_kec:id_kec},

					success: function(msg){
						$('#desa_edit').selectpicker('destroy');
						$('#desa_edit').html(msg);
						$('#desa_edit').selectpicker('render');
                        if(a!=null){
                            $('#desa_edit').val(a[0]+'.'+a[1]+'.'+a[2]+'.'+a[3]);
                            $('#desa_edit').selectpicker('refresh').trigger('change',[a]);
                        }
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#desa_edit').on('change',function(){
				$('#desa_edit').selectpicker('render');
				let id_desa = $('#desa_edit').val();
				$('#kode_wilayah_edit').val(id_desa);
			});
		})
  </script>