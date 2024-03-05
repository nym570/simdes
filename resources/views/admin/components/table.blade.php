<div class="table-responsive pb-5">
	
	{!! $dataTable->table(['class' => 'table table-striped mb-4'], true) !!}



</div>

     



@push('js')
{!! $dataTable->scripts() !!}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>


@endpush


