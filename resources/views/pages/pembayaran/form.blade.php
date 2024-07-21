
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
						<div class="col-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Nama Transaksi</label>
								<input type="text" class="form-control" id="exampleInputEmail1" placeholder="nama">
							</div>
							
						</div>
						<div class="col-12 mb-3">
							<label>Dibayarkan</label>
							<select name="periode" id="periode" class="form-control">
								<option value="periode">Periode</option>
								<option value="tanggal">Sekali</option>
							</select>
						</div>
						<div class="col-12 mb-3" id="periode-form">
							<div class="form-group">
								<label>Periode</label>
								<select name="pp" id="pp" class="form-control">
									<option value="1">Januari</option>
									<option value="1">Februari</option>
									<option value="1">Maret</option>
									<option value="1">April</option>
									<option value="1">Mei</option>
									<option value="1">Juni</option>
									<option value="1">Juli</option>
									<option value="1">Agustus</option>
									<option value="1">September</option>
									<option value="1">Oktober</option>
									<option value="1">November</option>
									<option value="1">Desember</option>
								</select>
							  </div>
						</div>
						<div class="col-12 mb-3" id="tanggal-form">
							<div class="form-group">
								<label>Tanggal</label>
								  <div class="input-group date" id="reservationdate" data-target-input="nearest">
									  <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/>
									  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
										  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
									  </div>
								  </div>
							  </div>
						</div>
						<div class="col-12 mb-3">
							<label for="">Target Siswa Kelas</label>
							<select name="target-kelas[]" id="target-kelas" class="form-control multiple-select">
								@foreach ($kelas as $item)
									<option value="">{{$item->nama.'('.$item->tahun_ajaran->tahun_awal.'/'.$item->tahun_ajaran->tahun_akhir.')'}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-12 mb-3">
							<label for="">Jenis</label>
							<select name="wajib" id="wajib" class="form-control">
								<option value="">Wajib</option>
								<option value="">Tidak Wajin</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="submit" class="btn btn-info">Submit</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
		$('#periode-form').show();
		$('#tanggal-form').hide();
	});

	$('#periode').change(function (e) { 
		e.preventDefault();
		if ($('#periode').val()=='periode') {
			$('#periode-form').show();
			$('#tanggal-form').hide();
			return
		}
		$('#periode-form').hide();
		$('#tanggal-form').show();
	});

    $('#reservationdate').datetimepicker({
        format: 'L'
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