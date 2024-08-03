@extends('layout.index')
@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<button type="button" class="btn btn-primary btn-sm btnAdd">
							Tambah
						</button>
					</div>
					<!-- /.card-header -->
					<div class="card-body p-0">
						<table class="table table-bordered table-hover" id="datatable">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Username</th>
									<th>aksi</th>
								</tr>
							</thead>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->

		</div>

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
		route = "{{route('user.main')}}",
		routeUserForm = "{{route('user.form')}}",
		routeUserDelete = "{{route('user.delete')}}",
		routeUserReset = "{{route('user.reset')}}"
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
					{data:'username', name:'username'},
					{data:'name', name:'name'},
					{data:'actions', name:'actions'}
				],
			})
		}
	
		$(btnAdd).click(function (e) { 
			e.preventDefault();
			$(modalArea).html('')
			$(btnAdd).html(spinnerSr);
			$.post(routeUserForm)
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
			$.post(routeUserForm,{id})
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
					$.post(routeUserDelete,{id})
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
		
		function reset(id,ini,name) {  
			let iniHtml = $(ini).html()
			Swal.fire({
				title: "Peringatan!",
				html: "<span>Password atas nama <b>"+name+"</b> akan direset, yakin ingin melakukanya?</span>",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, reset!"
			}).then((result) => {
				if (result.isConfirmed) {
					$(ini).html(spinnerSr)
					$.post(routeUserReset,{id})
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
	</script>
@endpush