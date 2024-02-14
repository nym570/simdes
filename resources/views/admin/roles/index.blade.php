@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Role') }}
			</h5>

			@include('admin.users._partials.table')

		</div>
	</div>


@endsection
