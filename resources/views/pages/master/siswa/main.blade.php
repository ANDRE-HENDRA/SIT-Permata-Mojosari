@extends('layout.index')
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
						<button type="button" class="btn btn-warning text-white btnImport ml-2">
							<i class="fa fa-file-import" aria-hidden="true"></i>
							Import
						</button>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<table class="table table-bordered table-hover" id="datatable">
							<thead>
								<tr>
									<th style="width: 50px;">No</th>
									<th>NIS/NISN</th>
									<th>Nama</th>
									<th>Tingkat</th>
									<th>Jenis Kelamin</th>
									<th>Tahun Masuk</th>
									<th>Aksi</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<!-- /.col -->

		</div>
		<br><br><br>

		
	</div><!-- /.container-fluid -->
</section>
<div class="modalArea"></div>
@endsection
@push('script')
	@include('layout.datatableJS')
	<script>
		var btnAdd = $('.btnAdd'),
		btnAddHtml = $(btnAdd).html(),
		modalArea = $('.modalArea'),
		route = "{{route('siswa.main')}}",
		routeSiswaForm = "{{route('siswa.form')}}",
		routeSiswaDelete = "{{route('siswa.delete')}}",
		routeSiswaRestore = "{{route('siswa.form')}}"
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
					{data:'nis_nisn', name:'nis_nisn'},
					{data:'nama', name:'nama'},
					{data:'tingkat', name:'tingkat'},
					{data:'jenis_kelamin', name:'jenis_kelamin'},
					{data:'tahun_masuk', name:'tahun_masuk'},
					{data:'actions', name:'actions'}
				],
			})
		}
	
		$(btnAdd).click(function (e) { 
			e.preventDefault();
			$(modalArea).html('')
			$(btnAdd).html(spinnerSr);
			$.post(routeSiswaForm)
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
			$.post(routeSiswaForm,{id})
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
				html: "<span>Data atas nama <b>"+nama+"</b> akan dihapus, yakin ingin melakukanya?</span>",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, hapus!"
			}).then((result) => {
				if (result.isConfirmed) {
					$(ini).html(spinnerSr)
					$.post(routeSiswaDelete,{id})
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
			$.post(routeSiswaRestore,{id})
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