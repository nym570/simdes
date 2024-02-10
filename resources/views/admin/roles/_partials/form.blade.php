
<form action="{{ !is_null($role->id) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
	@csrf
	@if(!is_null($role->id))
	@method("PUT")
	@endif

	<div class="mb-2">
		<x-label for="name" :value="__('Nama Role')" />
		<x-input type="text" name="name" id="name" :placeholder="__('Nama Role')" :value="old('name', $role->name)" autofocus />
		<x-invalid error="name" />
	</div>
	<div class="mb-5">
		<label for="category" class="form-label" >Kategori</label>
			<select class="form-select" id="category" aria-label="category" name="category">
				<option value="perangkat desa" {{old('category',$role->category)=="perangkat desa"  ? 'selected' : ''}}>Perangkat Desa</option>
				<option value="kemasyarakatan" {{old('category',$role->category)=="kemasyarakatan"  ? 'selected' : ''}}>Kemasyarakatan</option>
				<option value="lainnya" {{old('category',$role->category)=="lainnya"  ? 'selected' : ''}}>Lainnya</option>
			</select>
		
	</div>

	<div class="col-12">
		<h5>Izin Akses Manajemen</h5>
		<!-- Permission table -->
		<div class="table-responsive">
		  <table class="table table-flush-spacing">
			<tbody>
			  
				@forelse($permissions->keys() as $category)
				<tr>
					<td class="text-nowrap fw-medium">{{$category}}</td>
					<td>
					  <div class="d-flex">
						@forelse($permissions[$category] as $item)
						@if (str_contains($item->name, 'all'))
						<div class="form-check me-3 me-lg-5">
							@if($role->id)
								<input class="form-check-input " name="permission[]" type="checkbox" id = "checkAll" value="{{$item->id}}" {{ in_array($item->id, $rolePermissions) ? 'checked' : '' }}/>
							@else
							<input class="form-check-input " name="permission[]" type="checkbox" id = "checkAll" value="{{$item->id}}"/>
							@endif
								<label class="form-check-label" for="{{$item->name}}">
							  {{$item->name}}
							</label>
						  </div>
						@else
						<div class="form-check me-3 me-lg-5">
							@if($role->id)
								<input class="form-check-input checkItem" name="permission[]" type="checkbox"  value="{{$item->id}}" {{ in_array($item->id, $rolePermissions) ? 'checked' : '' }}/>
							@else
							<input class="form-check-input checkItem" name="permission[]" type="checkbox"  value="{{$item->id}}" />
							@endif
							
							<label class="form-check-label" for="{{$item->name}}">
							  {{$item->name}}
							</label>
						  </div>
						@endif
						@empty
						
						@endforelse
					  </div>
					</td>
				  </tr>
				  
				@empty
				@endforelse
				
			  
			</tbody>
		  </table>
		</div>

	

	<div class="text-end mt-5">
		<x-button type="submit" class="btn btn-primary" :value="!is_null($role->id) ? __('Update') : __('Buat')" />
	</div>


</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
// $('.checkAll').click(function(event) {  
// 	var cat = $('.checkAll').attr('data-class'); 
// 	console.log(cat);
//     if(this.checked) {
//         // Iterate each checkbox
//         $(':checkbox').each(function() {
//             this.checked = true;                        
//         });
//     } else {
//         $(':checkbox').each(function() {
//             this.checked = false;                       
//         });
//     }
// }); 

$('td input[type="checkbox"]').on('change', function () {
    var cell = $(this).closest('div'),
        row = cell.parent(),
        checkItems = row.find('.checkItem');
		
    if (cell.is(':first-child')) {
        checkItems.prop('checked', false);
		
    } else {
        var all = row.find('div:first-child input')
            .prop('checked', checkItems.length === checkItems.filter(':checked').length);
		if(checkItems.length === checkItems.filter(':checked').length){
			checkItems.prop('checked', false);
		}
		
    }
});
</script>
