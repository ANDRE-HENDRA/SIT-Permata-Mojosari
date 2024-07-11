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
                    <h1 class="m-0">Data Kelas dan Semester</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSiswa">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                Tambah
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama Kelas</th>
                                        <th>Semester</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>TK1</td>
                                        <td>Ganjil</td>
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
                                                            <label for="nama" class="form-label">Nama Kelas</label>
                                                            <input type="text" name="nama" class="form-control" id="nama" value="isi rujuk ke yang tadi" required>
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
            </div>
        </div>
        <!-- /.col -->

</div>

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
                        <label for="nama" class="form-label">Nama Kelas</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
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
<!--akhir tambah-->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layout.footer')