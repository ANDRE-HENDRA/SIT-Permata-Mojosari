<!-- The Modal Tambah Siswa -->
<div class="modal fade" id="tambahKelas">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<form id="formKelas">
					<input type="hidden" name="kelas_id" @isset($kelas) value="{{$kelas->id}}" @endisset>
					<div class="mb-3">
						<label for="nama" class="form-label">Nama Kelas</label>
						<input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" readonly @isset($kelas) value="{{$kelas->nama}}" @endisset>
					</div>
					<div class="mb-3">
						<div class="form-group">
							<label>Cari Siswa</label>
							<select class="form-control select2" 
								style="width: 100%"
								onchange="triggerPilihSiswa()"
								id="tambah_siswa_id" 
								name="tambah_siswa_id"
							>
							</select>
							<input type="hidden" name="tambah_nis_nisn" id="tambah_nis_nisn">
							<input type="hidden" name="tambah_nama" id="tambah_nama">
						</div>
					</div>
					<div class="mb-3">
						{{-- <button class="btn btn-success btnPlus ml-auto">+</button> --}}
						<div class="spinner-area"></div>
					</div>
					<table class="table table-responsive table-borderless" id="table-kelas-siswa">
						<tbody>
						</tbody>
					</table>
				</form>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button class="btn btn-info btnSimpan" name="addsiswa">Submit</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--akhir tambah-->
<script>
	var modal = $('#tambahKelas'),
	btnSimpan = $('.btnSimpan'),
	// btnPlus = $('.btnPlus'),
	btnSimpanHtml = $(btnSimpan).html(),
	// btnPlusHtml = $(btnPlus).html(),
	routeStore = "{{route('kelasSiswa.store')}}",
	routeGetSiswa = "{{route('kelasSiswa.getSiswa')}}",
	kelasSiswa = JSON.parse(`{!! json_encode($kelas->kelas_siswa) !!}`),
	tingkat = ''
	@isset($kelas)
	tingkat = "{{$kelas->tingkat}}"
	@endisset
	$(function () {
		modal.modal({
			backdrop: 'static',
			show: true
		})
		$('#tambah_siswa_id').select2({
			width: "resolve",
			ajax: {
				url: "{{ route('kelasSiswa.cariSiswa') }}",
				dataType: 'json',
				type: 'POST',
				delay: 250,
				data: function(params) {
					var query = {
						q: params.term,
						tingkat: tingkat
					}
					return query;
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: '(' + item.id + ') ' + item.nama,
								id: item.id,
							}
						})
					};
				},
				cache: true,
			}
		});
		$.each(kelasSiswa, async function (indexInArray, valueOfElement) { 
			await appendSiswa(indexInArray,valueOfElement.siswa.id,valueOfElement.siswa.nama,valueOfElement.siswa.nis+'/'+valueOfElement.siswa.nisn)
		});
	});

	// $('#tambah_siswa_id').change(function (e) { 
	// 	e.preventDefault();
	// 	if ($('#tambah_siswa_id').val()!='') {
	// 		$(btnPlus).attr('disabled', false)
	// 	} else {
	// 		$(btnPlus).attr('disabled', true)
	// 	}
	// });

	$(btnSimpan).click(function (e) { 
		e.preventDefault();
		$(btnSimpan).html(spinnerSr);
		var data = new FormData($('#formKelas')[0])
		$.ajax({
			type: "post",
			url: routeStore,
			data: data,
			contentType: false,
			processData: false,
			dataType: "json"
		})
		.done(async (res)=>{
			$(btnSimpan).html(btnSimpanHtml);
			if (res.status=='success') {
				swalSuccess(res.message)
				modal.modal('hide')
				await dataTable()
			} else if (res.status=='restore') {
				Swal.fire({
					title: "Peringatan!",
					text: res.message,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, restore!"
				}).then((result) => {
					if (result.isConfirmed) {
						restore(res.restore_id)
					}
				})
			} else {
				swalWarning(res.message)
			}
		})
		.fail((err)=>{
			$(btnSimpan).html(btnSimpanHtml);
			swalError(err.response.message)
		});
	});

	async function minusSiswa(btn,event) {
		event.preventDefault()
		// console.log($(btn).data('index'));
		let curLength = $('.siswa').length
		let minusIndex = $(btn).data('index');
		await $(`#siswa_${minusIndex}`).remove();
		console.log(minusIndex);
		for (let index = 0; index < curLength; index++) {
			if (index<minusIndex) {
				console.log('continue');
				continue
			}
			if ($(`#siswa_${index+1}`).length) {
				console.log('yield');
				await appendSiswa(index,$(`#siswa_id_${index+1}`).val(),$(`#nama_siswa_${index+1}`).html(),$(`#nis_nisn_${index+1}`).html())
				await $(`#siswa_${index+1}`).remove();
			}
		}
	}

	async function appendSiswa(index,siswa_id='',nama_siswa='',nis_nisn='') {
		let html = `
			<tr class="siswa" id="siswa_${index}">
				<td>
					${index+1}
				</td>
				<td>
					<b><span id="nama_siswa_${index}">${nama_siswa}</span> (<span id="nis_nisn_${index}">${nis_nisn}</span>)</b>
					<input type="hidden" name="siswa_id[${index}]" id="siswa_id_${index}" value="${siswa_id}">
				</td>
				<td>
					<button class="btn btn-sm btn-danger" onclick="minusSiswa(this,event)" data-index="${index}"><i class="fa fa-trash" aria-hidden="true"></i></button>
				</td>
			</tr>`
		await $('#table-kelas-siswa tbody').append(html);
	}

	function triggerPilihSiswa() {
		if ($('#tambah_siswa_id').val()!=null) {
			$('.spinner-area').html(spinnerSr);
			var data = new FormData()
			data.append('id',$('#tambah_siswa_id').val())
			$.ajax({
				type: "post",
				url: routeGetSiswa,
				data: data,
				contentType: false,
				processData: false,
				dataType: "json"
			})
			.done(async (res)=>{
				$('.spinner-area').html('');
				if (res.status=='success') {
					$('#tambah_siswa_id').val('').trigger('change')
					swalSuccess('Siswa dimasukkan')
					let nowIndex = $('.siswa').length
					await appendSiswa(nowIndex,res.data.id,res.data.nama,res.data.nis_nisn)
					// modal.modal('hide')
					// await dataTable()
				// } else if (res.status=='restore') {
				// 	Swal.fire({
				// 		title: "Peringatan!",
				// 		text: res.message,
				// 		icon: "warning",
				// 		showCancelButton: true,
				// 		confirmButtonColor: "#3085d6",
				// 		cancelButtonColor: "#d33",
				// 		confirmButtonText: "Yes, restore!"
				// 	}).then((result) => {
				// 		if (result.isConfirmed) {
				// 			restore(res.restore_id)
				// 		}
				// 	})
				} else {
					swalWarning(res.message)
				}
			})
			.fail((err)=>{
				$('#tambah_siswa_id').val('').trigger('change')
				$('.spinner-area').html('');
				swalError(err.response.message)
			});
		}
	}
</script>