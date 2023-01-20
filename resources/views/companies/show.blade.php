@extends('layouts.main')
 
@section('title', '')

@section('content')
<h1>{{ $company->name }}</h1>
<a class="btn btn-primary" href="{{ route('companies.index') }}">К списку компаний</a>
<hr>
<dl>
	<dt>Электронная почта</dt>
	<dd>{{ $company->email }}</dd>
	<dt>Логотип</dt>
	<dd><img src="{{ asset('storage/logos/'.$company->logo) }}"></dd>
	<dt>Адрес</dt>
	<dd>{{ $company->address }}</dd>
</dl>

<h3>Сотрудники</h3>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Имя</th>
			<th>Электронная почта</th>
			<th>Телефон</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($company->employees as $employee)
		<tr>
			<td>{{ $employee->name }}</td>
			<td>{{ $employee->email }}</td>
			<td>{{ $employee->phone }}</td>
		</tr>
		@endforeach
	</tbody>
</table>

<h3>Карта</h3>
<div id="map" style="width: 600px; height: 400px"></div>

@endsection

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?apikey=ваш API-ключ&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
        ymaps.ready(init);
        function init(){
            var myMap = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 7
            });
        }
</script>
@endpush