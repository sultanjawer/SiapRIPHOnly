@extends('layouts.admin')
@section('content')
{{-- @include('partials.breadcrumb') --}}
@include('partials.subheader')
@include('partials.sysalert')
<div class="row">
	<div class="col-lg-12">
		<div id="panel-1" class="panel">
			<div class="panel-hdr">
				<h2>
					Daftar Permohonan<span class="fw-300">|<i>SKL</i></span>
				</h2>
				<div class="panel-toolbar">
					@include('partials.globaltoolbar')
				</div>
			</div>
			<div class="panel-container show">
				<div class="panel-content">
					<div class="table">
						<table id="recomTable" class="table table-sm table-bordered table-hover table-striped w-100">
							<thead>
								<tr>
									<th>No. Pengajuan</th>
									<th>No. RIPH</th>
									<th>Pemohon</th>
									<th>Rekomendasi</th>
									<th>Status</th>
									<th>Tanggal Terbit</th>
									<th>Tindakan</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($recomends as $recomend)
									<tr>
										<td>{{$recomend->no_pengajuan}}</td>
										<td>{{$recomend->no_ijin}}</td>
										<td>{{$recomend->datauser->company_name}}</td>
										<td>
											@php
												$user = \App\Models\User::find($recomend->skl->submit_by);
											@endphp
											{{ $user ? $user->name : 'User Not Found' }}
										</td>										
										<td>
											@if($recomend->skl->published_date)
												<span class="badge btn-xs btn-success">Sudah Terbit</span>
											@else
												<span class="badge btn-xs btn-danger">Belum Terbit</span>
											@endif
										</td>
										<td>
											@if($recomend->skl->published_date)
												{{$recomend->skl->published_date}}
											@else
												<span class="badge btn-xs btn-danger">Belum Terbit</span>
											@endif
										</td>
										<td>
											@if($recomend->skl->published_date)
												<a href="" class="btn btn-xs btn-success btn-icon">
													<i class="fal fa-award"></i>
												</a>
											@else
												<a href="" class="btn btn-xs btn-primary btn-icon">
													<i class="fal fa-file-check">
													</i>
												</a>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
@parent
<script>
	$(document).ready(function()
	{

		// initialize datatable
		$('#recomTable').dataTable(
		{
			responsive: true,
			lengthChange: false,
			order: [[1, 'desc']],
			rowGroup: {
                dataSrc: 0
            },
			dom:
				"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			buttons: [
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf"></i>',
					titleAttr: 'Generate PDF',
					className: 'btn-outline-danger btn-sm btn-icon mr-1'
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel"></i>',
					titleAttr: 'Generate Excel',
					className: 'btn-outline-success btn-sm btn-icon mr-1'
				},
				{
					extend: 'csvHtml5',
					text: '<i class="fal fa-file-csv"></i>',
					titleAttr: 'Generate CSV',
					className: 'btn-outline-primary btn-sm btn-icon mr-1'
				},
				{
					extend: 'copyHtml5',
					text: '<i class="fa fa-copy"></i>',
					titleAttr: 'Copy to clipboard',
					className: 'btn-outline-primary btn-sm btn-icon mr-1'
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Print Table',
					className: 'btn-outline-primary btn-sm btn-icon mr-1'
				}
			]
		});

	});
</script>
@endsection

