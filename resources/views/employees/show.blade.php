@extends('layouts.main')
 
@section('title', '')

@section('content')
<h1>{{ $employee->name }}</h1>
<a class="btn btn-primary" href="{{ route('employees.index') }}">К списку сотрудников</a>
<hr>
<dl>
	<dt>Компания</dt>
	<dd>{{ $company_name }}</dd>
	<dt>Электронная почта</dt>
	<dd>{{ $employee->email }}</dd>
	<dt>Телефон</dt>
	<dd>{{ $employee->phone }}</dd>
</dl>

@endsection