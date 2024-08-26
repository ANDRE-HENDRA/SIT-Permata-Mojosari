
<div class="row">
	<div class="col-12">
		<form id="formBayar">
			<input type="hidden" id="id" name="id" @isset($bayar) value="{{$bayar->id}}" @endisset>
			<input type="hidden" id="id_pembayaran" name="id_pembayaran" @isset($pembayaran_kelas->pembayaran) value="{{$pembayaran_kelas->pembayaran->id}}" @endisset>
			<input type="hidden" id="kelas_id" name="kelas_id" @isset($pembayaran_kelas) value="{{$pembayaran_kelas->kelas_id}}" @endisset>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="nama_pembayaran">Nama Pembayaran</label>
						<input type="text" class="form-control form-control-border" id="nama_pembayaran" readonly @isset($pembayaran_kelas->pembayaran) value="{{$pembayaran_kelas->pembayaran->nama}}" @endisset>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="jenis_pembayaran">Jenis Pembayaran</label>
						<input type="text" class="form-control form-control-border" id="jenis_pembayaran" readonly @isset($pembayaran_kelas->pembayaran) value="{{$pembayaran_kelas->pembayaran->jenis_pembayaran->nama}}" @endisset>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="total_tagihan">Total Tagihan</label>
						<input type="text" class="form-control form-control-border" id="total_tagihan" readonly @isset($pembayaran_kelas->pembayaran) value="{!! Help::currencyFormatDecimal($pembayaran_kelas->pembayaran->nominal) !!}" @endisset>
					</div>
				</div>
				@if ($pembayaran_kelas->pembayaran->jenis_pembayaran->is_loop)
				<div class="col-12">
					<div class="form-group">
						<label for="total_tagihan">Bulan</label>
						<select class="form-control select2" name="bulan" id="bulan">
							@foreach ($bulan as $item)
								<option value="{{$item->m}}">{{$item->bulan}}</option>
							@endforeach
						</select>
					</div>
				</div>
				@endif
				<div class="col-12">
					<div class="form-group">
						<label for="terbayar">Terbayar</label>
						<input type="text" class="form-control form-control-border" id="terbayar" readonly>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="sisa_tagihan">Sisa Tagihan</label>
						<input type="text" class="form-control form-control-border" id="sisa_tagihan" readonly>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="nominal">Nominal Bayar</label>
						<input type="text" class="form-control" id="nominal" placeholder="nominal" name="nominal" onkeyup="ubahFormatRupiah(this)" @isset($pembayaran_kelas->pembayaran) @if(!$pembayaran_kelas->pembayaran->jenis_pembayaran->is_kredit) readonly @endif @endisset>
					</div>
				</div>
				<div class="col-12 mb-3">
					<div class="form-group">
						<label>Tanggal</label>
						<div class="input-group date" id="reservationdate" data-target-input="nearest">
							<input type="text" name="tanggal_transaksi" class="form-control datetimepicker-input" data-target="#reservationdate"/>
							<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-12">
		<button class="btn btn-info btnSimpan" name="addsiswa">Submit</button>
	</div>
</div>

{{-- <div class="card-body">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 50px;">No</th>
				<th>Jenis Pembayaran</th>
				<th>Nominal</th>
				<th>Status</th>
				<th>Sisa Nominal</th>
				<th>Tanggal</th>
				<th>Keterangan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1.</td>
				<td>kain dan atribut</td>
				<td>100.0000</td>
				<td>lunas</td>
				<td>25.000</td>
				<th>06-07-2024</th>
				<td>sebulan sekali</td>
				<td>
					<button type="button" class="btn btn-danger btn-sm">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</div> --}}
<script>
	var modalSiswa = $('#tambahTahun'),
	btnSimpan = $('.btnSimpan'),
	btnSimpanHtml = $(btnSimpan).html(),
	routeStore = "{{route('bayar.store')}}",
	routeGetTagihan = "{{route('bayar.getTagihan')}}",
	routeInvoice = "{{route('bayar.invoice')}}"
	// loopBulan = "empty($jenisPembayaran)?explode(',',$jenisPembayaran->loop_bulan):[]";
	
	// loopBulan = "{{!empty($jenisPembayaran)?$jenisPembayaran->loop_bulan:''}}";
	$(function () {
		// $('[data-toggle="tooltip"]').tooltip()
		$('#reservationdate').datetimepicker({
			format: 'L'
		});
		getTagihan()
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
			$('#tanggal-form').hide();
			return
		}
		$('#periode-form').hide();
		$('#tanggal-form').show();
	});

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formBayar')[0])
		data.append('siswa_id',$('#siswa_id').val())
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
				// modalSiswa.modal('hide')
				window.open(routeInvoice+'/'+res.data.id, '_blank').focus();
				location.reload()
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

	function getTagihan() {
		var data = new FormData()
		data.append('id_pembayaran',$('#id_pembayaran').val())
		data.append('siswa_id',$('#siswa_id').val())
		data.append('bulan',$('#bulan').val())
		$.ajax({
			type: "post",
			url: routeGetTagihan,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			if (res.status=='success') {
				$('#sisa_tagihan').val(formatRupiah(res.data.sisa, "Rp. "))
				$('#terbayar').val(formatRupiah(res.data.terbayar, "Rp. "))
				$('#nominal').val(formatRupiah(res.data.sisa, "Rp. "))
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
		});
	}

	$('#bulan').change(function (e) { 
		e.preventDefault();
		getTagihan()
	});

</script>