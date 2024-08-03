<div class="row">
	@if (count($jenisPembayaran)<=0)
	<div class="col-12">
		<div class="m-auto">
			Data tidak ditemukan.
		</div>
	</div>
	@else
	@foreach ($jenisPembayaran as $item)
	<a class="btn btn-app" onclick="renderPembayaran({{$item->id}})">
		<span class="badge bg-success">{{count($item->pembayaran)}}</span>
		<i class="fas fa-money-bill"></i> {{$item->nama}}
	</a>
	@endforeach
	@endif
</div>