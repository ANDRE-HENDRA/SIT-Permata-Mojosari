
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
						<table class="table table-bordered table-hover" id="datatable">
							<thead>
								<tr>
									<th style="width: 50px;">No</th>
									<th>Nama Kelas</th>
									<th>Tahun Ajaran</th>
									<th>Jumlah Siswa</th>
									<th>Aksi</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.col -->
</section>
<div class="modalArea"></div>
@endsection
@push('script')
@include('layout.datatableJS')
<script>
	var btnAdd = $('.btnAdd'),
	btnAddHtml = $(btnAdd).html(),
	modalArea = $('.modalArea'),
	route = "{{route('kelasSiswa.main')}}",
	routeKelasForm = "{{route('kelasSiswa.form')}}"
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
				{data:'tahun_ajaran', name:'tahun_ajaran'},
				{data:'siswa', name:'siswa'},
				{data:'actions', name:'actions'}
			],
		})
	}

	$(btnAdd).click(function (e) { 
		e.preventDefault();
		$(modalArea).html('')
		$(btnAdd).html(spinnerSr);
		$.post(routeKelasForm)
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
		$.post(routeKelasForm,{id})
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
</script>
@endpush