  <!-- Modal -->
  <div class="modal fade" id="domisiliModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Atur Domisili</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
			<div class="modal-body">
				<form id="formDomisili" class="mb-3"  data-remote="true" method="POST" enctype="multipart/form-data">
					@method('PUT')
					@csrf
					<input type="hidden" id="token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="col mb-3">
							<label for="dusun" class="form-label">Dusun*</label>
							<select id="dusun" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih dusun" name="dusun_id" required>
								
							</select>
							<x-invalid error="dusun_id" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
							<label for="rw" class="form-label">RW*</label>
							<select id="rw" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih RW" name="rw_id" required>
								
							</select>
							<x-invalid error="rw_id" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
							<label for="rt" class="form-label">RT*</label>
							<select id="rt" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih RT" name="rt_id" required>
								
							</select>
							<x-invalid error="rt_id" />
						</div>
					</div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Assign Domisili')"/>
			  </div>
			</form>
		</form>
	  </div>
	</div>
  </div>

     



@push('js')
  <script>
	$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
	$(document).on('click','.open_modal_domisili',function(){
				let link= $(this).attr('data-link');
				var ajax1 = $.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-dusun')}}",
					success: function(msg){
						$('#dusun').selectpicker('destroy');
						$('#dusun').html(msg);
						$('#dusun').selectpicker('render');
						$('#domisiliModal').modal('show');
						$('#formDomisili').attr('action',link);
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
	}); 
	$('#dusun').on('change',function(){
				$('#dusun').selectpicker('render');
				let id_dusun = $('#dusun').val();

				$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rw')}}",
					
					data : {id:id_dusun},

					success: function(msg){
						$('#rw').selectpicker('destroy');
						$('#rw').html(msg);
						$('#rw').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#rw').on('change',function(){
				$('#rw').selectpicker('render');
				let id_rw = $('#rw').val();

				$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rt')}}",
					
					data : {id:id_rw},

					success: function(msg){
						$('#rt').selectpicker('destroy');
						$('#rt').html(msg);
						$('#rt').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
  </script>
@endpush


