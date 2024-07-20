<!-- The Modal Tambah Siswa -->
<div class="modal fade" id="tambahAkun">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form id="formUser">
					<input type="hidden" name="id" id="id" @isset($user) value="{{$user->id}}" @endisset>
					<div class="mb-3">
						<label for="username" class="form-label">Username *</label>
						<input type="text" name="username" class="form-control" id="username" required @isset($user) value="{{$user->username}}" @endisset>
					</div>
					<div class="mb-3">
						<label for="name" class="form-label">Nama *</label>
						<input type="text" name="name" class="form-control" id="name" required @isset($user) value="{{$user->name}}" @endisset>
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">Email *</label>
						<input type="email" name="email" class="form-control" id="email" required @isset($user) value="{{$user->email}}" @endisset>
					</div>
					<p>Password sesuai dengan nama username, untuk mengubah silahkan ubah sendiri ke menu Akun masing - masing pengguna.</p>
					<button type="submit" class="btn btn-info btnSimpan">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</form>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<script>
	var modalAkun = $('#tambahAkun'),
	btnSimpan = $('.btnSimpan'),
	btnSimpanHtml = $(btnSimpan).html(),
	routeStore = "{{route('user.store')}}"
	$(function () {
		modalAkun.modal({
			backdrop: 'static',
			show: true
		})
	});

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formUser')[0])
		$.ajax({
			type: "post",
			url: routeStore,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			$(btnSimpan).html(btnSimpanHtml);
			if (res.status=='success') {
				swalSuccess(res.message)
				modalAkun.modal('hide')
				await dataTable()
			} else if (res.status=='restore') {
				Swal.fire({
					title: "Peringatan!",
					text: res.message,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, restore!"
				}).then((result) => {
					if (result.isConfirmed) {
						restore(res.restore_id)
					}
				})
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			$(btnSimpan).html(btnSimpanHtml);
			swalError(err.response.message)
		});
	});
</script>