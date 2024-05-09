@extends('layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Bantuan & Panduan') }}
			</h5>

			
			<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title" id="judulView"></h4>
					  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body" id="isi">
						
					<div class="mb-3" id="textIsi">
			
					</div>
					  <div class="mb-3" id="pdfIsi">
					  </div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  @include('components.table')
		</div>
	</div>
	<form method="POST" class="d-none" id="delete-form">
		@csrf
		@method("DELETE")
	</form>
	<script>
		
		$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		
				$.ajax({
					type : 'GET',
					url: "{{route('master.panduan.get-kategori')}}",
					
					success: function(msg){
						$('#category').selectpicker('destroy');
						$('#category').html(msg);
						$('#category').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		
	});
	$(function() {
		$(document).on('click','.open_modal_info',function(){
			$('#textIsi').empty();
				$('#pdfIsi').empty();
				$('#judulModal').empty();
				let route= $(this).val();
				let pdf = $(this).attr("data-pdf");
				$.ajax({
					type : 'GET',
					url: route,
					success: function(msg){
						
						let data = JSON.parse(msg);
						$('#judulView').text(data.judul);
						if(data.lampiran){
							$("#pdfIsi").append('<iframe id="pdfIsi" src="'+pdf+'" width="100%" height="1000px"></iframe>');
							
						}
						if(data.keterangan){
							$('#textIsi').append('<h5>Ringkasan</h5>');
							$('#textIsi').append(data.keterangan);
						}
						$('#modalInfo').modal('show');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
				
			}); 	
	});
	
		
	</script>

@endsection
