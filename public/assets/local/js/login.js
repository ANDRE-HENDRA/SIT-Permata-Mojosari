$('.btnLogin').click((e)=>{
	e.preventDefault()
	var data = new FormData($('#formLogin')[0])
	$('.btnLogin').attr('disabled',true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>LOADING...')
	$.ajax({
		type: "post",
		url: routeLogin,
		data: data,
		contentType:false,
		processData:false
	}).done((response)=>{
		if (response.metadata.code == 200) {
			Swal.fire({
				icon: "success",
				title: "Berhasil!",
				text: response.metadata.message,
				showConfirmButton: false,
				timer: 1500
			});
			window.location.href = routeDashboard
		} else {
			Swal.fire({
				icon: "warning",
				title: "Gagal!",
				text: response.metadata.message,
			});
		}
		$('.btnLogin').attr('disabled',false).html('Login')
	}).fail((error)=>{
		Swal.fire({
			icon: "error",
			title: "Terjadi Kesalahan Sistem!",
			showConfirmButton: false,
			timer: 1500
		});
		$('.btnLogin').attr('disabled',false).html('Login')
	});
})