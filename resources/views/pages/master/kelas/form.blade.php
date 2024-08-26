<!-- The Modal Tambah Siswa -->
<div class="modal fade" id="tambahKelas">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<form id="formKelas">
					<input type="hidden" name="id" @isset($kelas) value="{{$kelas->id}}" @endisset>
					<div class="mb-3">
						<label for="nama" class="form-label">Nama Kelas</label>
						<input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required @isset($kelas) value="{{$kelas->nama}}" @endisset>
					</div>
					<div class="mb-3">
						<div class="form-group">
							<label>Tahun Ajaran</label>
							<select class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id">
								@foreach ($tahunAjaran as $item)
									<option value="{{$item->id}}" @isset($kelas) @if($kelas->tahun_ajaran_id==$item->id) selected @endif @endisset>{{$item->tahun_awal.'/'.$item->tahun_akhir}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="mb-3">
						<div class="form-group">
							<label>Tingkat Sekolah</label>
							<select class="form-control" name="tingkat" id="tingkat">
								<option value="">- Pilih -</option>
								<option value="kb" @isset($kelas) @if($kelas->tingkat=='kb') selected @endif @endisset>KB</option>
								<option value="tk" @isset($kelas) @if($kelas->tingkat=='tk') selected @endif @endisset>TK</option>
								<option value="sd" @isset($kelas) @if($kelas->tingkat=='sd') selected @endif @endisset>SD</option>
							</select>
						</div>
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
<!--akhir tambah-->
<script>
	var modal = $('#tambahKelas'),
	btnSimpan = $('.btnSimpan'),
	btnSimpanHtml = $(btnSimpan).html(),
	routeStore = "{{route('kelas.store')}}"
	$(function () {
		modal.modal({
			backdrop: 'static',
			show: true
		})
	});

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formKelas')[0])
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
				modal.modal('hide')
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
			swalError()
		});
	});

</script>