<div class="row">
	@if (count($pembayaran->pembayaran_kelas)<=0)
	<div class="col-12">
		<div class="m-auto">
			Data tidak ditemukan.
		</div>
	</div>
	@else
	@foreach ($pembayaran->pembayaran_kelas as $item)
	<a class="btn btn-app bg-success" onclick="form({{$item->id}})" style="height: auto">
		<i class="fas fa-money-bill"></i> 
		<span>{{$pembayaran->nama}}</span><br>
		<span>{{$item->kelas->nama}}</span><br>
		<span>{{$item->kelas->tahun_ajaran->tahun_awal.'/'.$item->kelas->tahun_ajaran->tahun_akhir}}</span>
	</a>
	@endforeach
	@endif
</div>