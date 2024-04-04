@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Manajemen Permohonan Informasi Publik') }}
			</h5>

			<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addInfo">
				Tambah Permohonan Informasi
			  </button>

			  <!-- Modal -->
  <div class="modal fade" id="addInfo" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="judulModal">Permohonan Informasi Publik</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formPermohonan" class="mb-3" action="{{ route('pengajuan-info.buat') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="modal-body">
				
					<div class="divider">
						<div class="divider-text">Data Pengaju</div>
					  </div>
					<div class="row g-2 mb-3">
						<div class="col">
						  <x-label for="nama" :value="__('Nama Lengkap')" />
						  <x-input type="text" name="nama" id="nama" :placeholder="__('John Doe')" :value="old('nama')" required/>
						  <x-invalid error="nama" />
						</div>
						<div class="col">
							<x-label for="nik_pengaju" :value="__('NIK')" />
							<x-input type="text" name="nik_pengaju" id="nik_pengaju" :placeholder="__('3515xxxxxxxxx')" :value="old('nik_pengaju')" required/>
							<x-invalid error="nik_pengaju" />
						</div>
					</div>
					<div class="row ">
						<div class="col mb-3">
						  <x-label for="alamat" :value="__('Alamat Lengkap')" />
						  <textarea name="alamat" id="alamat" placeholder='Jalan, RT, RW, Desa, Kecamatan, Kabupaten, Provinsi, Kode Pos'  class="form-control" rows="3" required> {{Request::old('alamat')}}</textarea>
						  <x-invalid error="alamat" />
						</div>
					  </div>
					  <div class="row">
						<div class="col mb-3">
							<label for="pekerjaan" class="form-label">Pekerjaan Saat Ini</label>
							<select id="pekerjaan" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pekerjaan"  name="pekerjaan" required>
								
							</select>
						</div>
					</div>
					<div class="row g-2 mb-3">
						<div class="col">
						  <x-label for="email" :value="__('Email')" />
						  <x-input type="email" name="email" id="email" :placeholder="__('johndoe@example.com')" :value="old('email')" required/>
						  <x-invalid error="email" />
						</div>
						<div class="col">
							<x-label for="no_telp" :value="__('No Telepon')" />
							<x-input type="text" name="no_telp" id="no_telp" :placeholder="__('62xxxxxx')" :value="old('no_telp')" required/>
							<x-invalid error="no_telp" />
						  </div>
					</div>
				
				
					<div class="divider">
						<div class="divider-text">Keterangan Informasi</div>
					  </div>
					  <div class="row ">
						<div class="col mb-3">
						  <x-label for="rincian" :value="__('Rincian Informasi ')" />
						  <textarea name="rincian" id="rincian" placeholder='Rincian Informasi yang Dibutuhkan (Informasi apa dan atribut/kolom yang diperlukan)'  class="form-control" rows="4" required>{{Request::old('rincian')}}</textarea>
						  <x-invalid error="rincian" />
						</div>
					  </div>
					  <div class="row ">
						<div class="col mb-3">
						  <x-label for="tujuan" :value="__('Tujuan Penggunaan')" />
						  <textarea name="tujuan" id="tujuan" placeholder='Jelaskan tujuan penggunaan informasi yang diperlukan'  class="form-control" rows="2" required>{{Request::old('tujuan')}}</textarea>
						  <x-invalid error="tujuan" />
						</div>
					  </div>
					  <div class="row">
						<div class="col mb-3">
							<small class="text-light fw-medium">Cara Memperoleh Informasi</small>
							<div class="form-check mt-3">
							  <input name="cara_perolehan[]" class="form-check-input" type="checkbox" value="melihat/membaca/mendengarkan/mencatat" id="cb1" {{ (is_array(old('cara_perolehan')) && in_array("melihat/membaca/mendengarkan/mencatat", old('cara_perolehan'))) ? ' checked' : '' }} />
							  <label class="form-check-label" for="cb1">
								Melihat/Membaca/Mendengarkan/Mencatat
							  </label>
							</div>
							<div class="form-check">
							  <input name="cara_perolehan[]" class="form-check-input" type="checkbox" value="mendapat salinan" id="cb2" {{ (is_array(old('cara_perolehan')) && in_array("mendapat salinan", old('cara_perolehan'))) ? ' checked' : '' }}/>
							  <label class="form-check-label" for="cb2">
								Mendapatkan Salinan Informasi (Hardcopy/Softcopy)
							  </label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
								<label for="media_perolehan" class="form-label">Cara Mendapatkan Salinan</label>
								<select id="media_perolehan" class="selectpicker w-100" data-style="btn-default" multiple data-icon-base="bx" title="Cara Mendapatkan" data-tick-icon="bx-check text-primary" name="media_perolehan[]" data-live-search="true" required>
								  <option value="langsung">Mengambil Langsung</option>
								  <option value="kurir">Kurir</option>
								  <option value="pos">Pos</option>
								  <option value="email">Email</option>
								  <option value="faksmili">Faksmili</option>
								  <option value="lainnya">Lainnya</option>
								</select>
						</div>
					</div>
					<div class="row ">
						<div class="col mb-3">
							<x-label for="lampiran" :value="__('Lampiran')" />
							<p><small>KTP & Surat Pengantar dalam satu file pdf</small></p>
							<input type="file" class="form-control" id="lampiran" name="lampiran" required>
							<x-invalid error="lampiran" />
						</div>
					</div>

				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Submit')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

		
  
			  @include('components.table')
		</div>
	</div>

	<script>
		
		$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		
		$.ajax({
					type : 'GET',
					url: "{{route('master.identitas.get-pekerjaan')}}",
					success: function(msg){
						$('#pekerjaan').html(msg);
						$('#pekerjaan').selectpicker('refresh');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		
	});
	
	
		
	</script>


@endsection
