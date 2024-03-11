
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Kedatangan') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
<a class="btn btn-primary mb-4" href="{{route('dinamika.kedatangan.create')}}">
	Tambah Data Kedatangan
  </a>

  

			</div>

			@include('menu.dinamika._partials.table')
	  <!--/ Create App Modal -->
		</div>
	</div>
	

	<form method="POST" class="d-none" id="verif-form">
		@csrf
		@method("PUT")
	</form>


		
		
<script>
	function verif(element) {
		event.preventDefault()
		let form = document.getElementById('verif-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Yakin ingin verifikasi data kedatangan ?', `Setelah verifikasi, warga akan diubah status dan rutanya`, 'Ya! verif', () => {
			form.submit()
		})
	}
</script>




@endsection

