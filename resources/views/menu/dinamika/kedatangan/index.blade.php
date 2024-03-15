
@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Kedatangan') }}
			</h5>
@if(auth()->user()->hasRole('ketua rt'))
			<div class="mb-4">
				<!-- Button trigger modal -->
<a class="btn btn-primary mb-4" href="{{route('dinamika.kedatangan.create')}}">
	Tambah Data Kedatangan
  </a>

  

			</div>
@endif
			@include('components.table')
			@include('menu.dinamika._partials.show')
	  <!--/ Create App Modal -->
		</div>
	</div>
	

	<form method="POST" class="d-none" id="verif-form">
		@csrf
		@method("PUT")
	</form>


		
	@if(auth()->user()->hasRole('ketua rt'))	
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

@endif
<script>
$(document).on('click','.open_modal_lihat',function(){
			$('#biodata').empty();
				let url= $(this).val();
				$.ajax({
					type : 'GET',
					url: url,
					beforeSend: function(){
						$('#loading').show();
					},
					complete: function(){
						$('#loading').hide();
					},
					success: function(msg){
						
						let data = JSON.parse(msg);
						$('#title').html('Detail Kedatangan');
						
						
						$('#biodata').append('<p><strong>Waktu Kedatangan : </strong>'+data.waktu.split('T')[0]+'</p>');
						if(data.is_new){
							$('#biodata').append('<p><strong>Rumah Tangga : </strong>'+'Baru'+'</p>');
						}
						else{
							$('#biodata').append('<p><strong>Rumah Tangga : </strong>'+'Menumpang'+'</p>');
						}
						$('#biodata').append('<p><strong>Pendatang : </strong></p>');
						for(var i=0; i<data.dinamika.length; i++){
							$('#biodata').append('<p><strong>+ </strong>'+data.dinamika[i].warga.nama+' ['+data.dinamika[i].warga.nik+']</p>');
						}
						if(data.keterangan!=null){
							$('#biodata').append('<p><strong>Keterangan : </strong></p><p>'+data.keterangan+'</p>');
						}
						
						$('#biodata').append('<div class="mt-2"><h5 class=" text-center">Foto Bukti</h5><img class="w-75 mx-auto d-block" src="/storage/' + data.bukti + '"/></div>');
						$('#modalLihat').modal('show');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
			}); 
</script>


@endsection

