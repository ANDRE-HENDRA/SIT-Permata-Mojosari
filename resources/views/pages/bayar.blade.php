@include('layout.header')
@include('layout.navbar')
@include('layout.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pembayaran</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group">
                                <label for="nama" class="col-form-label">Cari Siswa : </label>
                                <div class="input-group input-group-lg">
                                    <input type="search" class="form-control form-control-lg" placeholder="Masukkan NIS">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-1 mt-3">
                                    <div class="form-group">
                                        <label>Silahhkan Pilih Daftar Bayar</label>
                                        <select class="form-control">
                                            <option>SPP</option>
                                            <option>DPP</option>
                                            <option>Seragam</option>
                                            <option>Buku</option>
                                            <option>Sarana dan Prasarana</option>
                                            <option>Infaq</option>
                                        </select>
                                    </div>
                                </div>
                                <!--data-->
                                <div class="row">
                                    <form action="" method="POST">
                                        <div class="table-responsive  m-b-7 ml-1 mr-5">
                                            <table class="table table-borderless table-striped table-earning">
                                                <thead>
                                                    <tr>
                                                        <td>NIS</td>
                                                        <td>
                                                            : php
                                                            <input type="hidden" hiddem name="nis" value="kode php">
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>Nama Siswa</td>
                                                        <td>
                                                            : php
                                                            <input type="hidden" hidden name="nama" value="php">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kelas</td>
                                                        <td>
                                                            : php
                                                            <input type="hidden" hidden name="kelas" value="php">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tahun Pelajaran</td>
                                                        <td>
                                                            : php
                                                            <input type="hidden" hidden name="tapel" value="php">

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Pembayaran</td>
                                                        <td>
                                                            : php
                                                            <input type="hidden" hidden name="tapel" value="php">

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nominal</td>
                                                        <td>
                                                            : php
                                                            <input type="hidden" name="nominal" hidden value="php">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="bayar2">Bayar</label></td>
                                                        <td><!-- <input type="text" class="form-control xs-2" id="bayar2" name="bayar"> -->
                                                            <div class="input-group mb-2">
                                                                : <div class="input-group-prepend">
                                                                    <div class="input-group-text"><b>Rp</b></div>
                                                                </div>
                                                                <input type="text" class="form-control xs-2" id="bayar2" name="bayar">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="submit" class="btn btn-success" name="byrbtn" value="Bayar"></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <!--penutup data-->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Sisa Nominal</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>kain dan atribut</td>
                                        <td>100.0000</td>
                                        <td>lunas</td>
                                        <td>25.000</td>
                                        <th>06-07-2024</th>
                                        <td>sebulan sekali</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <div class="mb-3">
                                                            <label for="nis" class="form-label">Nomor Induk Siswa (NIS)</label>
                                                            <input type="text" name="nis" class="form-control" id="nis" value="isi rujuk ke yang tadi" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama" class="form-label">Nama</label>
                                                            <input type="text" name="nama" class="form-control" id="nama" value="" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label>Kelas</label>
                                                                <select class="form-control">
                                                                    <option>TK A1</option>
                                                                    <option>TK A2</option>
                                                                    <option>TK A3</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label>Semester</label>
                                                                <select class="form-control">
                                                                    <option>Ganjil</option>
                                                                    <option>Genap</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label>Tahun Ajaran</label>
                                                                <select class="form-control">
                                                                    <option>2024/2025</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- tempat id editing ndre disini ta terserah wis-->
                                                        <button type="submit" class="btn btn-info" name="updatesiswa">Submit</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </form>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- edit -->

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <h3 align="center">Apakah anda yakin menghapus data ?<br>
                                                            <span class="text-warning"><!--panggil nis--> ?></span>
                                                        </h3>

                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-danger" name="deletesiswa">hapus</button>
                                                    </form>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>
            <br><br><br>

            <!-- The Modal Tambah Siswa -->
            <div class="modal fade" id="tambahSiswa">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="nis" class="form-label">Nomor Induk Siswa (NIS)</label>
                                    <input type="text" name="nis" class="form-control" id="nis" value="silahkan masukkan NIS" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="" required>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select class="form-control">
                                            <option>TK A1</option>
                                            <option>TK A2</option>
                                            <option>TK A3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <select class="form-control">
                                            <option>Ganjil</option>
                                            <option>Genap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Tahun Ajaran</label>
                                        <select class="form-control">
                                            <option>2024/2025</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info" name="addsiswa">Submit</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layout.footer')