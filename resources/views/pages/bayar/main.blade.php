@extends('layout.index')
@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="form-group">
							<label for="nama" class="col-form-label">Cari Siswa : </label>
							<div class="input-group input-group-lg">
								<select name="siswa_id" id="siswa_id" class="form-control select2" style="width: 100%"
									onchange="triggerCariSiswa()">
								</select>
								{{-- <input type="search" class="form-control form-control-lg" placeholder="Masukkan NIS"> --}}
								{{-- <div class="input-group-append">
									<button type="submit" class="btn btn-lg btn-default">
										<i class="fa fa-search"></i>
									</button>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-8">
				<div class="card card-success card-outline">
					<div class="card-header d-flex">
						<label>Bayar</label>
						<button class="btn btn-outline-danger ml-auto mr-0 btn-sm btnReload"><i class="fas fa-redo-alt"></i></button>
					</div>
					<div class="card-body" id="bayar-body">
						<div class="m-auto pt-2 w-50">
							<div class="info-box bg-info">
								<span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
								
								<div class="info-box-content">
									<span class="info-box-text">Info</span>
									<span class="info-box-number">Pilih Siswa Terlebih Dahulu!</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="row">
					<div class="col-12">
						<!-- Profile Image -->
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<h3 class="profile-username text-center" id="siswa_nama">Nama</h3>
								
								<p class="text-muted text-center" id="siswa_nis">Nis/Nisn</p>
								
								<ul class="list-group list-group-unbordered mb-3">
									<li class="list-group-item">
										<b>Tahun Masuk</b> <a class="float-right" id="siswa_tahun_masuk">-</a>
									</li>
									<li class="list-group-item">
										<b>Jenis Kelamin</b> <a class="float-right" id="siswa_jenis_kelamin">-</a>
									</li>
									<li class="list-group-item">
										<b>Kelas</b> <a class="float-right" id="siswa_kelas_siswa">-</a>
									</li>
								</ul>
		
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<div class="col-12">
						<!-- Profile Image -->
						<div class="card card-warning card-outline">
							<div class="card-header d-flex">
								<label>Transaksi Terakhir</label>
								<button class="btn btn-danger ml-auto mr-0 btn-sm btnPrintAll"><i class="fas fa-print"></i>Bulk Print</button>
							</div>
							<div class="card-body box-profile">
								<table id="tbl-riwayat">
									<tbody>
										
									</tbody>
								</table>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
				</div>
			</div>
			<!-- /.col -->
			
		</div>
		<br><br><br>
		
	</div><!-- /.container-fluid -->
</section>
<div class="modalArea">
	<div class="modal fade" id="modalPrintAll">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Bulk Print</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<form id="formPrintAll">
						<div class="mb-3">
							<div class="form-group">
								<label>Cari Transaksi</label>
								<select class="form-control select2" 
									style="width: 100%"
									onchange="triggerPilihSiswa()"
									id="transaksi_id" 
									name="transaksi_id"
								>
								</select>
							</div>
						</div>
						<div class="mb-3">
							{{-- <button class="btn btn-success btnPlus ml-auto">+</button> --}}
							<div class="spinner-area"></div>
						</div>
						<table class="table table-responsive table-borderless" id="table-kelas-siswa">
							<tbody>
							</tbody>
						</table>
					</form>
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
					<button class="btn btn-info btnSimpan" name="addsiswa">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
	var btnAdd = $('.btnAdd'),
	btnPrintAll = $('.btnPrintAll'),
	btnAddHtml = $(btnAdd).html(),
	btnPrintAllHtml = $(btnPrintAll).html(),
	modalPrintAll = $('#modalPrintAll'),
	modalArea = $('.modalArea'),
	bayarBody = $('#bayar-body'),
	bayarBodyHtml = $('#bayar-body').html(),
	btnReload = $('.btnReload'),
	tabelRiwayat = $('#tbl-riwayat tbody'),
	route = "{{route('jenisPembayaran.main')}}",
	routeBayarForm = "{{route('bayar.form')}}",
	routeJenisPembayaranDelete = "{{route('jenisPembayaran.delete')}}",
	routeJenisPembayaranList = "{{route('bayar.jenisPembayaran')}}",
	routeTagihanSiswa = "{{route('bayar.tagihanSiswa')}}",
	routeInvoice = "{{route('bayar.invoice')}}"
	$(async function () {
		// await dataTable()
		// renderJenis()
		// modalPrintAll.modal({
		// 	backdrop: 'static'
		// })
		$(btnPrintAll).hide();
		$('#siswa_id').select2({
			width: "resolve",
			allowEmpty: true,
			ajax: {
				url: "{{ route('bayar.cari_siswa') }}",
				dataType: 'json',
				type: 'POST',
				delay: 250,
				data: function(params) {
					var query = {
						q: params.term,
					}
					return query;
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: '(' + item.id + ') ' + item.nama,
								id: item.id,
							}
						})
					};
				},
				cache: true,
			}
		});
		
	});

	function triggerCariSiswa() {
		renderJenis()
		getSiswa()
	}

	function getSiswa() {
		var siswa_id = $('#siswa_id').val();
        if (siswa_id) {
            $.post("{{ route('bayar.getSiswa') }}", {
                siswa_id:siswa_id
            }).done(function(result) {
                if (result.status == 'success') {
                    setAnggota(result.data);
                    setRiwayat(result.data.transaksi);
                } else {
                    swalError();
                }
            });
        }
	}

	function setAnggota(data) {
		$('#siswa_nama').html(data.nama);
		$('#siswa_nis').html(data.nis+'/'+data.nisn);
		$('#siswa_tahun_masuk').html(data.tahun_masuk);
		$('#siswa_jenis_kelamin').html(data.jenis_kelamin);
		$('#siswa_kelas_siswa').html(data.kelas_siswa.length?data.kelas_siswa[0].kelas.nama:'tidak ada');
	}

	function setRiwayat(data) {
		$(tabelRiwayat).html('');
		let dataLength = data.length
		data.forEach((e,i) => {
			let html = `
				<tr>
					<td>${dataLength-i}</td>
					<td>${e.kode}</td>
					<td>${e.tanggal_transaksi}</td>
					<td><a href='${routeInvoice}/${e.id}' target='blank'><button class='btn btn-sm btn-warning text-white'><i class='fa fa-print'></i></button></a></td>
				</tr>
			`;
			$(tabelRiwayat).append(html);
		});
	}

	$(btnReload).click(function (e) { 
		e.preventDefault();
		renderJenis()
	});

	function form(id='') {
		let siswa_id = $('#siswa_id').val();
		$(bayarBody).html(`<div class="m-auto pt-2">`+spinnerLg+`</div>`)
		$.post(routeBayarForm, {id:id,siswa_id:siswa_id})
		.done((res)=>{
			if (res.status=='success') {
				$(bayarBody).html(res.response)
			} else {
				$(bayarBody).html(bayarBodyHtml)
				swalWarning('Gagal!')
			}
		})
		.fail((err)=>{
			$(bayarBody).html(bayarBodyHtml)
			swalError()
		})
	}

	function renderPembayaran(jenis_id='') {
		$(bayarBody).html(`<div class="m-auto pt-2">`+spinnerLg+`</div>`)
		$.post(routeTagihanSiswa, {jenis_id:jenis_id,siswa_id:$('#siswa_id').val()})
		.done((res)=>{
			if (res.status=='success') {
				$(bayarBody).html(res.response)
			} else {
				$(bayarBody).html(bayarBodyHtml)
				swalWarning('Gagal!')
			}
		})
		.fail((err)=>{
			$(bayarBody).html(bayarBodyHtml)
			swalError()
		})
	}

	function renderJenis() {
		$(bayarBody).html(`<div class="m-auto pt-2">`+spinnerLg+`</div>`)
		var data = new FormData()
		data.append('siswa_id',$('#siswa_id').val())
		$.ajax({
			type: "post",
			url: routeJenisPembayaranList,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done((res)=>{
			if (res.status=='success') {
				$(bayarBody).html(res.response)
			} else {
				$(bayarBody).html(bayarBodyHtml)
				swalWarning('Gagal!')
			}
		})
		.fail((err)=>{
			$(bayarBody).html(bayarBodyHtml)
			swalError()
		})
	}

	async function dataTable() {
		await $('#datatable').DataTable({
			stateSave: false,
			scrollX: false,
			serverSide: true,
			processing: true,
			destroy: true,
			language: {
				// processing: spinner+' '+spinner+' '+spinner,
				search: 'Pencarian',
				searchPlaceholder: 'Masukkan kata kunci',
			},
			ajax: {
				url: route
			},
			columns: [
			{data:'DT_RowIndex', name:'DT_RowIndex', render: (data, type, row)=>{
				return `<p class="m-0 p-1">${data}</p>`
			}},
			{data:'nama', name:'nama'},
			{data:'is_loop', name:'is_loop'},
			{data:'is_wajib', name:'is_wajib'},
			{data:'is_kredit', name:'is_kredit'},
			{data:'actions', name:'actions'}
			],
		})
	}
	
	$(btnAdd).click(function (e) { 
		e.preventDefault();
		$(modalArea).html('')
		$(btnAdd).html(spinnerSr);
		$.post(routeBayarForm)
		.done((res)=>{
			$(btnAdd).html(btnAddHtml);
			if (res.status=='success') {
				$(modalArea).html(res.response)
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
			$(btnAdd).html(btnAddHtml);
		})
	});
	
	function edit(id='',ini) {  
		let iniHtml = $(ini).html()
		$(ini).html(spinnerSr)
		$.post(routeBayarForm,{id})
		.done((res)=>{
			$(ini).html(iniHtml);
			if (res.status=='success') {
				$(modalArea).html(res.response)
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
			$(ini).html(iniHtml);
		})
	}
	
	function hapus(id='',ini,nama='') {  
		let iniHtml = $(ini).html()
		Swal.fire({
			title: "Peringatan!",
			html: `<span>Data <b>${nama}</b> akan dihapus, yakin ingin melakukanya?</span>`,
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, hapus!"
		}).then((result) => {
			if (result.isConfirmed) {
				$(ini).html(spinnerSr)
				$.post(routeJenisPembayaranDelete,{id})
				.done(async (res)=>{
					$(ini).html(iniHtml);
					if (res.status=='success') {
						swalSuccess(res.message)
						await dataTable()
					} else {
						swalWarning(res.message)
					}
				})
				.fail((err)=>{
					swalError()
					$(ini).html(iniHtml);
				})
			}
		})
	}
	
	function restore(id) {  
		console.log(`${id} restored`);
		$.post(routeTahunAjaranRestore,{id})
		.done(async (res)=>{
			if (res.status=='success') {
				swalSuccess(res.message)
				await dataTable()
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
		})
	}

	$(btnPrintAll).click(function (e) { 
		e.preventDefault();
		
	});
</script>
@endpush