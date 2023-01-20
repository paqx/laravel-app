@extends('layouts.main')
 
@section('title', 'Компании')

@section('content')
<h1>Компании</h1>
<a class="btn btn-primary" href="{{ route('companies.create') }}">Создать компанию</a>
<hr>
@if (Session::has('message'))
<div class="alert alert-success">
	{{ Session::get('message') }}
</div>
@endif
<table class="table table-bordered yajra-datatable">
	<thead>
		<tr>
			<th>Название</th>
			<th>Электронная почта</th>
			<th>Адрес</th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.yajra-datatable').DataTable({
        ajax: '{{ route('companies.index') }}',
        serverSide: true,
        processing: true,
        columns: [
            {data: 'name', name: 'name'},
			{data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
			{data: 'actions', name: 'actions'}
        ]
    });
})
</script>
@endpush