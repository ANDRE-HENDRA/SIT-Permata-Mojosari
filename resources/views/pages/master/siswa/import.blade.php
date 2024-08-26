@extends('layout.index')
@section('content')
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
	<symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
		<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
	</symbol>
</svg>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-main-website">
						Import Siswa
					</div>
					<div class="card-body">
						{{-- <div class="alert alert-primary d-flex align-items-center" role="alert">
							<svg class="bi flex-shrink-0 mr-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
							<div>
								Info <a href="javascript:void(0)" data-toggle="modal" data-target="#tutorial">(Klik disini)</a>
							</div>
						</div> --}}
						<form id="formImport">
							<div class="row">
								<div class="col-12">
									<label class="form-label d-block">Perhatikan!</label>
									
									<ul class="ms-4">
										<li>Urutan kolom di dalam table yang di upload</li>
										<div class="btn-group areaKolom" role="group" aria-label="Kolom">
											<input type="radio" class="d-none nis" name="nis" id="nis" autocomplete="off" checked readonly>
											<label class="btn btn-outline-primary btn-sm nis" for="nis">NIS</label>
											<input type="radio" class="d-none nisn" name="nisn" id="nisn" autocomplete="off" checked readonly>
											<label class="btn btn-outline-primary btn-sm nisn" for="nisn">NISN</label>
											<input type="radio" class="d-none nama" name="nama" id="nama" autocomplete="off" checked readonly>
											<label class="btn btn-outline-primary btn-sm nama" for="nama">Nama</label>
											<input type="radio" class="d-none jenis" name="jenis" id="jenis" autocomplete="off" checked readonly>
											<label class="btn btn-outline-primary btn-sm jenis" for="jenis">Jenis Kelamin (L/P)</label>
										</div>
										<li>
											File wajib excel (.xls / .xlsx)
										</li>
										<li>
											Tabel harus tanpa header
										</li>
										<img class="img-fluid" src="{{asset('tutorial/excelguru.PNG')}}" alt="">
										<li>
											<a href="{{route('siswa.downloadTemplate')}}" target='_blank' class="alert-link"><strong><u>Download template excel</u></strong></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-12 mb-3">
									<label for="nama" class="form-label">File Excel (.xls, xlsx) *</label>
									<input type="file" class="form-control" name="file" id="file" accept=".xls, .xlsx">
									<input type="hidden" name="urutan" id="urutan">
								</div>
								<div class="col-12 mb-3">
									<label for="tahun_masuk" class="form-label">Tahun Masuk</label>
									<input type="text" name="tahun_masuk" class="form-control filter-table tanggal text-center" id="tahun_masuk" required readonly>
								</div>
								<div class="col-12 mb-3">
									<div class="form-group">
										<label>Tingkat Sekolah</label>
										<select class="form-control" name="tingkat" id="tingkat">
											<option value="">- Pilih -</option>
											<option value="kb" @isset($siswa) @if($siswa->tingkat=='kb') selected @endif @endisset>KB</option>
											<option value="tk" @isset($siswa) @if($siswa->tingkat=='tk') selected @endif @endisset>TK</option>
											<option value="sd" @isset($siswa) @if($siswa->tingkat=='sd') selected @endif @endisset>SD</option>
										</select>
									</div>
								</div>
							</div>
							<hr>
							<div class="d-flex gap-2">
								<button class="btn btn-secondary px-4 btnKembali">KEMBALI</button>
								<button class="btn btn-primary px-4 btnUpload">UPLOADS</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal" id="tutorial" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Info</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row overflow-hidden">
					<p><strong>Perhatikan</strong></p>
					<ul class="ms-4">
						<li>
							File wajib excel (.xls / .xlsx)
						</li>
						<li>
							Tabel harus tanpa header
						</li>
						<img class="img-fluid" src="{{asset('tutorial/excelguru.PNG')}}" alt="">
						<li>
							Pilih kolom yang akan diupload (disamakan dengan urutan kolomnya excel)
						</li>
						<img class="img-fluid" src="{{asset('tutorial/select.png')}}" alt="">
						<li>
							Kolom yang bertanda (*) wajib ada di excel
						</li>
						<img class="img-fluid" src="{{asset('tutorial/wajib.png')}}" alt="">
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')

