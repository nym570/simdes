@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<div class="row row-cols-1 row-cols-lg-2 g-2">
				<div class="col">
					<div class="mt-2">
						<strong>Nomor Pendaftaran : </strong>
						<p>{{$pengajuanInfoPublik->no_pendaftaran}}</p>
					</div>
					<div class="mt-2">
						<strong>Pengaju : </strong>
						<p>{{$pengajuanInfoPublik->nama}} ({{$pengajuanInfoPublik->nik_pengaju}})</p>
					</div>
					<div class="mt-2">
						<strong>Pekerjaan : </strong>
						<p>{{$pengajuanInfoPublik->pekerjaan}}</p>
					</div>
					<div class="mt-2">
						<strong>Email : </strong>
						<p>{{$pengajuanInfoPublik->email}}</p>
					</div>
					<div class="mt-2">
						<strong>No Telp : </strong>
						<p>{{$pengajuanInfoPublik->no_telp}} <a href="http://wa.me/{{$pengajuanInfoPublik->no_telp}}" target="_blank">(Whatsapp)</a></p>
					</div>
					<div class="mt-2">
						<strong>Alamat : </strong>
						<p>{{$pengajuanInfoPublik->alamat}}</p>
					</div>
				</div>
				<div class="col">
					<div class="mt-2">
						<strong>Status Pengajuan: </strong>
						<p><span class="badge {{$pengajuanInfoPublik->is_verified==null?'bg-dark':($pengajuanInfoPublik->is_verified==true?'bg-success':'bg-danger')}}">{{$pengajuanInfoPublik->status}}</span></p>
					</div>
					<div class="mt-2">
						<strong>Tujuan : </strong>
						<p>{{$pengajuanInfoPublik->tujuan}}</p>
					</div>
					<div class="mt-2">
						<strong>Rincian : </strong>
						<p>{{$pengajuanInfoPublik->rincian}}</p>
					</div>
					<div class="mt-2">
						<strong>Cara Perolehan : </strong>
						<p>{{$pengajuanInfoPublik->cara_perolehan}}</p>
					</div>
					<div class="mt-2">
						<strong>Media Perolehan : </strong>
						<p>{{$pengajuanInfoPublik->media_perolehan}}</p>
					</div>
					@if($pengajuanInfoPublik->is_verified==true)
					<div class="mt-2">
						<strong>Biaya : </strong>
						<p>{{$pengajuanInfoPublik->biaya}}</p>
					</div>
					@endif
					
				</div>
			</div>
			
		</div>
	</div>
	@if($pengajuanInfoPublik->status!='selesai'&&$pengajuanInfoPublik->biaya > 0)
	<div class="card mt-4">
		<div class="card-header">
			<h5>Upload Bukti Pembayaran</h5>
		</div>
		<div class="card-body">
			<form id="formSelesai" class="mb-3" data-remote="true" action="{{route('pengajuan-info.bayar',$pengajuanInfoPublik)}}" method="POST" enctype="multipart/form-data">
				@csrf

				<div class="row mb-3">
					
				<div class="col">
						<label for="cara_bayar" class="form-label">Cara Pembayaran</label>
						<select id="cara_bayar" class="selectpicker w-100" data-style="btn-default" title="Cara Pembayaran" name="cara_bayar" required>
						  <option value=1>Tunai</option>
						  <option value=2>Transfer</option>
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
			<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Upload Bukti Pembayaran')"/>
		  </div>
		</form>
	</form>
			
		</div>
	</div>
	@endif
	<div class="card mt-4">
		<div class="card-header">
			<h5>Lampiran</h5>
		</div>
		<div class="card-body">
			<table class="table table-striped table-bordered mb-4">
				<thead>
					<tr>
						<th>Nama</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>KTP & Surat Pengantar</td>
						<td><button class="align-middle btn btn-primary" data-bs-toggle="modal" data-bs-target="#lampiranModal">lihat </button></td>
					</tr>
					<tr>
						<td>Bukti Pendaftaran</td>
						<td><button class="align-middle btn btn-primary" data-bs-toggle="modal" data-bs-target="#buktiModal">lihat </button></td>
					</tr>
					@if($pengajuanInfoPublik->is_verified === 0)
						<td>Keterangan Penolakan</td>
						<td><button class="align-middle btn btn-primary" data-bs-toggle="modal" data-bs-target="#tolakModal">lihat </button></td>
					
						<div class="modal fade" id="tolakModal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
							  <div class="modal-content">
								<div class="modal-header">
								  <h5 class="modal-title" id="tolakModalJudul">Surat Keterangan Penolakan</h5>
								  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
										<iframe src ="{{ asset('/laraview/#../storage/'.str_replace('bukti', 'tolak', $pengajuanInfoPublik->bukti)) }}" width="100%" height="600px"></iframe>
								</div>
								
							  </div>
							</div>
						  </div>

						@endif
						@if(($pengajuanInfoPublik->status=='dibayar'||$pengajuanInfoPublik->status=='selesai')&&$pengajuanInfoPublik->biaya > 0)
						<td>Bukti Pembayaran</td>
						<td><button class="align-middle btn btn-primary" data-bs-toggle="modal" data-bs-target="#bayarModal">lihat </button></td>
					
						<div class="modal fade" id="bayarModal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
							  <div class="modal-content">
								<div class="modal-header">
								  <h5 class="modal-title" id="bayarModalJudul">Bukti Pembayaran</h5>
								  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="mt-2">
										<strong>Cara Pembayaran : </strong>
										<p>{{$pengajuanInfoPublik->cara_bayar}}</p>
									</div>
									<div class="mt-2">
										<p><strong>Bukti Bayar : </strong></p>
										<img src="{{asset('/storage/pengajuan-info-publik/bayar/'.str_replace(array("/"), "-", $pengajuanInfoPublik['no_pendaftaran']).'_'.$pengajuanInfoPublik['nik_pengaju'].'.jpg')}}" class="img-thumbnail" alt="lampiran" width="100%">
									</div>
									
								</div>
								
							  </div>
							</div>
						  </div>
						@endif
				</tbody>
			</table>
			
		</div>
	</div>
	

	<div class="modal fade" id="lampiranModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="lampiranModalJudul">KTP & Surat Pengantar</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
					<iframe src ="{{ asset('/laraview/#../storage/'.$pengajuanInfoPublik->lampiran) }}" width="100%" height="600px"></iframe>
			</div>
			
		  </div>
		</div>
	  </div>

	  <div class="modal fade" id="buktiModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="buktiModalJudul">Bukti Pendaftaran</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
					<iframe src ="{{ asset('/laraview/#../storage/'.$pengajuanInfoPublik->bukti) }}" width="100%" height="600px"></iframe>
			</div>
			
		  </div>
		</div>
	  </div>



@endsection
