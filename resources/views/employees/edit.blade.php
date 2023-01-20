@extends('layouts.main')
 
@section('title', '')

@section('content')
<h1>Редактировать сотрудника</h1>
<a class="btn btn-secondary" href="{{ route('employees.index') }}">К списку сотрудников</a>
<hr>

@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<form action="{{ route('employees.update', $employee->id ) }}" method="POST">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label for="company_id">Компания</label>
		<select class="form-select" name="company_id" id="company_id">
			@foreach ($companies as $company)
			<option value="{{ $company->id }}" @if ($company->id == $employee->company_id) selected @endif>{{ $company->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="name">Имя</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ $employee->name }}">
	</div>
	<div class="form-group">
		<label for="email">Электронная почта</label>
		<input type="email" class="form-control" name="email" id="email" value="{{ $employee->email }}">
	</div>
	<div class="form-group">
		<label for="phone">Телефон</label>
		<input type="phone" class="form-control" name="phone" id="phone" value="{{ $employee->phone }}">
	</div>
	<br>
	<button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>

@endsection