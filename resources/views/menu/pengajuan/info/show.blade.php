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
					
				</div>
			</div>
			
		</div>
	</div>
	
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
						<td></td>
					</tr>
					<tr>
						<td>Bukti Pendaftaran</td>
						<td></td>
					</tr>
					@if($pengajuanInfoPublik->is_verified === false)
						<td>Keterangan Penolakan</td>
						<td></td>
					@endif
				</tbody>
			</table>
			
		</div>
	</div>



@endsection
