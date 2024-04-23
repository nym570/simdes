@extends('layouts.app')
@section('container')

<div class="row g-4 mb-4">
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Total Permohonan</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_sum($data)}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-primary">
				<i class="bx bx-user bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Menunggu Verif</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_key_exists("", $data)?$data[""]:0}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-danger">
				<i class="bx bx-user-voice bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Disetujui</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_key_exists('1', $data)?$data['1']:0}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-success">
				<i class="bx bx-user-check bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Ditolak</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{array_key_exists('0', $data)?$data['0']:0}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-warning">
				<i class="bx bx-user-x bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>


	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Permohonan Informasi Publik') }}
			</h5>
			<span>Sudah melakukan permohonan? cek disini <button type="button" class="ms-2 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#cekModal">
				Cek Permohonan!
			  </button></span>
		</div>
	</div>
	
	<div class="modal fade" id="cekModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel">Cek Permohonan Informasi</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form id="formAuthentication" class="mb-3" action=" {{route('pengajuan-info.cek')}}" method="POST" enctype="multipart/form-data">
				@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<x-label for="nik" :value="__('NIK')" />
						<x-input type="text" name="nik" id="nik" :placeholder="__('3515xxxxxxxxx')" :value="old('nik')" required/>
						<x-invalid error="nik" />
					</div>
				</div>
				<div class="row ">
					<div class="col mb-3">
					  <x-label for="email_cek" :value="__('Email')" />
					  <x-input type="email_cek" name="email_cek" id="email_cek" :placeholder="__('Email')" :value="old('email_cek')" required/>
					  <x-invalid error="email_cek" />
					</div>
				  </div>
				  <div class="row ">
					<div class="col mb-3">
					  <x-label for="no_pendaftaran" :value="__('Nomor Pendaftaran')" />
					  <x-input type="text" name="no_pendaftaran" id="no_pedaftaran" :placeholder="__('Nomor Pendaftaran')" :value="old('no_pendaftaran')" required/>
					  <x-invalid error="no_pendaftaran" />
					</div>
				  </div>
			</div>
			<div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Cek Permohonan')"/>
			</div>
		</form>
		  </div>
		</div>
	  </div>
	<div class="card mt-3">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Formulir Permohonan') }}
			</h5>
			<form id="formPermohonan" class="mb-3" action="{{ route('pengajuan-info.buat') }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="mt-2">
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
				</div>
				<div class="mt-4">
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
								  <option value="kurir/pos">Kurir / Pos</option>
								  <option value="email/wa">Email / Whatsapp</option>
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
				<div class="my-4">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Submit')"/>
				</div>
			</form>
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
