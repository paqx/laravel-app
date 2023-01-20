@extends('layouts.main')
 
@section('title', 'Сотрудники')

@section('content')
<h1>Сотрудники</h1>
<a class="btn btn-primary" href="{{ route('employees.create') }}">Создать сотрудника</a>
<hr>
@if (Session::has('message'))
<div class="alert alert-success">
	{{ Session::get('message') }}
</div>
@endif
<table class="table table-bordered yajra-datatable">
	<thead>
		<tr>
			<th>Имя</th>
			<th>Электронная почта</th>
			<th>Телефон</th>
			<th>Компания</th>
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
        ajax: '{{ route('employees.index') }}',
        serverSide: true,
        processing: true,
        columns: [
            {data: 'name', name: 'name'},
			{data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
			{data: 'company_name', name: 'company_name'},
			{data: 'actions', name: 'actions'}
        ]
    });
})
</script>
@endpush