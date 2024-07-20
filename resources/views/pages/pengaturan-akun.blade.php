@extends('layout.index')
@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<!-- Horizontal Form -->
				<div class="card card-info">
					<!-- form start -->
					<div class="card-body">
						<form class="form-horizontal" id="formAkun">
							<div class="form-group row">
								<label for="nama" class="col-sm-2 col-form-label">Nama</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="name" name="name" placeholder="nama anda" value="{{$user->name}}">
								</div>
							</div>
							<div class="form-group row">
								<label for="username" class="col-sm-2 col-form-label">username</label>
								<div class="col-sm-10">
									<input type="username" class="form-control" id="username" placeholder="username anda" disabled value="{{$user->username}}">
								</div>
							</div>
							<div class="form-group row">
								<label for="password" class="col-sm-2 col-form-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="password" name="password" placeholder="password anda" >
								</div>
							</div>
						</form>
						
					</div>
					<!-- /.card-body -->
					<div class="card-footer">
						<button type="button" class="btn btn-info btnSimpan">Perbarui</button>
						<button type="button" class="btn btn-danger ml-2 btnModalPassword">Ubah Password</button>
					</div>
					<!-- /.card-footer -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
			
		</div>
		
	</div><!-- /.container-fluid -->
</section>

<!-- Modal -->
<div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ubahPasswordModalLabel">UBAH PASSWORD</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div>
			<div class="modal-body">
				<form id="formPassword">
					<div class="row">
						<div class="mb-3 col-12">
							<label for="password_baru" class="form-label">Password Lama *</label>
							<div class="input-group">
								<input type="password" class="form-control border-end-0" id="password_lama" name="password_lama" placeholder="Password"> 
								<div class="input-group-append" id="show_hide_password">
									<a href="javascript:;" class="input-group-text bg-transparent" onclick="ubahPassword(this)"><i class='fa fa-eye-slash'></i></a>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="mb-3 col-12">
							<label for="password_baru" class="form-label">Password Baru *</label>
							<div class="input-group">
								<input type="password" class="form-control border-end-0" id="password_baru" name="password_baru" placeholder="Password"> 
								<div class="input-group-append" id="show_hide_password">
									<a href="javascript:;" class="input-group-text bg-transparent" onclick="ubahPassword(this)"><i class='fa fa-eye-slash'></i></a>
								</div>
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="ulangi_password_baru" class="form-label">Ulangi Password Baru *</label>
							<div class="input-group">
								<input type="password" class="form-control border-end-0" id="ulangi_password_baru" name="ulangi_password_baru" placeholder="Password">
								<div class="input-group-append" id="show_hide_password">
									<a href="javascript:;" class="input-group-text bg-transparent" onclick="ubahPassword(this)"><i class='fa fa-eye-slash'></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btnSimpanPassword">SIMPAN</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
	var modalPassword = new bootstrap.Modal(document.getElementById('ubahPasswordModal'), {
		backdrop: 'static',
		keyboard: false
	})
	
	$('.btnModalPassword').click((e) => {
		modalPassword.show()
	})

	function ubahPassword(ini){
		const type = $(ini).parent().prev().attr('type')
		// const type = $('#input').attr('type')
		if(type=='text'){
			$(ini).parent().prev().attr('type', 'password')
			$(ini).children('i').addClass('fa-eye-slash')
			$(ini).children('i').removeClass('fa-eye')
			return // die()
		}
		$(ini).parent().prev().attr('type', 'text')
		$(ini).children('i').removeClass('fa-eye-slash')
		$(ini).children('i').addClass('fa-eye')
	}

	$('.btnSimpan').click((e) => {
		e.preventDefault()
		var data = new FormData($('#formAkun')[0])
		$('.btnSimpan').attr('disabled',true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>LOADING...')
		$.ajax({
				url: '{{route("pengaturanAkun.store")}}',
				type: 'POST',
				data: data,
				async: true,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status=='success'){
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: data.message,
							showConfirmButton: false,
							timer: 1200
						})
						setTimeout(()=>{
							// location.reload()
						}, 1100);
						// location.reload()
					}else{
						Swal.fire({
							icon: 'warning',
							title: 'Whoops',
							text: data.message,
						})
					}
					$('.btnSimpan').attr('disabled',false).html('SIMPAN')
				}
			}).fail(()=>{
				Swal.fire({
					icon: 'error',
					title: 'Whoops..',
					text: 'Terjadi kesalahan silahkan ulangi kembali',
					showConfirmButton: false,
					timer: 1300,
				})
				$('.btnSimpan').attr('disabled',false).html('SIMPAN')
			})
	})
	$('.btnSimpanPassword').click((e) => {
		e.preventDefault()
		var data = new FormData($('#formPassword')[0])
		$('.btnSimpanPassword').attr('disabled',true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>LOADING...')
		$.ajax({
				url: '{{route("pengaturanAkun.ubahPassword")}}',
				type: 'POST',
				data: data,
				async: true,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status=='success'){
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: data.message,
							showConfirmButton: false,
							timer: 1200
						})
						setTimeout(()=>{
							window.location.replace('{{route("auth.logout")}}')
						}, 1100);
						// location.reload()
					}else{
						Swal.fire({
							icon: 'warning',
							title: 'Whoops',
							text: data.message,
							showConfirmButton: false,
							timer: 1300,
						})
					}
					$('.btnSimpanPassword').attr('disabled',false).html('SIMPAN')
				}
			}).fail(()=>{
				Swal.fire({
					icon: 'error',
					title: 'Whoops..',
					text: 'Terjadi kesalahan silahkan ulangi kembali',
					showConfirmButton: false,
					timer: 1300,
				})
				$('.btnSimpanPassword').attr('disabled',false).html('SIMPAN')
			})
	})
</script>
@endpush