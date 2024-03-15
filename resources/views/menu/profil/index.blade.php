@extends('layouts.app')
@section('container')

	<div class="card">
		<div class="card-body">
			

			
				<!-- Button trigger modal -->
    

	<div class="mb-4">

		<div class="btn-group mx-2">
			<button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Aksi
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><a class="dropdown-item open_modal_update" data-get="{{route("profil.warga.get",auth()->user()->warga)}}"data-link="{{route("profil.warga.update",auth()->user()->warga)}}">Update Data Kependudukan</a></li>
						<li><a class="dropdown-item open_modal_dokumen" data-dokumen="{{auth()->user()->warga->nik}}"data-link="{{route("profil.warga.dokumen",auth()->user()->warga)}}">Upload Dokumen</a></li>
						<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditUser">Update Data User</a></li>
						<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditPassword">Ubah Password</a></li>
						
			</ul>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="nav-align-top">
				<ul class="nav nav-pills mb-3" role="tablist">
				  <li class="nav-item">
					<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Biodata</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">User</button>
				  </li>

				</ul>
				<div class="tab-content">
				  <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
					<div class="text-center mb-3">
						<h4 >Biodata {{auth()->user()->warga->nama}}</h4>
						  <span class="badge {{((auth()->user()->warga->status=='warga')?'bg-primary':((auth()->user()->warga->status=='sementara tidak berdomisili')?'bg-info':'bg-secondary'))}}">{{auth()->user()->warga->status}}</span>
						  <span class="badge bg-dark">{{auth()->user()->warga->rt->name}}</span>
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
									<p>{{auth()->user()->warga->nik}}</p>
								</div>
								<div class="mb-2">
									<strong>No Kartu Keluarga : </strong>
									<p>{{auth()->user()->warga->no_kk}}</p>
								</div>
								<div class="mb-2">
									<strong>Nama : </strong>
									<p>{{auth()->user()->warga->nama}}</p>
								</div>
								<div class="mb-2">
									<strong>Tempat Tanggal Lahir : </strong>
									<p>{{auth()->user()->warga->tempat_lahir}},{{auth()->user()->warga->tanggal_lahir}}</p>
								</div>
								<div class="mb-2">
									<strong>Jenis Kelamin </strong>
									<p>{{auth()->user()->warga->jenis_kelamin}}</p>
								</div>
								<div class="mb-2">
									<strong>Agama : </strong>
									<p>{{auth()->user()->warga->agama}}</p>
								</div>
								<div class="mb-2">
									<strong>Golongan Darah : </strong>
									<p>{{auth()->user()->warga->gol_darah}}</p>
								</div>
								<div class="mb-2">
									<strong>Pendidikan Terakhir : </strong>
									<p>{{auth()->user()->warga->pendidikan}}</p>
								</div>
								<div class="mb-2">
									<strong>Pekerjaan Saat ini : </strong>
									<p>{{auth()->user()->warga->pekerjaan}}</p>
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
							@if(auth()->user()->warga->no_telp)
									<div class="mb-2">
										<strong>No Telp : </strong>
										<p>{{auth()->user()->warga->no_telp}} <a href="http://wa.me/{{auth()->user()->warga->no_telp}}" target="_blank">(Whatsapp)</a></p>
									</div>
								@endif
								
							<div class="mb-2">
								<strong>Kepemilikan KTP : </strong>
								<p>{{auth()->user()->warga->ktp_desa?'KTP Desa':'KTP Luar Desa'}}</p>
							</div>
							<div class="mb-2">
								<strong>Alamat KTP : </strong>
								<p>{{auth()->user()->warga->alamat_ktp}}</p>
							</div>
							<div class="">
								<div class="mb-3">
									<p class="mb-0"><strong>KTP (.jpg/.png) </strong></p>
									@if(auth()->user()->warga->dokumen_ktp)
									
									<button class="btn btn-sm btn-primary " type="button" id="btn-ktp-modal" data-bs-toggle="modal" data-bs-target="#modalKTP" aria-controls="collapseKTP">
										Lihat KTP
									  </button>
									  <div class="modal fade" id="modalKTP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
										  <div class="modal-content">
											<div class="modal-header">
											  <h5 class="modal-title" id="exampleModalLabel">KTP {{auth()->user()->warga->nama}}</h5>
											  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
												</button>
											</div>
											<div class="modal-body">
												<img class="object-fit-fill w-100" src="{{asset('storage/'.auth()->user()->warga->dokumen_ktp)}}"/>
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
									@if(auth()->user()->warga->foto)
									<button class="btn btn-sm btn-primary  " type="button" id="btn-foto-modal" data-bs-toggle="modal" data-bs-target="#modalFoto" aria-controls="collapseFoto">
										Lihat Foto
									  </button>
									  <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm" role="document">
										  <div class="modal-content">
											<div class="modal-header">
											  <h5 class="modal-title" id="exampleModalLabel">Foto {{auth()->user()->warga->nama}}</h5>
											  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
												</button>
											</div>
											<div class="modal-body">
												<img class="object-fit-fill w-100" src="{{asset('storage/'.auth()->user()->warga->foto)}}"/>
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
									@if(auth()->user()->warga->dokumen_kk)
									<button class="btn btn-sm btn-primary  " id="btn-kk-modal" type="button" data-bs-toggle="modal" data-bs-target="#modalKK"  aria-controls="collapseKK">
										Lihat KK
									  </button>
									  <div class="modal fade" id="modalKK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
										  <div class="modal-content">
											<div class="modal-header">
											  <h5 class="modal-title" id="exampleModalLabel">Kartu Keluarga {{auth()->user()->warga->nama}}</h5>
											  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
												</button>
											</div>
											<div class="modal-body">
												<img class="object-fit-fill w-100" src="{{asset('storage/'.auth()->user()->warga->dokumen_kk)}}"/>
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
				  <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
					<div class="text-center mb-3">
						<h4 >Pengguna {{auth()->user()->username}}</h4>
						@forelse (auth()->user()->roles as $item)
							<span class="badge bg-primary">{{$item->name}}</span>
						@empty
							<p>Pengguna belum memiliki role</p>
						@endforelse
					</div>
					<div class="card">
						<div class="card-header">
							<h5>Keterangan Pengguna</h5>
						</div>
					  <div class="card-body">
						
							<div class="mb-2">
								<strong>Username : </strong>
								<p>{{auth()->user()->username}}</p>
							</div>
							<div class="mb-2">
								<strong>Email : </strong>
								<p>{{auth()->user()->email}}</p>
							</div>
							<div class="mb-2">
								<strong>Dibuat Sejak: </strong>
								<p>{{auth()->user()->created_at}}</p>
							</div>
							
					  </div>
					</div>
				  </div>
				</div>
			  </div>

				
		</div>
		</div>

		</div>
	</div>
		@include('menu.profil._partials.dokumen')

	@include('menu.profil._partials.edit')
	@include('menu.profil._partials.edit_user')

@endsection
