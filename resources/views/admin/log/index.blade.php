@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title mb-4">
				{{ __('Daftar Log') }}
			</h5>

			

			<div class="table-responsive pb-5">
	
				{!! $dataTable->table() !!}
			
			
				<form method="POST" class="d-none" id="status-form">
					@csrf
					@method("PUT")
				</form>
			
			</div>
			
				 
			
			
			
			
			
			

		</div>
	</div>

<script>
	$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
	$(function(){
		$('#nik').on('change',function(){
			let nik = $('#nik').val();
			$.ajax({
					type : 'POST',
					url: "{{route('users.nik')}}",
					data : {'nik':nik},
					success: function(msg){
						if($.isEmptyObject(msg.error)){
							$('#error_check_nik').empty();
							$('#no_kk').prop('readonly', false);
						}
						else{
							
								$('#error_check_nik').text(msg.error);
								$('#no_kk').prop('readonly', true);
							
						}
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
		});
		$('#no_kk').on('change',function(){
			let nik = $('#nik').val();
			let no_kk = $('#no_kk').val();
			$.ajax({
					type : 'POST',
					url: "{{route('users.kk')}}",
					data : {'nik':nik, 'no_kk':no_kk},
					success: function(msg){
						if($.isEmptyObject(msg.error)){
							$('#error_check_kk').empty();
						}
						else{
							$('#error_check_kk').text(msg.error);
						}
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
		});
		
	})
</script>
@if (count($errors) > 0)
    <script type="text/javascript">
	
        $( document ).ready(function() {
			
             $('#addUser').modal('show');
        });

    </script>
	@if(!$errors->has('nik'))
		<script type="text/javascript">
	
		$('#no_kk').prop('readonly', false);
	
		</script>
	@endif
@endif


@endsection
@push('js')
			{!! $dataTable->scripts() !!}
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
			<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
			<script src="/vendor/datatables/buttons.server-side.js"></script>
			<script>
			  
			</script>
			<script>
				function change(element) {
					event.preventDefault()
					let form = document.getElementById('status-form');
					form.setAttribute('action', element.getAttribute('href'))
					swalConfirm('Ubah Status ?', `Status admin akan diubah`, 'Ubah', () => {
						form.submit()
					})
				}
			</script>
			@endpush
			

