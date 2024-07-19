var spinnerSr = `<div class="spinner-border spinner-border-sm" role="status">
		<span class="sr-only">Loading...</span>
	</div>`,
	spinner = `<div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	</div>`,
	spinnerLg = `<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
		<span class="sr-only">Loading...</span>
	</div>`

$(document).ready(function () {
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})
});

function dateCurrent(){
	let date = new Date()
	let days = date.getDate().toString().padStart(2, 0)
	let months = (date.getMonth() + 1).toString().padStart(2, 0)
	let years = date.getFullYear().toString()
	return {years: years, months: months, days: days}
}

$.fn.yearPicker = function(v){
	let $this = $(this)
	$this.yearpicker({
		year: Number(dateCurrent().years),
		endYear: Number(dateCurrent().years),
	})
}

function swalSuccess(params='') {  
	Swal.fire({
		title: 'Berhasil!',
		text: params,
		icon: 'success',
		showConfirmButton: false,
		timer: 500
	})
}

function swalError(params='') {  
	Swal.fire({
		title: 'Terjadi Kesalahan Sistem!',
		text: params,
		icon: 'error'
	})
}

function swalWarning(params='') {  
	Swal.fire({
		title: 'Gagal!',
		text: params,
		icon: 'warning',
	})
}