<script>
	var kolom = [
		{
			id:'nama',
			name:'Nama'
		},
		{
			id:'nisn',
			name:'NISN'
		},
		{
			id:'tmp_lahir',
			name:'Tempat Lahir'
		},
		{
			id:'tgl_lahir',
			name:'Tanggal Lahir'
		},
		{
			id:'gender',
			name:'Jenis Kelamin'
		},
		{
			id:'nama_ayah',
			name:'Nama Ayah'
		},
		{
			id:'nama_ibu',
			name:'Nama Ibu'
		},
		{
			id:'alamat',
			name:'Alamat'
		},
		{
			id:'no_tlp',
			name:'No Telp'
		},
		{
			id:'th _masuk',
			name:'Tahun Masuk'
		},
		// {
		// 	id:'foto',
		// 	name:'Foto'
		// },
		{
			id:'status',
			name:'Status'
		},
	]
	var selected = []
	var tahunMasuk = "{{date('Y')}}"
	$(document).ready(function () {
		$('#tahun_masuk').yearpicker({
			year: parseInt(tahunMasuk)
		})
		// renderPilihan()
	})

	function setUrutan() {
		let selectedId = $.map( selected, function( n, i ) {
				return n.id;
			});
		$('#urutan').val(selectedId.join(','))
	}
	
	function deleteSelectedKolom(kolom) {
		console.log('sss');
		const newSelected = selected.filter((item,index) => item.id != $(kolom).data('id'));
		selected = newSelected
		$('.'+$(kolom).data('id')).hide()
		renderPilihan()
		setUrutan()
	}
	
	function addSelectedKolom(kolom) {
		selected.push({id:$(kolom).data('id'),name:$(kolom).data('name')})
		$('.areaKolom').append(`
		<input type="radio" class="d-none ${$(kolom).data('id')}" name="${$(kolom).data('name')}" id="${$(kolom).data('id')}" checked>
		<label class="btn btn-sm btn-outline-primary ${$(kolom).data('id')}" for="${$(kolom).data('name')}" data-name="${$(kolom).data('name')}" data-id="${$(kolom).data('id')}" onclick="deleteSelectedKolom(this)">${$(kolom).data('name')}</label>
		`)
		renderPilihan()
		setUrutan()
	}
	
	function renderPilihan() {
		$('.areaPilihan').html('')
		kolom.forEach(element => {
			// if ($.inArray(element,selected)) {
				// if (selected.includes(element)) {
					if (selected.some(e => e.id == element.id)) {
						console.log('a');
						return
					}
					$('.areaPilihan').append(`<button type="button" class="btn btn-outline-primary btn-sm" data-id="${element.id}" data-name="${element.name}" onclick="addSelectedKolom(this)">${element.name}</button>`)
				});
			}
			
			// $('.btnKembali').click((e)=>{
			// 	e.preventDefault()
			// 	$('.other-page').empty()
			// 	$('.main-page').fadeIn()
			// })
			
			$('.btnUpload').click((e) => {
				e.preventDefault()
				var data = new FormData($('#formImport')[0])
				$('.btnUpload').attr('disabled',true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>LOADING...')
				$.ajax({
					url: '{{route("siswa.excelToArray")}}',
					type: 'POST',
					data: data,
					async: true,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data){
						if(data.status=='success'){
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: data.message,
								showConfirmButton: false,
								timer: 1200
							})
							setTimeout(()=>{
								// $('.other-page').fadeOut(()=>{
								// 	$('#datatabel').DataTable().ajax.reload()
								// 	location.reload()
								// })
								window.location = "{{route('siswa.main')}}"
							}, 1100);
							// location.reload()
						}else{
							Swal.fire({
								icon: 'warning',
								title: 'Whoops',
								text: data.message,
								showConfirmButton: false,
								timer: 1300,
							})
						}
						$('.btnUpload').attr('disabled',false).html('UPLOADS')
					}
				}).fail(()=>{
					Swal.fire({
						icon: 'error',
						title: 'Whoops..',
						text: 'Terjadi kesalahan silahkan ulangi kembali',
						showConfirmButton: false,
						timer: 1300,
					})
					$('.btnUpload').attr('disabled',false).html('UPLOADS')
				})
			})
			
		</script>
@endpush