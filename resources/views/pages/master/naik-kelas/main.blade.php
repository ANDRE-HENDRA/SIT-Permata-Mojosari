
@extends('layout.index')
@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					{{-- <div class="card-header">
						<!-- Button to Open the Modal -->
						<button type="button" class="btn btn-primary btnAdd">
							<i class="fa fa-plus-circle" aria-hidden="true"></i>
							Tambah
						</button>
					</div> --}}
					<!-- /.card-header -->
					<div class="card-body">
						<form id="formNaikKelas">
							<div class="row px-2">
								<div class="col-12 col-md-6 border border-info rounded-lg pt-2">
									<div class="mb-3">
										<div class="form-group">
											<label>Tahun Ajaran Asal</label>
											<select class="form-control select2" 
												style="width: 100%"
												id="tahun_ajaran_id_asal" 
												name="tahun_ajaran_id_asal"
											>
											<option value="">-Pilih-</option>
											@foreach ($tahunAjaran as $item)
												<option value="{{$item->id}}">{{$item->tahun_awal}}/{{$item->tahun_akhir}}</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="mb-3">
										<div class="form-group">
											<label>Kelas Asal</label>
											<select class="form-control select2" 
												style="width: 100%"
												id="kelas_id_asal" 
												name="kelas_id_asal"
											>
											</select>
										</div>
									</div>
									<div class="mb-3">
										<button type="button" class="btn btn-primary btnSiswaAsal w-100" disabled>
											<b>0</b> Siswa
										</button>
									</div>
								</div>
								<div class="col-12 col-md-6 border border-success rounded-lg pt-2">
									<div class="mb-3">
										<div class="form-group">
											<label>Tahun Ajaran Tujuan</label>
											<select class="form-control select2" 
												style="width: 100%"
												id="tahun_ajaran_id_tujuan" 
												name="tahun_ajaran_id_tujuan"
											>
											<option value="">-Pilih-</option>
											@foreach ($tahunAjaran as $item)
												<option value="{{$item->id}}">{{$item->tahun_awal}}/{{$item->tahun_akhir}}</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="mb-3">
										<div class="form-group">
											<label>Kelas Tujuan</label>
											<select class="form-control select2" 
												style="width: 100%"
												id="kelas_id_tujuan" 
												name="kelas_id_tujuan"
											>
											</select>
										</div>
									</div>
									<div class="mb-3">
										<button type="button" class="btn btn-primary btnSiswaTujuan w-100" disabled>
											<b>0</b> Siswa
										</button>
									</div>
								</div>
							</div>
						</form>
						{{-- <table class="table table-bordered table-hover" id="datatable">
							<thead>
								<tr>
									<th style="width: 50px;">No</th>
									<th>Nama Kelas</th>
									<th>Tahun Ajaran</th>
									<th>Jumlah Siswa</th>
									<th>Aksi</th>
								</tr>
							</thead>
						</table> --}}
					</div>
					<div class="card-footer">
						<div class="d-flex">
							<button type="button" class="btn btn-primary btnSimpan ml-auto mr-0">
								Submit
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.col -->
</section>
<div class="modalArea">
	<div class="modal fade" id="kelasSiswa">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Kelas Siswa</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<table class="table table-responsive table-borderless" id="table-kelas-siswa">
						<tbody>
						</tbody>
					</table>
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
	var btnSiswaAsal = $('.btnSiswaAsal'),
	btnSiswaTujuan = $('.btnSiswaTujuan'),
	btnSimpan = $('.btnSimpan'),
	btnSiswaAsalHtml = $(btnSiswaAsal).html(),
	btnSiswaTujuanHtml = $(btnSiswaTujuan).html(),
	btnSimpanHtml = $(btnSimpan).html(),
	modal = $('#kelasSiswa'),
	route = "{{route('naikKelas.main')}}",
	routeNaikKelasStore = "{{route('naikKelas.store')}}",
	routeNaikKelasGetSiswa = "{{route('naikKelas.getSiswa')}}",
	routeRefGetKelasByTahunAjaran = "{{route('reference.getKelasByTahunAjaran')}}"
	$(async function () {
		$('#tahun_ajaran_id_asal').select2({
			width: "resolve"
		})
		$('#kelas_id_asal').select2({
			width: "resolve"
		})
		$('#tahun_ajaran_id_tujuan').select2({
			width: "resolve"
		})
		$('#kelas_id_tujuan').select2({
			width: "resolve"
		})
		checkOk()
	});

	$('#tahun_ajaran_id_asal').change(function (e) { 
		e.preventDefault();
		$('#kelas_id_asal').html('<option value="">-Pilih-</option>');
		$('#kelas_id_asal').val('').trigger('change');
		if ($('#tahun_ajaran_id_asal').val() == '' || $('#tahun_ajaran_id_asal').val() == null) {
			return
		}
		var data = new FormData()
		data.append('tahun_ajaran_id',$('#tahun_ajaran_id_asal').val())
		$(btnSiswaAsal).html(spinnerSr);
		$(btnSiswaAsal).prop('disabled',true);
		$.ajax({
			type: "post",
			url: routeRefGetKelasByTahunAjaran,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			$(btnSiswaAsal).html(btnSiswaAsalHtml);
			res.data.forEach(element => {
				let option = `<option value="${element.id}">${element.nama}</option>`;
				$('#kelas_id_asal').append(option);
			});
		})
		.fail((err)=>{
			$(btnSiswaAsal).html(btnSiswaAsalHtml);
			swalError('Silahkan hubungi admin!')
		});
	});

	$('#kelas_id_asal').change(async function (e) { 
		e.preventDefault();
		var data = new FormData()
		data.append('tahun_ajaran_id',$('#tahun_ajaran_id_asal').val())
		data.append('kelas_id',$('#kelas_id_asal').val())
		$(btnSiswaAsal).html(btnSiswaAsalHtml);
		$(btnSiswaAsal).prop('disabled',true);
		checkOk()
		if ($('#kelas_id_asal').val() == '' || $('#kelas_id_asal').val() == null) {
			return
		}
		$(btnSiswaAsal).html(spinnerSr);
		$.ajax({
			type: "post",
			url: routeNaikKelasGetSiswa,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			await $(btnSiswaAsal).prop('disabled',false);
			if (res.status=='success') {
				await $(btnSiswaAsal).html(`<b>${res.data.count}</b> Siswa`);
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			$(btnSiswaAsal).prop('disabled',true);
			$(btnSiswaAsal).html(btnSiswaAsalHtml);
			swalError()
		});
	});

	$('#tahun_ajaran_id_tujuan').change(function (e) { 
		e.preventDefault();
		$('#kelas_id_tujuan').html('<option value="">-Pilih-</option>');
		$('#kelas_id_tujuan').val('').trigger('change');
		if ($('#tahun_ajaran_id_tujuan').val() == '' || $('#tahun_ajaran_id_tujuan').val() == null) {
			return
		}
		var data = new FormData()
		data.append('tahun_ajaran_id',$('#tahun_ajaran_id_tujuan').val())
		$(btnSiswaTujuan).html(spinnerSr);
		$(btnSiswaTujuan).prop('disabled',true);
		$.ajax({
			type: "post",
			url: routeRefGetKelasByTahunAjaran,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			$(btnSiswaTujuan).html(btnSiswaTujuanHtml);
			res.data.forEach(element => {
				let option = `<option value="${element.id}">${element.nama}</option>`;
				$('#kelas_id_tujuan').append(option);
			});
		})
		.fail((err)=>{
			$(btnSiswaTujuan).html(btnSiswaTujuanHtml);
			swalError('Silahkan hubungi admin!')
		});
	});

	$('#kelas_id_tujuan').change(async function (e) { 
		e.preventDefault();
		var data = new FormData()
		data.append('tahun_ajaran_id',$('#tahun_ajaran_id_tujuan').val())
		data.append('kelas_id',$('#kelas_id_tujuan').val())
		$(btnSiswaTujuan).html(btnSiswaTujuanHtml);
		$(btnSiswaTujuan).prop('disabled',true);
		checkOk()
		if ($('#kelas_id_tujuan').val() == '' || $('#kelas_id_tujuan').val() == null) {
			return
		}
		$(btnSiswaTujuan).html(spinnerSr);
		$.ajax({
			type: "post",
			url: routeNaikKelasGetSiswa,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			await $(btnSiswaTujuan).prop('disabled',false);
			if (res.status=='success') {
				await $(btnSiswaTujuan).html(`<b>${res.data.count}</b> Siswa`);
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			$(btnSiswaTujuan).prop('disabled',true);
			$(btnSiswaTujuan).html(btnSiswaTujuanHtml);
			swalError()
		});
	});

	$(btnSiswaAsal).click(function (e) { 
		e.preventDefault();
		var data = new FormData()
		data.append('tahun_ajaran_id',$('#tahun_ajaran_id_asal').val())
		data.append('kelas_id',$('#kelas_id_asal').val())
		$(btnSiswaAsal).html(spinnerSr);
		$(btnSiswaAsal).prop('disabled',true);
		$('#table-kelas-siswa tbody').html('');
		if ($('#kelas_id_asal').val() == '' || $('#kelas_id_asal').val() == null) {
			return
		}
		$(btnSiswaAsal).html(spinnerSr);
		$.ajax({
			type: "post",
			url: routeNaikKelasGetSiswa,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done((res)=>{
			$(btnSiswaAsal).html(`<b>${res.data.count}</b> Siswa`);
			$(btnSiswaAsal).prop('disabled',false);
			if (res.status=='success') {
				res.data.siswa.forEach((v,i) => {
					$('#table-kelas-siswa tbody').append(`<tr><td>${i+1}</td><td>${v.siswa.nis}/${v.siswa.nisn}</td><td>${v.siswa.nama}</td></tr>`);
				});
				modal.modal('show')
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
			$(btnSiswaAsal).html(btnSiswaAsalHtml);
		})
	});

	$(btnSiswaTujuan).click(function (e) { 
		e.preventDefault();
		var data = new FormData()
		data.append('tahun_ajaran_id',$('#tahun_ajaran_id_tujuan').val())
		data.append('kelas_id',$('#kelas_id_tujuan').val())
		$(btnSiswaTujuan).html(spinnerSr);
		$(btnSiswaTujuan).prop('disabled',true);
		$('#table-kelas-siswa tbody').html('');
		if ($('#kelas_id_tujuan').val() == '' || $('#kelas_id_tujuan').val() == null) {
			return
		}
		$(btnSiswaTujuan).html(spinnerSr);
		$.ajax({
			type: "post",
			url: routeNaikKelasGetSiswa,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done((res)=>{
			$(btnSiswaTujuan).html(`<b>${res.data.count}</b> Siswa`);
			$(btnSiswaTujuan).prop('disabled',false);
			if (res.status=='success') {
				res.data.siswa.forEach((v,i) => {
					$('#table-kelas-siswa tbody').append(`<tr><td>${i+1}</td><td>${v.siswa.nis}/${v.siswa.nisn}</td><td>${v.siswa.nama}</td></tr>`);
				});
				modal.modal('show')
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
			$(btnSiswaTujuan).html(btnSiswaTujuanHtml);
		})
	});

	function checkOk() {
		if (
			$('#kelas_id_asal').val() == '' 
			|| $('#kelas_id_asal').val() == null
			|| $('#kelas_id_tujuan').val() == '' 
			|| $('#kelas_id_tujuan').val() == null
		) {
			$('.btnSimpan').prop('disabled',true)
		} else {
			$('.btnSimpan').prop('disabled',false)
		}
	}

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		var data = new FormData($('#formNaikKelas')[0])
		$(btnSimpan).html(spinnerSr)
		$.ajax({
			type: "post",
			url: routeNaikKelasStore,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done((res)=>{
			$(btnSimpan).html(btnSimpanHtml)
			if (res.status=='success') {
				swalSuccess(res.message)
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			swalError()
		})
	});
</script>
@endpush