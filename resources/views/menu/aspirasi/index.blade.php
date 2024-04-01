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
@endsection