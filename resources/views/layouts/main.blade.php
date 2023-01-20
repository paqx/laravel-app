<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<div class="navbar-nav">
					<a class="nav-item nav-link" href="{{ route('home') }}">Главная</a>
					<a class="nav-item nav-link" href="{{ route('companies.index') }}">Компании</a>
					<a class="nav-item nav-link" href="{{ route('employees.index') }}">Сотрудники</a>
					<a class="nav-item nav-link" href="{{ route('logout') }}">Выйти</a>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col">
					@yield('content')
				</div>
			</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
	@stack('scripts')
</html>
