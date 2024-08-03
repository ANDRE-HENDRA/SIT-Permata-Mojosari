<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">@isset($title)
					{{$title}}
				@endisset</h1>
			</div>
			@isset($menuActive)
				@if ($menuActive == 'Dashboard')
				<div class="col-6 col-md-2 offset-md-4">
					<div class="mb-3">
						<div class="form-group">
							<select class="form-control" name="tahun_ajaran" id="tahun_ajaran">
								@foreach ($tahunAjaran as $item)
									<option value="{{$item->id}}">{{$item->tahun_awal.'/'.$item->tahun_akhir}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				@endif
			@endisset
		</div>
	</div>
</div>
<!-- /.content-header -->