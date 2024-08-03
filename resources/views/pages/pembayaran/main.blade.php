@extends('layout.index')
@push('style')
@include('layout.datatableCSS')
@endpush
@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card card-primary card-outline">
					<div class="card-body">
						<ul class="nav nav-tabs" id="tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="kb" data-toggle="pill" href="#kb-tab" role="tab" aria-controls="kb-tab" aria-selected="true">Kelompok Bermain (KB)</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="tk" data-toggle="pill" href="#tk-tab" role="tab" aria-controls="tk-tab" aria-selected="false">Taman Kanak-kanak (TK)</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="sd" data-toggle="pill" href="#sd-tab" role="tab" aria-controls="sd-tab" aria-selected="false">Sekolah Dasar (SD)</a>
							</li>
						</ul>
						<div class="tab-content pt-3" id="tabContent">
							<div class="tab-pane fade show active" id="kb-tab" role="tabpanel" aria-labelledby="kb">
								<!-- Button to Open the Modal -->
								<button type="button" class="btn btn-primary btn-sm mt-2 btnAdd" data-tingkat="kb">
									<i class="fa fa-plus-circle" aria-hidden="true"></i>
									Tambah
								</button>
								<!-- tabel -->
								<div class="card-body">
									<table class="table table-bordered table-hover" id="datatable-kb">
										<thead>
											<tr>
												<th style="width: 50px;">No</th>
												<th>Nama Pembayaran</th>
												<th>Jumlah</th>
												<th>Aksi</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="tk-tab" role="tabpanel" aria-labelledby="tk">
								<!-- Button to Open the Modal -->
								<button type="button" class="btn btn-primary btn-sm mt-2 btnAdd" data-tingkat="tk">
									<i class="fa fa-plus-circle" aria-hidden="true"></i>
									Tambah
								</button>
								<!-- tabel -->
								<div class="card-body">
									<table class="table table-bordered table-hover" id="datatable-tk">
										<thead>
											<tr>
												<th style="width: 50px;">No</th>
												<th>Nama Pembayaran</th>
												<th>Jumlah</th>
												<th>Aksi</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="sd-tab" role="tabpanel" aria-labelledby="sd">
								<!-- Button to Open the Modal -->
								<button type="button" class="btn btn-primary btn-sm mt-2 btnAdd" data-tingkat="sd">
									<i class="fa fa-plus-circle" aria-hidden="true"></i>
									Tambah
								</button>
								<!-- tabel -->
								<div class="card-body">
									<table class="table table-bordered table-hover" id="datatable-sd">
										<thead>
											<tr>
												<th style="width: 50px;">No</th>
												<th>Nama Pembayaran</th>
												<th>Jumlah</th>
												<th>Aksi</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<br>
					</div>
					<!-- /.card -->
				</div>
			</div>
		</div>
	</div>
	<!-- /.col -->
</section>
<!-- /.content -->
<div class="modalArea"></div>
@endsection
@push('script')
@include('layout.datatableJS')
<script>
	var btnAdd = $('.btnAdd'),
	btnAddHtml = $(btnAdd).html(),
	modalArea = $('.modalArea'),
	route = "{{route('pembayaran.main')}}",
	routePembayaranForm = "{{route('pembayaran.form')}}",
	routePembayaranDelete = "{{route('pembayaran.delete')}}"
	$(async function () {
		// $('#tab button').on('click', function (event) {
		// 	event.preventDefault()
		// 	$(this).tab('show')
		// })
		await dataTable('kb')
	});

	$('a[data-toggle="pill"]').on('shown.bs.tab', async function (e) {
		console.log( $(e.target).attr('id') );
		await dataTable( $(e.target).attr('id') );
	});

	async function dataTable(tingkat) {
		await $(`#datatable-${tingkat}`).DataTable({
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
				url: route,
				data: {
					tingkat:tingkat
				}
			},
			columns: [
			{data:'DT_RowIndex', name:'DT_RowIndex', render: (data, type, row)=>{
				return `<p class="m-0 p-1">${data}</p>`
			}},
			{data:'nama', name:'nama'},
			{data:'nominal', name:'nominal'},
			{data:'actions', name:'actions'}
			],
		})
	}
	
	$(btnAdd).click(function (e) { 
		e.preventDefault();
		console.log($(this).data('tingkat'));
		$(modalArea).html('')
		$(btnAdd).html(spinnerSr);
		$.post(routePembayaranForm)
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
		$.post(routePembayaranForm,{id})
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
				$.post(routePembayaranDelete,{id})
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
</script>
@endpush