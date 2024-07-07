@extends('layouts.index')
@push('style')
	<link rel="stylesheet" href="{{asset('assets/local/css/style.css')}}">
@endpush
@section('content')
<section class="form-02-main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="_lk_de">
					<div class="form-03-main">
						<div class="logo">
							<img src="{{asset('assets/local/img/logo-sit-permata-mojosari.jpg')}}">
						</div>
						<div class="form-group">
							<input type="email" name="email" class="form-control _ge_de_ol" type="text" placeholder="Enter Email" required="" aria-required="true">
						</div>
						
						<div class="form-group">
							<input type="password" name="password" class="form-control _ge_de_ol" type="text" placeholder="Enter Password" required="" aria-required="true">
						</div>
						
						{{-- <div class="checkbox form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="">
								<label class="form-check-label" for="">
									Remember me
								</label>
							</div>
						</div> --}}
						
						<div class="form-group">
							<div class="_btn_04">
								<a href="#">Login</a>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection