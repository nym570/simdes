@extends('layouts.app')
@section('container')

	<div class="card">
		<div class="card-body">
			

			
				<!-- Button trigger modal -->
    

	<div class="mb-4">
		<a href="{{route('warga.index')}}" class="btn btn-dark"> Kembali </a>
	</div>
	<div class="card text-center">
		<div class="card-header">
		  <ul class="nav nav-pills card-header-pills" role="tablist">
			<li class="nav-item">
			  <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#navs-pills-within-card-active" role="tab">Biodata</button>
			</li>
			<li class="nav-item">
			  <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#navs-pills-within-card-link" role="tab">Lainnya</button>
			</li>

		  </ul>
		</div>
		<div class="card-body">
		  <div class="tab-content p-0">
			<div class="tab-pane fade show active" id="navs-pills-within-card-active" role="tabpanel">
			  <h4>Nama</h4>
			</div>
			<div class="tab-pane fade" id="navs-pills-within-card-link" role="tabpanel">
			  <h4 class="card-title">Special link title</h4>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="javascript:void(0)" class="btn btn-secondary">Go somewhere</a>
			</div>
		  </div>
		</div>
		</div>

		</div>
	</div>




@endsection
