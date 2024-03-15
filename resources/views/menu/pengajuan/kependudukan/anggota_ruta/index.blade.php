@extends('layouts.app')
@section('container')

	<div class="card">
		<div class="card-body">
			

			
				<!-- Button trigger modal -->
    

	<div class="mb-4">
		<a href="{{route('pengajuan.warga.ruta.index',$ruta)}}" class="btn btn-dark"> Kembali </a>
		<div class="btn-group mx-2">
			<button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Aksi
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><a class="dropdown-item open_modal_update" data-get="{{route("profil.warga.get",$warga)}}"data-link="{{route("profil.warga.update",$warga)}}">Update Data Kependudukan</a></li>
						<li><a class="dropdown-item open_modal_dokumen" data-dokumen="{{$warga->nik}}"data-link="{{route("profil.warga.dokumen",$warga)}}">Upload Dokumen</a></li>
						
			</ul>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="text-center mb-3">
				<h4 >Biodata {{$warga->nama}}</h4>
				  <span class="badge {{(($warga->status=='warga')?'bg-primary':(($warga->status=='sementara tidak berdomisili')?'bg-info':'bg-secondary'))}}">{{$warga->status}}</span>
				  <span class="badge bg-dark">{{$warga->rt->name}}</span>
			</div>
		  

		  <div class="row row-cols-1 row-cols-lg-2 g-2">
		
			<div class="col">
				<div class="card h-100">
					<div class="card-header">
						<h5>Identitas Diri</h5>
					</div>
				  <div class="card-body">
					
						<div class="mb-2">
							<strong>NIK : </strong>
							<p>{{$warga->nik}}</p>
						</div>
						<div class="mb-2">
							<strong>No Kartu Keluarga : </strong>
							<p>{{$warga->no_kk}}</p>
						</div>
						<div class="mb-2">
							<strong>Nama : </strong>
							<p>{{$warga->nama}}</p>
						</div>
						<div class="mb-2">
							<strong>Tempat Tanggal Lahir : </strong>
							<p>{{$warga->tempat_lahir}},{{$warga->tanggal_lahir}}</p>
						</div>
						<div class="mb-2">
							<strong>Jenis Kelamin </strong>
							<p>{{$warga->jenis_kelamin}}</p>
						</div>
						<div class="mb-2">
							<strong>Agama : </strong>
							<p>{{$warga->agama}}</p>
						</div>
						<div class="mb-2">
							<strong>Golongan Darah : </strong>
							<p>{{$warga->gol_darah}}</p>
						</div>
						<div class="mb-2">
							<strong>Pendidikan Terakhir : </strong>
							<p>{{$warga->pendidikan}}</p>
						</div>
						<div class="mb-2">
							<strong>Pekerjaan Saat ini : </strong>
							<p>{{$warga->pekerjaan}}</p>
						</div>
						
				  </div>
				</div>
			 </div>
			 <div class="col">
				<div class="card  h-100">
					<div class="card-header">
						<h5>Dokumen & Informasi</h5>
					</div>
				  <div class="card-body">
					@if($warga->no_telp)
							<div class="mb-2">
								<strong>No Telp : </strong>
								<p>{{$warga->no_telp}} <a href="http://wa.me/{{$warga->no_telp}}" target="_blank">(Whatsapp)</a></p>
							</div>
						@endif
						
					<div class="mb-2">
						<strong>Kepemilikan KTP : </strong>
						<p>{{$warga->ktp_desa?'KTP Desa':'KTP Luar Desa'}}</p>
					</div>
					<div class="mb-2">
						<strong>Alamat KTP : </strong>
						<p>{{$warga->alamat_ktp}}</p>
					</div>
					<div class="">
						<div class="mb-3">
							<p class="mb-0"><strong>KTP (.jpg/.png) </strong></p>
							@if($warga->dokumen_ktp)
							
							<button class="btn btn-sm btn-primary " type="button" id="btn-ktp-modal" data-bs-toggle="modal" data-bs-target="#modalKTP" aria-controls="collapseKTP">
								Lihat KTP
							  </button>
							  <div class="modal fade" id="modalKTP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
								  <div class="modal-content">
									<div class="modal-header">
									  <h5 class="modal-title" id="exampleModalLabel">KTP {{$warga->nama}}</h5>
									  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
										</button>
									</div>
									<div class="modal-body">
										<img class="object-fit-fill w-100" src="{{asset('storage/'.$warga->dokumen_ktp)}}"/>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									</div>
								  </div>
								</div>
							  </div>
							@else
							<p><small>Belum ada KTP yang diupload</small></p>
							  @endif
						  </div>
						  <div class="mb-3">
							<p class="mb-0"><strong>Foto Resmi (.jpg/.png) </strong></p>
							@if($warga->foto)
							<button class="btn btn-sm btn-primary  " type="button" id="btn-foto-modal" data-bs-toggle="modal" data-bs-target="#modalFoto" aria-controls="collapseFoto">
								Lihat Foto
							  </button>
							  <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm" role="document">
								  <div class="modal-content">
									<div class="modal-header">
									  <h5 class="modal-title" id="exampleModalLabel">Foto {{$warga->nama}}</h5>
									  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
										</button>
									</div>
									<div class="modal-body">
										<img class="object-fit-fill w-100" src="{{asset('storage/'.$warga->foto)}}"/>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									</div>
								  </div>
								</div>
							  </div>
							  @else
							<p><small>Belum ada Foto yang diupload</small></p>
							  @endif
						  </div>
						<div class="mb-3">
							<p class="mb-0"><strong>Kartu Keluarga (.jpg/.png) </strong></p>
							@if($warga->dokumen_kk)
							<button class="btn btn-sm btn-primary  " id="btn-kk-modal" type="button" data-bs-toggle="modal" data-bs-target="#modalKK"  aria-controls="collapseKK">
								Lihat KK
							  </button>
							  <div class="modal fade" id="modalKK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
								  <div class="modal-content">
									<div class="modal-header">
									  <h5 class="modal-title" id="exampleModalLabel">Kartu Keluarga {{$warga->nama}}</h5>
									  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
										</button>
									</div>
									<div class="modal-body">
										<img class="object-fit-fill w-100" src="{{asset('storage/'.$warga->dokumen_kk)}}"/>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									</div>
								  </div>
								</div>
							  </div>
							  @else
							<p><small>Belum ada KK yang diupload</small></p>
							@endif
						  </div>
						  
					</div>
				  </div>
				</div>
			 </div>

		  </div>
		</div>

		</div>
	</div>

	

	  
		@include('menu.pengajuan.kependudukan.anggota_ruta._partials.dokumen')

	@include('menu.pengajuan.kependudukan.anggota_ruta._partials.edit')

	

@endsection
