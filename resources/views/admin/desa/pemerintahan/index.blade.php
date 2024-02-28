@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">
				{{ __('Daftar Perangkat Pemerintahan Desa') }}
			</h5>

			<div class="mb-4">
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPemerintahan">
	Tambah Perangkat
  </button>
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importExcel">
	Import Excel
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="addPemerintahan" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Tambah Perangkat Desa</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('m.pemerintahan.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" id="token" value="{{ csrf_token() }}">
			<div class="modal-body">
				<div class="row mb-3">
					<div class="col">
						<label for="nik" class="form-label">NIK Perangkat</label>
						<select id="nik" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih NIK" name="nik" required>
							
						</select>
						<x-invalid error="nik" />
					</div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="jabatan" :value="__('Jabatan*')" />
					<x-input type="text" name="jabatan" id="jabatan" :placeholder="__('Nama Jabatan')" :value="old('jabatan')" required/>
					<x-invalid error="jabatan" />
				  </div>
				</div>
				<div class="row">
				  <div class="col mb-3">
					<label for="tugas" class="form-label">Tugas*</label>
					<input id="tugas" type="hidden" name="tugas" value="{{old('tugas')}}" required>
					<trix-editor input="tugas" ></trix-editor>
				  </div>
				</div>
				<div class="row">
					<div class="col mb-3">
					  <label for="wewenang" class="form-label">Wewenang*</label>
					  <input id="wewenang" type="hidden" name="wewenang" value="{{old('wewenang')}}" required>
					  <trix-editor input="wewenang" ></trix-editor>
					</div>
				  </div>

				  <div class="row">
					<div class="col mb-3">
						<x-label for="foto" :value="__('Foto (.png/.jpg)*')"/>
						<x-input class="foto" type="file" id="foto" name="foto" required/>
						<x-invalid error="foto" />
					  </div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Tambah Perangkat')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>
  @include('admin.admin._partials.import')
			</div>

			@include('admin.admin._partials.table')

		</div>
	</div>

<script>
	$( document ).ready(function() {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
				$.ajax({
					type : 'GET',
					url: "{{route('get-warga')}}",
					success: function(msg){
						$('#nik').selectpicker('destroy');
						$('#nik').html(msg);
						$('#nik').selectpicker('render');
						
						
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
				});
		
	});
</script>

@if ($errors->has('import'))
    <script type="text/javascript">
	
        $( document ).ready(function() {
			
             $('#importExcel').modal('show');
        });

    </script>
	
@endif


@endsection

