@extends('layouts.main')
 
@section('title', '')

@section('content')
<h1>Создать компанию</h1>
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

<form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="name">Название</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
	</div>
	<div class="form-group">
		<label for="email">Электронная почта</label>
		<input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
	</div>
	<div class="form-group">
		<label for="logo">Логотип</label>
		<input type="file" class="form-control" name="logo" id="logo">
	</div>
	<div class="form-group">
		<label for="address">Адрес</label>
		<input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
	</div>
	<br>
	<button type="submit" class="btn btn-primary">Создать компанию</button>
</form>

@endsection