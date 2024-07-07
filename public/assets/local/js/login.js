
$(document).ready(function () {
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})
});

$('.btnLogin').click((e)=>{
	var data = new FormData($('#formLogin')[0])
	// console.log(data);
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
	}).fail((error)=>{
		Swal.fire({
			icon: "error",
			title: "Terjadi Kesalahan Sistem!",
			showConfirmButton: false,
			timer: 1500
		});
	});
})