<!-- The Modal Tambah Siswa -->
<div class="modal fade" id="tambahSiswa">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form id="formSiswa">
					<input type="hidden" name="id" @isset($siswa) value="{{$siswa->id}}" @endisset>
					<div class="mb-3">
						<label for="nis" class="form-label">Nomor Induk Siswa (NIS) *</label>
						<input type="text" name="nis" class="form-control" id="nis" placeholder="silahkan masukkan NIS" required @isset($siswa) value="{{$siswa->nis}}" @endisset>
					</div>
					<div class="mb-3">
						<label for="nama" class="form-label">Nama *</label>
						<input type="text" name="nama" class="form-control" id="nama" @isset($siswa) value="{{$siswa->nama}}" @endisset required>
					</div>
					<div class="mb-3">
						<label for="nisn" class="form-label">NISN</label>
						<input type="text" name="nisn" class="form-control" id="nisn" onkeyup="hanyaAngka(this)" @isset($siswa) value="{{$siswa->nisn}}" @endisset placeholder="silahkan masukkan NISN" required>
					</div>
					<div class="mb-3">
						<div class="form-group">
							<label>Jenis Kelamin</label>
							<select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
								<option value="">- Pilih -</option>
								<option value="L" @isset($siswa) @if($siswa->jenis_kelamin=='L') selected @endif @endisset>Laki-laki</option>
								<option value="P" @isset($siswa) @if($siswa->jenis_kelamin=='P') selected @endif @endisset>Perempuan</option>
							</select>
						</div>
					</div>
					<div class="mb-3">
						<label for="tahun_masuk" class="form-label">Tahun Masuk</label>
						<input type="text" name="tahun_masuk" class="form-control filter-table tanggal text-center" id="tahun_masuk" required readonly>
					</div>
					<button type="submit" class="btn btn-info btnSimpan" name="addsiswa">Submit</button>
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
	var modalSiswa = $('#tambahSiswa'),
	btnSimpan = $('.btnSimpan'),
	btnSimpanHtml = $(btnSimpan).html(),
	routeStore = "{{route('siswa.store')}}",
	tahunMasuk = "{{!empty($siswa)&&$siswa->tahun_masuk?$siswa->tahun_masuk:date('Y')}}"
	$(function () {
		modalSiswa.modal({
			backdrop: 'static',
			show: true
		})
		$('#tahun_masuk').yearpicker({
			year: parseInt(tahunMasuk)
		})
	});

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formSiswa')[0])
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
				modalSiswa.modal('hide')
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