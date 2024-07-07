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
                    <h1 class="m-0">Pengaturan Akun</h1>
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
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahakun">
                                Tambah
                            </button>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sis al Jufri</td>
                                        <td>sisal</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editakun">
                                                <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteakun">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                hapus
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#resetakun">
                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                Reset
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editakun">
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
                                                            <label for="nama" class="form-label">Nama</label>
                                                            <input type="text" name="nama" class="form-control" id="nama" value="isikan sesuai sebelumnya" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input type="text" name="username" class="form-control" id="username" value="" required>
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
                                    <div class="modal fade" id="deleteakun">
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

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="resetakun">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Reset Password</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <h3 align="center">Anda akan me Reset akun <br>
                                                            <span class="text-warning"><!--panggil nis--> ?></span>
                                                        </h3>

                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-danger" name="deletesiswa">Ya</button>
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
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

            </div>

            <!-- The Modal Tambah Siswa -->
            <div class="modal fade" id="tambahakun">
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
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" value="" required>
                                </div>
                                <p>Password sesuai dengan nama username, untuk mengubah silahkan ubah sendiri ke menu Akun masing - masing pengguna.</p>
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