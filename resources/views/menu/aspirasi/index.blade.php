@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Manajemen Aspirasi') }}
			</h5>

			@include('components.table')

		</div>
	</div>
	<form method="POST" class="d-none" id="status-form">
		@csrf
		@method("PUT")
	</form>
	<script>
		function change(element) {
		event.preventDefault()
		let form = document.getElementById('status-form');
		form.setAttribute('action', element.getAttribute('href'))
		swalConfirm('Ubah Status Aspirasi ?', `Status aspirasi akan diubah`, 'Ubah', () => {
			form.submit()
		})
	}
	</script>
@endsection