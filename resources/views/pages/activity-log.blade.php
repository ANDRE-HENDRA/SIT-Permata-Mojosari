@extends('layout.index')
@push('style')
	@include('layout.datatableCSS')
@endpush
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card card-primary card-outline">
					<div class="card-body">
						<div class="row mt-3">
							<div class="col-md-4">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
										<input type="text" class="form-control float-right" id="jarakTanggal" onchange="reloadDatatable()">
									</div>
								</div>
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-2">
								{{-- <a href="#"><button class="btn btn-success btnExport"><i class="fa fa-print"></i> Print</button></a> --}}
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<table class="table table-bordered table-hover" id="datatable-log" style="width: 100%">
									<thead>
										<tr>
											<th style="width: 50px;">No</th>
											<th>User</th>
											<th>Keterangan</th>
											<th>Tanggal</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						<br>
					</div>
					<!-- /.card -->
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@push('script')
@include('layout.datatableJS')
<script>
	var route = "{{route('activityLog.main')}}"
	$(async function () {
		await dataTable()
	});
	$('#jarakTanggal').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		}
	})

	$('.btnExport').click(function (e) { 
		e.preventDefault();
		
		window.open("{{route('laporan.import')}}"+"?"+"jarakTanggal="+$('#jarakTanggal').val()+'&tahun_ajaran_id='+$('#tahun_ajaran_id').val()+'&jenis_pembayaran='+$('#jenis_pembayaran').val(), "_blank").focus()
	});

	async function reloadDatatable() {
		await dataTable($('#jarakTanggal').val())
	}

	async function dataTable(jarakTanggal=$('#jarakTanggal').val()) {
		await $('#datatable-log').DataTable({
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
					jarakTanggal:jarakTanggal
				}
			},
			columns: [
			{data:'DT_RowIndex', name:'DT_RowIndex', render: (data, type, row)=>{
				return `<p class="m-0 p-1">${data}</p>`
			}},
			{data:'user', name:'user'},
			{data:'keterangan', name:'keterangan'},
			{data:'tanggal', name:'tanggal'}
			],
		})
	}
</script>
@endpush