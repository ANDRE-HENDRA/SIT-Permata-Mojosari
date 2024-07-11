@extends('layout.index')
@section('content')
<div class="login-box">
	<!-- /.login-logo -->
	<div class="card card-outline card-primary">
		<div class="card-header text-center">
			<a href="#" class="h1"><b>SIT Permata Mulia</b><br>Mojosari</a>
			<br><img src="{{ asset('img')}}/logo.jpeg" alt="SIT Permata Mojosari" height="100" width="100">
		</div>
		<div class="card-body">
			<p class="login-box-msg">Masukkan Username dan Password</p>
			
			<form id="formLogin">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Username" name="username">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" class="form-control" placeholder="Password" name="password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<button type="submit" class="btn btn-primary btn-block btnLogin">Login</button>
					</div>
				</div>
			</form>
			
			<p class="mt-2 mb-0">
				<a class="text-center">Register a new Account? call Admin</a>
			</p>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>
<!-- /.login-box -->
@endsection
@push('script')
<script>
	var routeLogin = "{{route('auth.doLogin')}}"
	var routeDashboard = "{{route('dashboard')}}"
</script>
<script src="{{asset('assets/local/js/login.js')}}"></script>
@endpush