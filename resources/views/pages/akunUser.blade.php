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
                    <h1 class="m-0">Profil Akun</h1>
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
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="card-body">
                                <p class="text-bold">Nama</p>
                                <p class="text-bold">Username</p>
                                <br>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Password saat ini</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" placeholder="nama anda">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="username" class="form-control" id="username" placeholder="username anda">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Ulangi Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" placeholder="password anda" onclick="showHide()">
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Perbarui</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
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
                                <p>username sesuai dengan nama username, untuk mengubah silahkan ubah sendiri ke menu Akun masing - masing pengguna.</p>
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