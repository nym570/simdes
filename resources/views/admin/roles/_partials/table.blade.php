<div class="table-responsive">
	<table class="table table-striped table-bordered mb-4">
		<thead>
			<tr>
				<th>{{ __('#') }}</th>
				<th>{{ __('Username') }}</th>
				<th>{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@forelse($users as $user)
			<tr>
				<td style="width: 10%">{{ $loop->iteration}}</td>
				<td style="width: 25%">{{ $user->username }}</td>
				<td style="width: 25%">
					@if($role->name != 'warga')
						<button href={{route('users.hapusRole', $user)}} class="btn btn-sm btn-danger my-1" onclick='del(this)'>Hapus Role User</button>
					@endif
					
					<a href="{{route('users.show', $user)}}"><button  class="btn btn-sm btn-dark my-1">Lihat User</button></a>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="100%" class="text-center">
					{{ __('Data tidak ditemukan.') }}
				</td>
			</tr>
			@endforelse
		</tbody>
	</table>

	<form method="POST" class="d-none" id="delete-form">
		@csrf
		<x-input type="text" name="role" id="role" value="{{$role->name}}" />
	</form>

	{!! $users->links() !!}
</div>

@push('js')
<script>
	function del(element) {
		event.preventDefault()
		let form = document.getElementById('delete-form');
		form.setAttribute('action', element.getAttribute('href'));
		swalConfirm('Yakin menghapus user dari role?', `User tidak dihapus, hanya role dihapus dari user`, 'Ya, hapus', () => {
			form.submit()
		})
	}
	
</script>
@endpush