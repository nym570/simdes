

<h5 class="mt-5">Balasan</h5>
<div class="app-email card mt-3 ">
	<div class="border-0">
	  <div >
		<!-- Email View -->
		<div class="col app-email-view flex-grow-0 bg-body" id="app-email-view">
		  <div class="app-email-view-header p-3 py-md-3 py-2 rounded-0 overflow-auto" style="max-height: 700px">
			@forelse($aspirasi->balas_aspirasi as $item)
				<!-- Email View : Previous mails-->
			<div class="card email-card-prev mx-sm-4 mx-3 border mt-2" style= {{$item->user->id===auth()->user()->id ? "background-color:aliceblue" : ""}}>
				<div class="card-header d-flex justify-content-between align-items-center flex-wrap">
				  <div class="d-flex align-items-center mb-sm-0 mb-3">
					<div class="flex-grow-1 ms-1">
					  <h6 class="m-0">{{$item->user->name}}</h6>
					  <small class="text-muted">{{$item->user->email}}</small>
					</div>
				  </div>
				  <div class="d-flex align-items-center">
					<small class="mb-0 me-3 text-muted">{{$item->created_at}}</small>
				  </div>
				</div>
				<div class="card-body">
					{!!$item->isi!!}
					@if($item->lampiran)
					<hr>
					
					<p class="mb-2">Lampiran</p>
					<div class="cursor-pointer">
						<button class="align-middle btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModalBalas"><i class="bx bx-file"></i> .{{pathinfo($item->lampiran)['extension']}}</button>
					</div>
					<div class="modal fade" id="largeModalBalas" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
						  <div class="modal-content">
							<div class="modal-header">
							  <h5 class="modal-title" id="exampleModalLabel3">Lampiran</h5>
							  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								@if(pathinfo($item->lampiran)['extension']==="pdf")
								<iframe src ="{{ asset('/laraview/#../storage/'.$item->lampiran) }}" width="100%" height="600px"></iframe>
								@else
								<img src="{{asset('/storage/'.$item->lampiran)}}" class="img-thumbnail" alt="lampiran" width="100%">
								@endif
							</div>
							
						  </div>
						</div>
					  </div>
					@endif
				</div>
			  </div>
			  
			@empty
				<h3 class="text-muted mt-3 text-center">Tidak Ada Balasan</h3>
			@endforelse
			
			
			

			
		  </div>
		</div>
		<!-- Email View -->
	  </div>
	</div>
  
  </div>
  @if($aspirasi->is_open)
  <!-- Email View : Reply mail-->
  <h5 class="mt-5">Balas Aspirasi</h5>
  <div class="email-reply card mt-1 border">
	<div class="card-body pt-3 px-3">
	  <form action=" {{route('balas_aspirasi.store')}}" method="POST" enctype="multipart/form-data">
		  @csrf
		  
		  <div class="">
			  <input id="isi" type="hidden" name="isi" required :value="old('isi')">
			  <trix-editor input="isi"></trix-editor>
		  </div>
		  <input id="aspirasi_id" type="hidden" name="aspirasi_id" value="{{$aspirasi->id}}">
		  <div class="mt-3">
			  <x-label for="lampiran" :value="__('Lampiran (Jika ada)')" />
		  <input type="file" class="form-control" id="lampiran" name="lampiran">
		  <x-invalid error="lampiran" />
		  </div>
		  <div class="email-reply-editor"></div>
	  <div class="d-flex justify-content-end align-items-center mt-3">
		<div class="cursor-pointer me-3">
		  
		  
		</div>
		<button class="btn btn-primary">
		  <i class="bx bx-paper-plane me-1"></i>
		  <span class="align-middle">Balas</span>
		</button>
	  </div>
	  </form>
	  
	  
	</div>
  </div>
@endif


