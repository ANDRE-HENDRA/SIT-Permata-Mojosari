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
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Laporan Harian</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Laporan Mingguan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Laporan Tahunan</a>
                            </li> --}}
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
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
                                    <div class="col-md-2">
                                        <select class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" onchange="reloadDatatable()">
                                            @foreach ($tahunAjaran as $item)
                                                <option value="{{$item->id}}">{{$item->tahun_awal.'/'.$item->tahun_akhir}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <select class="form-control" name="kelas_id" id="kelas_id">
                                        </select>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <select class="form-control" name="jenis_pembayaran" id="jenis_pembayaran" onchange="reloadDatatable()">
                                            <option value="semua">semua</option>
                                            @foreach ($jenisPembayaran as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#"><button class="btn btn-success btnImport"><i class="fa fa-print"></i> Print</button></a>
                                    </div>
                                </div>
                                <!-- tabel -->
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered table-hover" id="datatable-harian">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>NIS/NISN</th>
                                                    <th>Nama</th>
                                                    <th>Kelas</th>
                                                    <th>Tahun Ajaran</th>
                                                    <th>Jenis Pembayaran</th>
                                                    <th>Tanggal</th>
                                                    <th>Nominal</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!-- /tabel -->
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                <div class="col-sm-4 mt-3">
                                    <a href="#"><button class="btn btn-success"><i class="fa fa-print"></i> Print</button></a>
                                </div>
                                <!-- tabel -->
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">No</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Jenis Pembayaran</th>
                                                <th>Periode<br>(Mingguan)</th>
                                                <th>Nominal</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- /tabel -->
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                <div class="col-sm-4 mt-3">
                                    <a href="#"><button class="btn btn-success"><i class="fa fa-print"></i> Print</button></a>
                                </div>
                                <!-- tabel -->
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">No</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Jenis Pembayaran</th>
                                                <th>Periode<br>(Tahunan)</th>
                                                <th>Nominal</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /tabel -->
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
    var kelas = {{Js::From($kelas)}},
	route = "{{route('laporan.main')}}"
    $(async function () {
        await dataTable()
    });
    $('#jarakTanggal').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		}
	})
    $('#tahun_ajaran_id').change(function (e) { 
        e.preventDefault();
        $('#kelas_id').html('');
        let tahunAjaranId = $('#tahun_ajaran_id').val()
        $.each(kelas, function (index, value) { 
            if (value.tahun_ajaran_id == tahunAjaranId) {
                $('#kelas_id').append(`<option value='${value.id}'>${value.nama}</option>`)
            }
        });
    });

    $('.btnImport').click(function (e) { 
        e.preventDefault();
        console.log('tes');
        
        window.open("{{route('laporan.import')}}"+"?"+"jarakTanggal="+$('#jarakTanggal').val()+'&tahun_ajaran_id='+$('#tahun_ajaran_id').val()+'&jenis_pembayaran='+$('#jenis_pembayaran').val(), "_blank").focus()
    });

    async function reloadDatatable() {
        await dataTable($('#jarakTanggal').val(),$('#tahun_ajaran_id').val(),$('#jenis_pembayaran').val())
    }

	async function dataTable(jarakTanggal=$('#jarakTanggal').val(),tahun_ajaran_id=$('#tahun_ajaran_id').val(),jenis_pembayaran=$('#jenis_pembayaran').val()) {
		await $('#datatable-harian').DataTable({
			stateSave: false,
			scrollX: true,
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
                    jarakTanggal:jarakTanggal,
                    tahun_ajaran_id:tahun_ajaran_id,
                    jenis_pembayaran:jenis_pembayaran
                }
			},
			columns: [
			{data:'DT_RowIndex', name:'DT_RowIndex', render: (data, type, row)=>{
				return `<p class="m-0 p-1">${data}</p>`
			}},
			{data:'nis', name:'nis'},
			{data:'nama', name:'nama'},
			{data:'kelas', name:'kelas'},
			{data:'tahun_ajaran', name:'tahun_ajaran'},
			{data:'jenis', name:'jenis'},
			{data:'tanggal_transaksi', name:'tanggal_transaksi'},
			{data:'nominal', name:'nominal'},
			{data:'keterangan', name:'keterangan'},
			{data:'actions', name:'actions'}
			],
		})
	}
</script>
@endpush