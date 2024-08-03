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
				<div class="card">
					<div class="card-header">
						<!-- Button to Open the Modal -->
						<button type="button" class="btn btn-primary btnAdd">
							<i class="fa fa-plus-circle" aria-hidden="true"></i>
							Tambah
						</button>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
							{{-- <table class="table-responsive table table-striped table-bordered stripe row-border order-column" style="width:100%" id="datatable"> --}}
						<table class="table table-bordered table-hover" id="datatable">
							<thead>
								<tr>
									<th width="50px">No</th>
									<th>Nama Transaksi</th>
									<th>Periode</th>
									<th>Wajib</th>
									<th>Keterangan</th>
									<th>Aksi</th>
								</tr>
							</thead>
						</table>
					</div>
					<!-- /.card-body -->
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
	route = "{{route('jenisPembayaran.main')}}",
	routeJenisPembayaranForm = "{{route('jenisPembayaran.form')}}",
	routeJenisPembayaranDelete = "{{route('jenisPembayaran.delete')}}"
	$(async function () {
		await dataTable()
	});

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
		$.post(routeJenisPembayaranForm)
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
		$.post(routeJenisPembayaranForm,{id})
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
</script>
@endpush