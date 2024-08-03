
<!-- The Modal Tambah Siswa -->
<div class="modal fade" id="tambahTahun">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<form id="formTahun">
					<input type="hidden" name="id" @isset($tahunAjaran) value="{{$tahunAjaran->id}}" @endisset>
					<div class="row">
						<div class="col-6 mb-3">
							<label for="tahun_awal" class="form-label">Tahun Awal</label>
							<input type="text" name="tahun_awal" class="form-control filter-table tanggal text-center" id="tahun_awal" required readonly>
						</div>
						<div class="col-6 mb-3">
							<label for="tahun_akhir" class="form-label">Tahun akhir</label>
							<input type="text" name="tahun_akhir" class="form-control filter-table tanggal text-center" id="tahun_akhir" required readonly>
						</div>
					</div>
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
<!--akhir tambah-->
<script>
	var modalSiswa = $('#tambahTahun'),
	btnSimpan = $('.btnSimpan'),
	btnSimpanHtml = $(btnSimpan).html(),
	routeStore = "{{route('tahunAjaran.store')}}",
	tahunAwal = "{{!empty($tahunAjaran)?$tahunAjaran->tahun_awal:date('Y')}}",
	tahunAkhir = "{{!empty($tahunAjaran)?$tahunAjaran->tahun_akhir:date('Y',strtotime('+1 year'))}}";
	$(function () {
		modalSiswa.modal({
			backdrop: 'static',
			show: true
		})
		$('#tahun_awal').yearpicker({
			year: parseInt(tahunAwal)
		})
		$('#tahun_akhir').yearpicker({
			year: parseInt(tahunAkhir)
		})
	});

	$('#tahun_awal').change(function (e) { 
		e.preventDefault();
		$('#tahun_akhir').val(parseInt($('#tahun_awal').val()) + 1)
	});

	$('#tahun_akhir').change(function (e) { 
		e.preventDefault();
		$('#tahun_awal').val(parseInt($('#tahun_akhir').val()) - 1)
	});
	
	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formTahun')[0])
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