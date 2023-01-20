@extends('layouts.main')
 
@section('title', '')

@section('content')
<h1>Редактировать компанию</h1>
<a class="btn btn-secondary" href="{{ route('companies.index') }}">К списку компаний</a>
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

<h3>Текущий логотип</h3>
<img src="{{ asset('storage/logos/'.$company->logo) }}">

<form action="{{ route('companies.update', $company->id ) }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label for="name">Название</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ $company->name }}">
	</div>
	<div class="form-group">
		<label for="email">Электронная почта</label>
		<input type="email" class="form-control" name="email" id="email" value="{{ $company->email }}">
	</div>
	<div class="form-group">
		<label for="logo">Новый логотип</label>
		<input type="file" class="form-control" name="logo" id="logo">
	</div>
	<div class="form-group">
		<label for="address">Адрес</label>
		<input type="text" class="form-control" name="address" id="address" value="{{ $company->address }}">
	</div>
	<br>
	<button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>

@endsection