@extends('admin.layouts.app')
@section('container')
	<div class="card">
		<div class="card-body">
			
			<div class="nav-align-top">
				<ul class="nav nav-pills mb-3" role="tablist">
				  <li class="nav-item">
					<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-dusun" aria-controls="navs-pills-top-dusun" aria-selected="true">Dusun</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-rw" aria-controls="navs-pills-top-rw" aria-selected="false">RW</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-rt" aria-controls="navs-pills-top-rt" aria-selected="false">RT</button>
				  </li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show " id="navs-pills-top-dusun" role="tabpanel">
						<div class="mb-4">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#tambahDusun">
								+ Buat Dusun
							</button>
							
							
							
						</div>
						<h5 class="mb-4">Daftar Dusun</h5>
						{!! $dusunDT->table() !!}
						
				  </div>
				  <div class="tab-pane fade " id="navs-pills-top-rw" role="tabpanel">
					<div class="mb-4">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#tambahRW" id="buttonRW">
							+ Buat RW
						</button>
						
					</div>
					<h5 class="mb-4">Daftar RW</h5>
					
						{!! $rwDT->table() !!}
						
						
					
				  </div>
				  <div class="tab-pane fade" id="navs-pills-top-rt" role="tabpanel">
					<div class="mb-4">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#tambahRT" id="buttonRT">
							+ Buat RT
						</button>
						
					</div>
					<h5 class="mb-4">Daftar RT</h5>
					
						{!! $rtDT->table() !!}
					
				  </div>
				  
				</div>
			  </div>

			

			

		</div>
	</div>
<!-- Modal -->
<div class="modal fade" id="tambahRT" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel1">Buat RT</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		
		<form id="formAuthentication" class="mb-3" action="{{ route('m.lkd.rt.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" id="token" value="{{ csrf_token() }}">
			
			<div class="modal-body">
				
				<div class="row">
					<div class="col mb-3">
						<label for="dusunMRT" class="form-label">Dusun*</label>
						<select id="dusunMRT" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih dusun" name="dusun_id" required>
							
						</select>
						<x-invalid error="dusun_id" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="rwMRT" class="form-label">RW*</label>
						<select id="rwMRT" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih RW" name="rw_id" required>
							
						</select>
						<x-invalid error="rw_id" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
					  <x-label for="name" :value="__('Nomor RT*')" />
					  <x-input type="number" name="name" id="name"  :value="old('name')" min=1 :placeholder="__('Nomor RT')" required/>
					  <x-invalid error="name" />
					</div>
				  </div>
				  
				  
				
				
			</div>
			<div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat RT')"/>
			</div>
		</form>
	</div>
	</div>
</div>

	<!-- Modal -->
	<div class="modal fade" id="tambahRW" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Buat RW</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<form id="formAuthentication" class="mb-3" action="{{ route('m.lkd.rw.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				
				<div class="modal-body">
					
					<div class="row">
						<div class="col mb-3">
							<label for="dusunMRW" class="form-label">Dusun*</label>
							<select id="dusunMRW" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih dusun" name="dusun_id" required>
								
							</select>
							<x-invalid error="dusun_id" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
						  <x-label for="name" :value="__('Nomor RW*')" />
						  <x-input type="number" name="name" id="name"  :value="old('name')" min=1 :placeholder="__('Nomor RW')" required/>
						  <x-invalid error="name" />
						</div>
					  </div>
					  
					  
					
					
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat RW')"/>
				</div>
			</form>
		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="tambahDusun" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel1">Buat Dusun</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<form id="formAuthentication" class="mb-3" action="{{ route('m.lkd.dusun.store') }}" data-remote="true" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				
				<div class="modal-body">

				
					<div class="row">
						<div class="col mb-3">
						  <x-label for="name" :value="__('Nama Dusun*')" />
						  <x-input type="text" name="name" id="name"  :value="old('name')" :placeholder="__('Masukkan nama dusun (contoh: Suko)')" required/>
						  <x-invalid error="name" />
						</div>
					  </div>
					  
					  
					
					
				</div>
				<div class="modal-footer">
					<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Buat Dusun')"/>
				</div>
			</form>
		</div>
		</div>
	</div>

	
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="judulModal"></h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formRole" class="mb-3" data-remote="true" method="POST">
			@method('PUT')
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<x-input type="text" name="user" id="userLKD"  value="" placeholder="Tidak Ditemukan" readonly />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="selectpickerLiveSearch" class="form-label">Username</label>
						<select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pengguna baru" required name="pemimpin">
							
						</select>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Assign')"/>
				<x-button type="button" id="remove" class="btn btn-danger d-grid w-100 d-none" onclick="del(this)" href="" :value="__('Hapus Pemimpin')"/>
			</div>
		</form>
	</div>
	</div>
