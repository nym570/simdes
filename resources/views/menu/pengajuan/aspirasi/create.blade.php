<x-app-layout title="Buat Aspirasi">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Buat Aspirasi') }}
			</h5>

			<div class="mb-4">
				<a href="{{ route('aspirasi.index') }}" class="btn btn-dark">
					{{ __('Kembali') }}
				</a>
			</div>

			@include('aspirasi._partials.form')

		</div>
	</div>
</x-app-layout>