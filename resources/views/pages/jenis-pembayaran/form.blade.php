
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
				<form id="formJenisPembayaran">
					<input type="hidden" name="id" @isset($jenisPembayaran) value="{{$jenisPembayaran->id}}" @endisset>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="nama">Nama Transaksi</label>
								<input type="text" class="form-control" id="nama" placeholder="nama" name="nama" @isset($jenisPembayaran) value="{{$jenisPembayaran->nama}}" @endisset>
							</div>
						</div>
						<div class="col-12">
							<label>
								Aturan Pembayaran
							</label>
							<div class="form-group clearfix">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="is_wajib" name="is_wajib" @isset($jenisPembayaran) @if ($jenisPembayaran->is_wajib) checked @endif @endisset>
									<label for="is_wajib">
										Pembayaran Wajib
										<i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i>
									</label>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="is_kredit" name="is_kredit" @isset($jenisPembayaran) @if ($jenisPembayaran->is_kredit) checked @endif @endisset>
									<label for="is_kredit">
										Bisa dicicil
									</label>
								</div>
							</div>
						</div>
						<div class="col-12 mb-3">
							<label>Dibayarkan</label>
							<select name="is_loop" id="is_loop" class="form-control">
								<option value="true" @isset($jenisPembayaran) @if ($jenisPembayaran->is_loop) seleced @endif @endisset>Periode (Per-Bulan / Per-Semester / Per-Tahun)</option>
								<option value="false" @isset($jenisPembayaran) @if (!$jenisPembayaran->is_loop) seleced @endif @endisset>Sekali Selama Sekolah</option>
							</select>
						</div>
						<div class="col-12 mb-3" id="periode-form">
							<div class="form-group">
								<label>Periode</label>
								<select name="loop_bulan[]" id="loop_bulan" class="form-control" multiple="multiple" style="width: 100%">
									<option value="01">Januari</option>
									<option value="02">Februari</option>
									<option value="03">Maret</option>
									<option value="04">April</option>
									<option value="05">Mei</option>
									<option value="06">Juni</option>
									<option value="07">Juli</option>
									<option value="08">Agustus</option>
									<option value="09">September</option>
									<option value="10">Oktober</option>
									<option value="11">November</option>
									<option value="12">Desember</option>
								</select>
							</div>
							<div class="form-group clearfix">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="semua_bulan" name="semua_bulan">
									<label for="semua_bulan">
										Pilih Semua
									</label>
								</div>
							</div>
						</div>
						{{-- <div class="col-12 mb-3" id="tanggal-form">
							<div class="form-group">
								<label>Tanggal</label>
								<div class="input-group date" id="reservationdate" data-target-input="nearest">
									<input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/>
									<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
						</div> --}}
					</div>
				</form>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btnSimpan">Submit</button>
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
	routeStore = "{{route('jenisPembayaran.store')}}"
	loopBulan = "{{!empty($jenisPembayaran)?$jenisPembayaran->loop_bulan:''}}";
	$(function () {
		modalSiswa.modal({
			backdrop: 'static',
			show: true
		})
		$('#loop_bulan').select2({
			dropdownParent: modalSiswa
		});
		$('#loop_bulan').val(loopBulan.split(',')).trigger('change')
		$('#periode-form').show();
		// $('#tanggal-form').hide();
		$('[data-toggle="tooltip"]').tooltip()
	});

	$('#semua_bulan').change(function (e) { 
		e.preventDefault();
		if ($('#semua_bulan').is(':checked')) {
			$('#loop_bulan').select2('destroy').find('option').prop('selected', 'selected').end().select2();
		} else {
			$('#loop_bulan').select2('destroy').find('option').prop('selected', false).end().select2();
		}
	});

	$('#is_loop').change(function (e) { 
		e.preventDefault();
		if ($('#is_loop').val()=='true') {
			$('#periode-form').show();
			// $('#tanggal-form').hide();
			return
		}
		$('#periode-form').hide();
		// $('#tanggal-form').show();
	});

    $('#reservationdate').datetimepicker({
        format: 'L'
    });

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formJenisPembayaran')[0])
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