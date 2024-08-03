
<!-- The Modal Tambah Siswa -->
<div class="modal fade" id="tambahTahun">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<form id="formPembayaran">
					<input type="hidden" name="id" @isset($pembayaran) value="{{$pembayaran->id}}" @endisset>
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="nama">Nama Transaksi</label>
								<input type="text" class="form-control" id="nama" placeholder="nama" name="nama" @isset($pembayaran) value="{{$pembayaran->nama}}" @endisset>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label>Jenis Pembayaran</label>
								<select name="jenis_pembayaran_id" id="jenis_pembayaran_id" class="form-control" @isset($pembayaran) disabled @endisset>
									<option value="">- Pilih -</option>
									@foreach ($jenisPembayaran as $item)
										<option value="{{$item->id}}" @isset($pembayaran) @if ($pembayaran->jenis_pembayaran_id==$item->id) selected @endif @endisset>{{$item->nama.' ('.$item->kode.')'}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="nominal">Nominal</label>
								<input type="text" class="form-control" id="nominal" placeholder="nominal" name="nominal" onkeyup="ubahFormatRupiah(this)" @isset($pembayaran) value="{!! Help::currencyFormatDecimal($pembayaran->nominal) !!}" @endisset>
							</div>
						</div>
						<br>
						<div class="col-12">
							<label><u><i>Target Siswa</i></u></label>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label>Kelas</label>
								<select name="kelas[]" id="kelas" class="form-control select2" data-placeholder="- Pilih -" multiple="multiple" style="width: 100%">
									@foreach ($kelas as $item)
										<option value="{{$item->id}}">{{$item->nama.' ('.$item->tahun_ajaran->tahun_awal.'/'.$item->tahun_ajaran->tahun_akhir.')'}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
									<option value="">- Pilih -</option>
									<option value="semua" @isset($pembayaran) @if ($pembayaran->is_l=='L'&&$pembayaran->is_p=='P') selected @endif @endisset>Semua</option>
									<option value="L" @isset($pembayaran) @if ($pembayaran->is_l=='L'&&$pembayaran->is_p!='P') selected @endif @endisset>Laki-laki</option>
									<option value="P" @isset($pembayaran) @if ($pembayaran->is_l!='L'&&$pembayaran->is_p=='P') selected @endif @endisset>Perempuan</option>
								</select>
							</div>
						</div>
						<br>
						<div class="col-12 d-flex">
							<label><u><i>Detail</i></u></label>
							<button class="btn btn-success btnPlus ml-auto">+</button>
						</div>
						<div class="col-12">
							<table class="table table-borderless" id="tableDetail">
								<thead>
									<tr>
										<th width="70%">Keterangan</th>
										<th width="20%">Nominal</th>
										<th width="10%">Hapus</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
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
	btnPlus = $('.btnPlus'),
	btnSimpanHtml = $(btnSimpan).html(),
	routeStore = "{{route('pembayaran.store')}}",
	pembayaranKelas = "{{!empty($pembayaranKelas)?$pembayaranKelas:''}}",
	detailPembayaran = new Array()
	@isset($pembayaran)
	detailPembayaran = JSON.parse(`{!! json_encode($pembayaran->detail_pembayaran) !!}`)
	@endisset
	$(function () {
		modalSiswa.modal({
			backdrop: 'static',
			show: true
		})
		$('#kelas').select2({
			dropdownParent: modalSiswa
		});
		$('#kelas').val(pembayaranKelas.split(',')).trigger('change')
		$('#periode-form').show();
		// $('#tanggal-form').hide();
		$('[data-toggle="tooltip"]').tooltip()
		// console.log(detailPembayaran);
		$.each(detailPembayaran, function (indexInArray, valueOfElement) { 
			appendDetail(indexInArray,valueOfElement.id,valueOfElement.keterangan,valueOfElement.nominal)
		});
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
		var data = new FormData($('#formPembayaran')[0])
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
			swalError()
		});
	});

	$(btnPlus).click(async function (e) { 
		e.preventDefault();
		let nowIndex = $('.detail').length
		await appendDetail(nowIndex)
	});

	// $('.btnMinus').click(function (e) { 
	// 	e.preventDefault();
	// 	console.log();
	// });
	async function minusDetail(btn,event) {
		event.preventDefault()
		// console.log($(btn).data('index'));
		let curLength = $('.detail').length
		let minusIndex = $(btn).data('index');
		await $(`#detail_${minusIndex}`).remove();
		console.log(minusIndex);
		for (let index = 0; index < curLength; index++) {
			if (index<minusIndex) {
				console.log('continue');
				continue
			}
			if ($(`#detail_${index+1}`).length) {
				console.log('yield');
				await appendDetail(index,$(`id_${index+1}`).val(),$(`keterangan_${index+1}`).html(),$(`#nominal_${index+1}`).val())
				await $(`#detail_${index+1}`).remove();
			}
		}
	}

	async function appendDetail(index,detail_id='',keterangan='',nominal='') {
		let rupiah = formatRupiah(nominal, "Rp. ")
		let html = `
			<tr class="detail" id="detail_${index}">
				<td>
					<input type="hidden" name="detail[${index}][id]" id="id_${index}" value="${detail_id}">
					<textarea class="form-control" name="detail[${index}][keterangan]" id="keterangan_${index}" rows="1">${keterangan}</textarea>
				</td>
				<td>
					<input type="text" class="form-control" name="detail[${index}][nominal]" id="nominal_${index}" placeholder="nominal" onkeyup="ubahFormatRupiah(this)" value="${rupiah}">
				</td>
				<td>
					<button class="btn btn-sm btn-danger" onclick="minusDetail(this,event)" data-index="${index}"><i class="fa fa-trash" aria-hidden="true"></i></button>
				</td>
			</tr>`
		await $('#tableDetail tbody').append(html);
	}
</script>