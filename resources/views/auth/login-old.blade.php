@extends('layout.index')
@push('style')
<style>
	.demo{ background: #F2F2F2; }
	.form-container{
		background: #ecf0f3;
		font-family: 'Nunito', sans-serif;
		padding: 40px;
		border-radius: 20px;
		box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
	}
	.form-container .form-icon{
		color: #52cf42;
		font-size: 55px;
		text-align: center;
		line-height: 100px;
		width: 100px;
		height:100px;
		margin: 0 auto 15px;
		border-radius: 50px;
		box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px #fff;
	}
	.form-container .title{
		color: #52cf42;
		font-size: 25px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1px;
		text-align: center;
		margin: 0 0 20px;
	}
	.form-container .form-horizontal .form-group{ margin: 0 0 25px 0; }
	.form-container .form-horizontal .form-group label{
		font-size: 15px;
		font-weight: 600;
		text-transform: uppercase;
	}
	.form-container .form-horizontal .form-control{
		color: #333;
		background: #ecf0f3;
		font-size: 15px;
		height: 50px;
		padding: 20px;
		letter-spacing: 1px;
		border: none;
		border-radius: 50px;
		box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px #fff;
		display: inline-block;
		transition: all 0.3s ease 0s;
	}
	.form-container .form-horizontal .form-control:focus{
		box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px #fff;
		outline: none;
	}
	.form-container .form-horizontal .form-control::placeholder{
		color: #808080;
		font-size: 14px;
	}
	.form-container .form-horizontal .btn{
		color: #000;
		background-color: #52cf42;
		font-size: 15px;
		font-weight: bold;
		text-transform: uppercase;
		width: 100%;
		padding: 12px 15px 11px;
		border-radius: 20px;
		box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px #fff;
		border: none;
		transition: all 0.5s ease 0s;
	}
	.form-container .form-horizontal .btn:hover,
	.form-container .form-horizontal .btn:focus{
		color: #fff;
		letter-spacing: 3px;
		box-shadow: none;
		outline: none;
	}
</style>
@endpush
@section('content')
<div class="form-bg">
	<div class="container">
		<div class="row min-vh-100">
			<div class="col-md-4 offset-md-4">
				<div class="form-container align-middle">
					<div class="form-icon"><i class="fa fa-user"></i></div>
					<h3 class="title">Login</h3>
					<form id="formLogin" class="form-horizontal">
						<div class="form-group">
							<label>username</label>
							<input class="form-control" type="text" name="username" placeholder="username">
						</div>
						<div class="form-group">
							<label>password</label>
							<input class="form-control" type="password" name="password" placeholder="password">
						</div>
						<button type="button" class="btn btn-default btnLogin">Login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
	var routeLogin = "{{route('auth.doLogin')}}"
	var routeDashboard = "{{route('dashboard')}}"
</script>
<script src="{{asset('assets/local/js/login.js')}}"></script>
@endpush