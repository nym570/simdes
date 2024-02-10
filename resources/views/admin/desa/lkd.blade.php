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
				  <div class="row">
					<div class="col mb-3">
						<x-label for="nama_ketua_rt" :value="__('Nama Ketua RT*')" />
						<x-input type="text" name="nama_ketua_rt" id="nama_ketua_rt"  :value="old('nama_ketua_rt')" required/>
						<x-invalid error="nama_ketua_rt" />
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
					  <div class="row">
						<div class="col mb-3">
							<x-label for="nama_ketua_rw" :value="__('Nama Ketua RW*')" />
							<x-input type="text" name="nama_ketua_rw" id="nama_ketua_rw"  :value="old('nama_ketua_rw')" required/>
							<x-invalid error="nama_ketua_rw" />
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
					  <div class="row">
						<div class="col mb-3">
							<x-label for="nama_kepala_dusun" :value="__('Nama Kepala Dusun*')" />
							<x-input type="text" name="nama_kepala_dusun" id="nama_kepala_dusun"  :value="old('nama_kepala_dusun')" required/>
							<x-invalid error="nama_kepala_dusun" />
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
		<h5 class="modal-title" id="exampleModalLabel1">Assign Kepala Dusun</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formRole" class="mb-3" action="{{ route('roles.add-one') }}" data-remote="true" method="POST">
			@csrf
			<div class="modal-body">
				<x-input type="text" name="role" id="roleLKD"  value="" class="d-none" />
				<div class="row">
					<div class="col mb-3">
						<x-input type="text" name="user" id="userLKD"  value="" placeholder="Tidak Ditemukan" readonly />
					</div>
				</div>
				<div class="row">
					<div class="col mb-3">
						<label for="selectpickerLiveSearch" class="form-label">Username</label>
						<select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="Pilih pengguna baru" required name="user">
							@foreach($allUsers as $user)
								<option data-tokens="{{$user->username}}" value="{{$user->username}}">{{$user->username}} | {{$user->nama}}</option>
							@endforeach
						</select>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Assign')"/>
			</div>
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
		$(document).on('click','.open_modal',function(){
				let id= $(this).val();
				$.ajax({
					type : 'GET',
					url: "{{route('roles.get')}}",
					data : {id_role:id},
					success: function(msg){
						let data = JSON.parse(msg);
						$('#formRole').attr('action', data['link']);
						$('#roleLKD').val(data['role'].name);
						if(data['user']){
							$('#userLKD').val(data['user'].username);
						}
						else{
							$('#userLKD').val('');
						}
						
						$('#myModal').modal('show');
					},
					
				})
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
					
				})
			});
			
		})
	</script>



@endsection

@push('js')

{!! $rtDT->scripts() !!}
{!! $rwDT->scripts() !!}

{!! $dusunDT->scripts() !!}
<script>
	document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
		
    el.addEventListener('shown.bs.tab', () => {
        DataTable.tables({ visible: true, api: true }).columns.adjust();
		DataTable.tables({ visible: true, api: true }).columns.adjust();
		
    });
	
});

</script>

@endpush