<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
	<table class="table table-responsive" style="width: 100%">
		<thead>
			<tr>
				<th style="width: 50px;">No</th>
				<th>NIS/NISN</th>
				<th>Nama</th>
				<th>Kelas</th>
				<th>Tahun Ajaran</th>
				<th>Jenis Pembayaran</th>
				<th>Tanggal</th>
				<th>Nominal</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($transaksi as $item)
				<tr>
					<td>{{$loop->index+1}}</td>
					<td>{{$item->siswa->nis.'/'.$item->siswa->nisn}}</td>
					<td>{{$item->siswa->nama}}</td>
					<td>{{$item->kelas}}</td>
					<td>{{$item->tahun_ajaran}}</td>
					<td>{{$item->jenis_pembayaran}}</td>
					<td>{{$item->tanggal_transaksi}}</td>
					<td>{!! Help::currencyFormatDecimal($item->nominal) !!}</td>
					<td>{{$item->is_lunas?'Lunas':'Belum'}}</td>
				</tr>
			@endforeach
			<tr>
				<td colspan="6"></td>
				<td>total</td>
				<td>{!! Help::currencyFormatDecimal($total) !!}</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>