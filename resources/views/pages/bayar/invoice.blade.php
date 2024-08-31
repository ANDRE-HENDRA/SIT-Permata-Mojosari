<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Invoice</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<style>
		body{
			background:#eee;
			/* margin-top:20px; */
		}
		.text-danger strong {
			color: #9f181c;
		}
		.receipt-main {
			background: #ffffff none repeat scroll 0 0;
			border-bottom: 12px solid #333333;
			border-top: 12px solid #9f181c;
			margin-top: 5px;
			margin-bottom: 5px;
			padding: 4px 3px !important;
			position: relative;
			box-shadow: 0 1px 21px #acacac;
			color: #333333;
			font-family: open sans;
		}
		.receipt-main p {
			color: #333333;
			font-family: open sans;
			line-height: 1.42857;
		}
		.receipt-footer h1 {
			font-size: 15px;
			font-weight: 400 !important;
			margin: 0 !important;
		}
		.receipt-main::after {
			background: #414143 none repeat scroll 0 0;
			content: "";
			height: 5px;
			left: 0;
			position: absolute;
			right: 0;
			top: -13px;
		}
		.receipt-main thead {
			background: #414143 none repeat scroll 0 0;
		}
		.receipt-main thead th {
			color:#fff;
		}
		.receipt-right h5 {
			font-size: 16px;
			font-weight: bold;
			margin: 0 0 7px 0;
		}
		.receipt-right p {
			font-size: 12px;
			margin: 0px;
		}
		.receipt-right p i {
			text-align: center;
			width: 18px;
		}
		.receipt-main td {
			padding: 1px 2px !important;
		}
		.receipt-main th {
			padding: 13px 20px !important;
		}
		.receipt-main td {
			font-size: 13px;
			font-weight: initial !important;
		}
		.receipt-main td p:last-child {
			margin: 0;
			padding: 0;
		}	
		.receipt-main td h2 {
			font-size: 20px;
			font-weight: 900;
			margin: 0;
			text-transform: uppercase;
		}
		.receipt-header-mid .receipt-left h1 {
			font-weight: 100;
			margin: 8px 0 0;
			text-align: right;
			text-transform: uppercase;
		}
		.receipt-header-mid {
			margin: 6px 0;
			overflow: hidden;
		}
		
		#container {
			background-color: #dcdcdc;
		}

		hr {
			border: none;
			border-top: 1px dotted #f00;
			color: #fff;
			background-color: #fff;
			height: 1px;
			margin: 0;
			padding: 0;
		}

		.bg-lunas {
			background-image: url("{{asset('img/lunas.png')}}");
		}
	</style>
</head>
<body>
	<div class="col-md-12">
		@foreach ([1,2] as $printLoop)
		<div class="row">
			
			<div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
				<div class="row">
					<div class="receipt-header">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="receipt-left" style="display: flex">
								<img class="img-responsive" alt="iamgurdeeposahan" src="{{asset('img/logo.jpeg')}}" style="width: 71px; border-radius: 43px;">
								<img class="img-responsive" alt="iamgurdeeposahan" src="{{asset('img/logo2.jpeg')}}" style="width: 71px; border-radius: 43px;">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 text-right">
							<div class="receipt-right">
								<h5>SIT Permata Mojosari.</h5>
								{{-- <p>-<i class="fa fa-phone"></i></p>
								<p>-<i class="fa fa-envelope-o"></i></p> --}}
								<p>Mojokerto<i class="fa fa-location-arrow"></i></p>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="receipt-header receipt-header-mid">
						<div class="col-xs-8 col-sm-8 col-md-8 text-left">
							<div class="receipt-right">
								<P><b>Nama :</b> {{$transaksi->siswa->nama}}</P>
								<p><b>Nis :</b> {{$transaksi->siswa->nis}}</p>
								<p><b>Nisn :</b> {{$transaksi->siswa->nisn}}</p>
								<p><b>Kelas :</b> {{$transaksi->kelas}}</p>
								<p><b>Jenis Pembayaran :</b> {{$transaksi->jenis_pembayaran}}</p>
								<p><b>Tanggal transaksi :</b> {{$transaksi->tanggal_transaksi}}</p>
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4">
							<div class="receipt-left">
								<h3>INVOICE # {{$transaksi->kode}}</h3>
							</div>
						</div>
					</div>
				</div>
				
				<div>
					<table class="table">
						<thead>
							<tr>
								<th width="70%">Deskripsi</th>
								<th width="30%">Nominal</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($transaksi->pembayaran->detail_pembayaran as $item)
							<tr>
								<td class="col-md-9">{{$item->keterangan}}</td>
								<td class="col-md-3"><i class="fa fa-inr"></i> {!! Help::currencyFormatDecimal($item->nominal) !!}</td>
							</tr>
							@endforeach
							<tr>
								
								<td class="text-right"><h2><strong>Total: </strong></h2></td>
								<td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> {!! Help::currencyFormatDecimal($transaksi->nominal) !!}</strong></h2></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="row">
					<div class="receipt-header receipt-header-mid receipt-footer">
						<div class="col-xs-6 col-sm-6 col-md-6 text-left">
							<div class="receipt-right">
								<p><b>Date :</b>{{$transaksi->tanggal_transaksi}}</p>
								<h5 style="color: rgb(140, 140, 140);">SIT Permata Meri</h5>
							</div>
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2">
						@if ($transaksi->is_lunas)
							<img src="{{asset('img/lunas.png')}}" alt="" style="width:100%;padding-left:-20px">
						@endif
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2">
							<div class="receipt-left">
								{{-- <h1>Stamp</h1> --}}
								<div style="width: 20%">
									{!! QrCode::size(82)->generate($transaksi->kode) !!}
								</div>
								{{-- <img src="data:image/png;base64, " alt=""> --}}
							</div>
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2">
						</div>
					</div>
				</div>
				
			</div>    
		</div>
		<hr>
		@endforeach
	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="{{ asset('lte')}}/plugins/jquery/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		$(function () {
			window.print()
		});
	</script>
</body>
</html>