@extends('layout.index')
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
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Laporan Mingguan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Laporan Tahunan</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
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
                                                <th>Tanggal</th>
                                                <th>Nominal</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>101100</td>
                                                <td>Sultan Agung</td>
                                                <td>TK A1</td>
                                                <td>2024/2025</td>
                                                <td>SPP</td>
                                                <td>Harini</td>
                                                <td>100.000</td>
                                                <td>
                                                    <span class="badge badge-success">Lunas</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>101100</td>
                                                <td>Airlangga hartarto</td>
                                                <td>TK A1</td>
                                                <td>2024/2025</td>
                                                <td>SPP</td>
                                                <td>Harini</td>
                                                <td>100.000</td>
                                                <td>
                                                    <span class="badge badge-danger">Belum Lunas</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>101100</td>
                                                <td>Sultan Agung</td>
                                                <td>TK A1</td>
                                                <td>2024/2025</td>
                                                <td>SPP</td>
                                                <td>Harini</td>
                                                <td>100.000</td>
                                                <td>
                                                    <span class="badge badge-success">Lunas</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>101100</td>
                                                <td>Airlangga hartarto</td>
                                                <td>TK A1</td>
                                                <td>2024/2025</td>
                                                <td>SPP</td>
                                                <td>Harini</td>
                                                <td>100.000</td>
                                                <td>
                                                    <span class="badge badge-danger">Belum Lunas</span>
                                                </td>
                                            </tr>
                                        </tbody>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>101100</td>
                                                <td>Sultan Agung</td>
                                                <td>TK A1</td>
                                                <td>2024/2025</td>
                                                <td>SPP</td>
                                                <td>Harini</td>
                                                <td>100.000</td>
                                                <td>
                                                    <span class="badge badge-success">Lunas</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>101100</td>
                                                <td>Airlangga hartarto</td>
                                                <td>TK A1</td>
                                                <td>2024/2025</td>
                                                <td>SPP</td>
                                                <td>Harini</td>
                                                <td>100.000</td>
                                                <td>
                                                    <span class="badge badge-danger">Belum Lunas</span>
                                                </td>
                                            </tr>
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