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

function swalError(params='Silahkan hubungi admin!') {  
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

function ubahFormatRupiah(angka) {
	$(angka).val(formatRupiah(angka.value, "Rp. "));
}

function formatRupiah(angka, prefix) {
	if (angka.toString().charAt(0) === '0') {
		angka = angka.toString().substring(1);
	}
	var number_string = angka.toString().replace(/[^,\d]/g, "");
	split = number_string.split(",");
	sisa = split[0].length % 3;
	rupiah = split[0].substr(0, sisa);
	ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function hanyaAngka(ini) {
	$(ini).val($(ini).val().replace(/\D/g, ''))
}