</div>
	
<form method="POST" class="d-none" id="delete-form">
	@csrf
	@method("PUT")
</form>





@endsection

@push('js')

{!! $rtDT->scripts() !!}
{!! $rwDT->scripts() !!}

{!! $dusunDT->scripts() !!}


<script>
		
	$( document ).ready(function() {
		
		$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
		
	});
	function del(element) {
	event.preventDefault()
	let form = document.getElementById('delete-form');
	form.setAttribute('action', element.getAttribute('href'));
	$('#myModal').modal('hide');
	swalConfirm('Yakin menghapus pemimpin wilayah ?', `Posisi akan kosong`, 'Ya! Hapus', () => {
		form.submit()
	})
}
	$(document).on('click','.open_modal',function(){
		let link= $(this).attr('data-link');
		let name= $(this).attr('data-name');
		let kode= $(this).attr('data-kode');
			var ajax1= $.ajax({
				type : 'GET',
				url: link,
				success: function(msg){
					 let data = JSON.parse(msg);
					
					
					 $('#judulModal').text('Assign Kepala/Ketua : '+data['lkd'].name);
					$('#formRole').attr('action', data['link']);
					if(data['lkd'].pemimpin){
						$('#userLKD').val(data['lkd'].pemimpin.username);
						$('#remove').removeClass('d-none');
						$('#remove').attr('href',data['delete']);
					}
					else{
						$('#userLKD').val('');
						$('#remove').addClass('d-none');
					}
					
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			});
			var ajax2 = $.ajax({
				type : 'GET',
				url: "{{route('roles.user-list.pemimpin')}}",
				data: {kode:kode, name:name},
				success: function(msg){
					$('#selectpickerLiveSearch').selectpicker('destroy');
					$('#selectpickerLiveSearch').html(msg);
					$('#selectpickerLiveSearch').selectpicker('render');
					
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			});
			$.when(ajax1, ajax2).done(function(data, data1) {
			$('#myModal').modal('show');
		});
			}); 
			
			
</script>
<script>
	
	$(function(){
		$('#buttonRW').on('click',function(){
			
			$.ajax({
				type : 'GET',
				url: "{{route('master-desa.get-dusun')}}",
				success: function(msg){
					$('#dusunMRW').selectpicker('destroy');
					$('#dusunMRW').html(msg);
					$('#dusunMRW').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#buttonRT').on('click',function(){
			
			$.ajax({
				type : 'GET',
				url: "{{route('master-desa.get-dusun')}}",
				success: function(msg){
					$('#dusunMRT').selectpicker('destroy');
					$('#dusunMRT').html(msg);
					$('#dusunMRT').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		$('#dusunMRT').on('change',function(){
			$('#dusunMRT').selectpicker('render');
			let id_dusun = $('#dusunMRT').val();

			$.ajax({
				type : 'GET',
				url: "{{route('master-desa.get-rw')}}",
				
				data : {id:id_dusun},

				success: function(msg){
					$('#rwMRT').selectpicker('destroy');
					$('#rwMRT').html(msg);
					$('#rwMRT').selectpicker('render');
				},
				error: function (xhr) {
					var err = JSON.parse(xhr.responseText);
					alert(err.message);
				}
				
			})
		});
		
	})
</script>

<script>
	document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
		
    el.addEventListener('shown.bs.tab', () => {
        DataTable.tables({ visible: true, api: true }).columns.adjust();
		DataTable.tables({ visible: true, api: true }).columns.adjust();
		
    });
	
});

</script>

@endpush
