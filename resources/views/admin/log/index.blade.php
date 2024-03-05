@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title mb-4">
				{{ __('Daftar Log') }}
			</h5>

			

			
	
				@include('admin.components.table')
			
			
				<form method="POST" class="d-none" id="status-form">
					@csrf
					@method("PUT")
				</form>
			
			
			
				 
			
			
			
			
			
			

		</div>
	</div>

@endsection

