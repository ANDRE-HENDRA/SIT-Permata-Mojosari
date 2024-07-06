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
                    <h1 class="m-0">Data jenis Pembayaran</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <!--awal coba-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Kelompok Bermain (KB)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Taman Kanak-kanak (TK)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Sekolah Dasar (SD)</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="custom-content-below-tabContent">
                                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                    <!-- Button to Open the Modal -->
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambahjeniskb">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        Tambah
                                    </button>
                                    <!-- tabel -->
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Nama Pembayaran</th>
                                                    <th>Jumlah</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>SPP</td>
                                                    <td>1.000.000.000</td>
                                                    <td>Wajib bagi yang mampu</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit">
                                                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                            edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            hapus
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
                                                                        <label for="nama" class="form-label">Nama Pembayaran</label>
                                                                        <input type="text" name="nama" class="form-control" id="nama" value="isi rujuk ke yang tadi" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jumlah" class="form-label">Jumlah</label>
                                                                        <input type="text" name="jumlah" class="form-control" id="jumlah" value="isi rujuk ke yang tadi" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                                        <input type="text" name="keterangan" class="form-control" id="keterangan" value="isi rujuk ke yang tadi" required>
                                                                    </div>

                                                                    <!-- tempat id editing ndre disini ta terserah wis-->
                                                                    <button type="submit" class="btn btn-info" name="updatejenis">Submit</button>
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
                                                                        <span class="text-warning"><!--panggil nama--> ?></span>
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
                                    <!-- /tabel -->
                                    <!-- The Modal Tambah Siswa -->
                                    <div class="modal fade" id="tambahjeniskb">
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
                                                            <label for="nama" class="form-label">Nama Pembayaran</label>
                                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlah" class="form-label">Jumlah</label>
                                                            <input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="Masukan jumlah" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan</label>
                                                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukan keterangan" required>
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
                                    <!--modal tambah-->

                                </div>
                                <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                    <!-- Button to Open the Modal -->
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambahjenistk">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        Tambah
                                    </button>
                                    <!-- tabel -->
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Nama Pembayaran</th>
                                                    <th>Jumlah</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>SPP</td>
                                                    <td>1.000.000.000</td>
                                                    <td>dimampu</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edittk">
                                                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                            edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletetk">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            hapus
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="edittk">
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
                                                                        <label for="nama" class="form-label">Nama Pembayaran</label>
                                                                        <input type="text" name="nama" class="form-control" id="nama" value="isi rujuk ke yang tadi" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jumlah" class="form-label">Jumlah</label>
                                                                        <input type="text" name="jumlah" class="form-control" id="jumlah" value="isi rujuk ke yang tadi" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                                        <input type="text" name="keterangan" class="form-control" id="keterangan" value="isi rujuk ke yang tadi" required>
                                                                    </div>

                                                                    <!-- tempat id editing ndre disini ta terserah wis-->
                                                                    <button type="submit" class="btn btn-info" name="updatejenis">Submit</button>
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
                                                <div class="modal fade" id="deletetk">
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
                                                                        <span class="text-warning"><!--panggil nama--> ?></span>
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
                                    <!-- /tabel -->
                                    <!-- The Modal Tambah Siswa -->
                                    <div class="modal fade" id="tambahjenistk">
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
                                                            <label for="nama" class="form-label">Nama Pembayaran</label>
                                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlah" class="form-label">Jumlah</label>
                                                            <input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="Masukan jumlah" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan</label>
                                                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukan keterangan" required>
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
                                    <!--modal tambah-->
                                </div>
                                <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                    <!-- Button to Open the Modal -->
                                    <H1>BELUM</H1>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambahjenissd">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        Tambah
                                    </button>
                                    <!-- tabel -->
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Nama Pembayaran</th>
                                                    <th>Jumlah</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>SPP</td>
                                                    <td>1.000.000.000</td>
                                                    <td>Wajib mampu</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editsd">
                                                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                            edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletesd">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            hapus
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editsd">
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
                                                                        <label for="nama" class="form-label">Nama Pembayaran</label>
                                                                        <input type="text" name="nama" class="form-control" id="nama" value="isi rujuk ke yang tadi" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jumlah" class="form-label">Jumlah</label>
                                                                        <input type="text" name="jumlah" class="form-control" id="jumlah" value="isi rujuk ke yang tadi" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                                        <input type="text" name="keterangan" class="form-control" id="keterangan" value="isi rujuk ke yang tadi" required>
                                                                    </div>

                                                                    <!-- tempat id editing ndre disini ta terserah wis-->
                                                                    <button type="submit" class="btn btn-info" name="updatejenis">Submit</button>
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
                                                <div class="modal fade" id="deletesd">
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
                                                                        <span class="text-warning"><!--panggil nama--> ?></span>
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
                                    <!-- /tabel -->
                                    <!-- The Modal Tambah Siswa -->
                                    <div class="modal fade" id="tambahjenissd">
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
                                                            <label for="nama" class="form-label">Nama Pembayaran</label>
                                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlah" class="form-label">Jumlah</label>
                                                            <input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="Masukan jumlah" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan</label>
                                                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukan keterangan" required>
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
                                    <!--modal tambah-->
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

    <!--coba-->
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layout.footer')