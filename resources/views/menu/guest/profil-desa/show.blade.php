@extends('layouts.app')
@section('container')
<div class="container">
	<div class="row mb-3">
		<div class="col-sm-4 mb-2 p-2">
			<div class="card">
				<div class="card-header">
					<h4>Detail Desa {{$desa->desa}}</h4>
				</div>
			  <div class="card-body">
					<div class="mb-2">
						<h5>Kode Wilayah</h5>
						<p>{{$desa->kode_wilayah}}</p>
					</div>
					<div class="mb-2">
						<h5>Provinsi</h5>
						<p>{{$desa->provinsi}}</p>
					</div>
					<div class="mb-2">
						<h5>Kabupaten/Kota</h5>
						<p>{{$desa->kabupaten}}</p>
					</div>
					<div class="mb-2">
						<h5>Kecamatan</h5>
						<p>{{$desa->kecamatan}}</p>
					</div>
			  </div>
			</div>
		</div>
		<div class="col-sm-4 mb-2 p-2">
			<div class="card h-100">
				<div class="card-header">
					<h4>Kantor Desa {{$desa->desa}}</h4>
				</div>
			  <div class="card-body">
				
					<div class="mb-3">
						<h5>Alamat Kantor Desa : </h5>
						<p>{{$desa->alamat_kantor}}</p>
					</div>
					<div class="mb-3">
						<h5>Email Kantor Desa : </h5>
						<p>{{$desa->email_desa}}</p>
					</div>
					<div class="mb-3">
						<h5>Nomor Telepon Kantor Desa : </h5>
						<p>{{$desa->no_telp}}</p>
					</div>
			  </div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="row p-2">
				<div class="card">
					<div class="card-body">
					  <div class="d-flex align-items-start justify-content-between">
						<div class="content-left">
						  <span>Jumlah Dusun</span>
						  <div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2">{{$agregate['dusun']}}</h3>
						  </div>
						</div>
						<div class="avatar">
						  <span class="avatar-initial rounded bg-label-primary">
							<i class="bx bx-home-alt bx-sm"></i>
						  </span>
						</div>
					  </div>
					</div>
				  </div>
			</div>
			<div class="row p-2">
				<div class="card">
					<div class="card-body">
					  <div class="d-flex align-items-start justify-content-between">
						<div class="content-left">
						  <span>Jumlah RW</span>
						  <div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2">{{$agregate['rw']}}</h3>
						  </div>
						</div>
						<div class="avatar">
						  <span class="avatar-initial rounded bg-label-success">
							<i class="bx bx-home-alt bx-sm"></i>
						  </span>
						</div>
					  </div>
					</div>
				  </div>
			</div>
			<div class="row p-2">
				<div class="card">
					<div class="card-body">
					  <div class="d-flex align-items-start justify-content-between">
						<div class="content-left">
						  <span>Jumlah RT</span>
						  <div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2">{{$agregate['rt']}}</h3>
						  </div>
						</div>
						<div class="avatar">
						  <span class="avatar-initial rounded bg-label-danger">
							<i class="bx bx-home-alt bx-sm"></i>
						  </span>
						</div>
					  </div>
					</div>
				  </div>
			</div>
	  </div>
	</div>
</div>



<div class="card mb-4">
	<div class="card-header">
		<h4 class="text-center">Perangkat Desa {{$desa->desa}}</h4>
	</div>
	<div class="card-body">
				@if(!$pemerintahan->empty())
				<div class="slider-container swiper">
					<div class="slider-content">
					  <div class="card-wrapper swiper-wrapper">
				@foreach ($pemerintahan as $item)
				<div class="card swiper-slide">
					<div class="image-content">
					  <span class="overlay"></span>
					  <div class="card-image">
						<img src="{{asset('storage/'.$item->foto)}}" class="card-img" alt="{{$item->jabatan}}" />
					  </div>
					</div>
					<div class="card-content">
					  <h2 class="name">{{$item->jabatan}}</h2>
					  <p class="description">
						{{$item->warga->nama}}
					  </p>
					 
					  <button class="button open_modal_pemerintahan" value="{{$item->id}}">Lihat >>></button>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="swiper-button-next swiper-navBtn"></div>
		<div class="swiper-button-prev swiper-navBtn"></div>
		<div class="swiper-pagination"></div>
	  </div>
				@else
				<p class="text-center">Tidak ada data ditampilkan</p>
				@endif
				
			  
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPemerintahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="jabatan"></h4>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<div class="modal-body">
		  <div class="mb-3" id="tugas">

		  </div>
		  <div class="mb-3" id="wewenang">

		  </div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
  </div>

@if(!is_null($desa->deskripsi))
<div class="card">
	<div class="card-body">
		<h4>Profil Desa {{$desa->desa}}</h4>
		{!! $desa->deskripsi !!}
	</div>
</div>
@endif

@push('js')
<script>
	var swiper = new Swiper(".slider-content", {
    slidesPerView: 3,
    spaceBetween: 25,
    loop: true,
    centerSlide:'true',
    fade:'true',
    grabCursor:'true',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets:true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints:{
        0:{
            slidesPerView:1,
        },
        520:{
            slidesPerView:2,
        },
        950:{
            slidesPerView:3,
        },
    }
  });
</script>
<script>
	$(document).on('click','.open_modal_pemerintahan',function(){
				$('#jabatan').empty();
				$('#tugas').empty();
				$('#wewenang').empty();
				let id= $(this).val();
				$.ajax({
					type : 'GET',
					url: "{{route('pemerintahan.get')}}",
					data : {id:id},
					success: function(msg){
						let data = JSON.parse(msg);
						$('#jabatan').append(data.jabatan);
						$('#tugas').append('<h5>Tugas</h5>');
						$('#tugas').append(data.tugas);
						$('#wewenang').append('<h5>Wewenang</h5>');
						$('#wewenang').append(data.wewenang);
						$('#modalPemerintahan').modal('show');
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
			}); 
</script>
@endpush

	

@endsection
