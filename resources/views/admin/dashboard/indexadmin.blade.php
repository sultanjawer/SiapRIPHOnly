@extends('layouts.admin')
@section('content')
{{-- @include('partials.breadcrumb') --}}
{{-- @include('partials.subheader') --}}
@can('dashboard_access')
<!-- Page Content -->
<div class="subheader d-print-none">
	<h1 class="subheader-title">
		<i class="subheader-icon {{ ($heading_class ?? '') }}"></i><span class="fw-700 mr-2">{{  ($page_heading ?? '') }}</span><span class="fw-300">Realisasi & Verifikasi</span>
	</h1>
	
	<div class="subheader-block d-lg-flex align-items-center">
		<div class="d-inline-flex flex-column justify-content-center ">
			<select type="text" id="periodetahun" class="form-control form-control-sm custom-select" data-toggle="tooltip" title data-original-title="pilih tahun laporan">
				<option hidden>- pilih tahun laporan</option>
				<option value="" hidden>--pilih tahun</option>
				@foreach($periodeTahuns as $periodetahun => $records)
					<option value="{{ $periodetahun }}">Tahun {{ $periodetahun }}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="row">
		<div class="col-md-3">
			<div class="panel rounded overflow-hidden position-relative text-white mb-g">
				<div class="card-body bg-danger-300">
					<div class="">
						<h3 class="display-5 d-block l-h-n m-0 fw-500 text-white" data-toggle="tooltip" title data-original-title="Jumlah Perusahaan Pemegang RIPH">
							<!-- nilai ini diperoleh dari jumlah seluruh pengajuan yang belum diverifikasi. where status = 1 (user) -->
							<span id="jumlah_importir">{{ number_format($riph_admin[0]->jumlah_importir, 0, ',', '.') }}</span>
							<small class="m-0 l-h-n">Perusahaan / <span id="company" class="mr-1"></span>Terdaftar</small> 
						</h3>
					</div>
				</div>
				<i class="fal fa-landmark position-absolute pos-right pos-bottom opacity-25 mb-n1 mr-n1" style="font-size:4rem"></i>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel rounded overflow-hidden position-relative text-white mb-g">
				<div class="card-body bg-warning-400">
					<div class="">
						<h3 class="display-5 d-block l-h-n m-0 fw-500 text-white" data-toggle="tooltip" title data-original-title="Jumlah volume import pada periode ini.">
							<!-- nilai ini diperoleh dari jumlah seluruh pengajuan yang belum diverifikasi. where status = 1 (user) -->
							<span id="v_pengajuan_import">{{ number_format($riph_admin[0]->v_pengajuan_import, 0, ',', '.') }}</span>
							<small class="m-0 l-h-n">Volume Import (ton)</small>
						</h3>
					</div>
				</div>
				<i class="fal fa-balance-scale position-absolute pos-right pos-bottom opacity-40 mb-n1 mr-n1" style="font-size:4rem"></i>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel rounded overflow-hidden position-relative text-white mb-g">
				<div class="card-body bg-info-300">
					<div class="">
						<h3 class="display-5 d-block l-h-n m-0 fw-500 text-white" data-toggle="tooltip" title data-original-title="Jumlah wajib tanam pada periode ini.">
							<!-- nilai ini diperoleh dari jumlah seluruh pengajuan yang belum diverifikasi. where status = 1 (user) -->
							<span id="v_beban_tanam">{{ number_format($riph_admin[0]->v_beban_tanam, 0, ',', '.') }}</span>
							<small class="m-0 l-h-n">Kewajiban Tanam (ha)</small>
						</h3>
					</div>
				</div>
				<i class="fal fa-seedling position-absolute pos-right pos-bottom opacity-40 mb-n1 mr-n1" style="font-size:4rem"></i>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel rounded overflow-hidden position-relative text-white mb-g">
				<div class="card-body bg-success-500">
					<div class="">
						<h3 class="display-5 d-block l-h-n m-0 fw-500 text-white" data-toggle="tooltip" title data-original-title="Jumlah wajib tanam pada periode ini.">
							<!-- nilai ini diperoleh dari jumlah seluruh pengajuan yang belum diverifikasi. where status = 1 (user) -->
							<span id="v_beban_produksi">{{ number_format($riph_admin[0]->v_beban_produksi, 0, ',', '.') }}</span>
							<small class="m-0 l-h-n">Kewajiban Produksi (ton)</small>
						</h3>
					</div>
				</div>
				<i class="fal fa-dolly position-absolute pos-right pos-bottom opacity-40 mb-n1 mr-n1" style="font-size:4rem"></i>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel" id="panel-2">
				<div class="panel-hdr">
					<h2>
						<i class="subheader-icon fal fa-seedling mr-1"></i>Wajib Tanam
					</h2>
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<!-- Row -->
						<div class="row mb-3 align-items-center">
							<div class="col-lg-5 col-sm-6 align-self-center text-center">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="realisasiTanam" role="tabpanel" aria-labelledby="realisasi">
										<div class="c-chart-wrapper">
											<div  id = "naschart" class="js-easy-pie-chart color-success-500 position-relative d-inline-flex align-items-center justify-content-center" data-percent="75.74" data-piesize="145" data-linewidth="10" data-linecap="butt" data-scalelength="7" data-toggle="tooltip" title data-original-title="74,24% dari Kewajiban" data-placement="bottom">
												<div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
													<span class="fs-xxl fw-500 text-dark">74.24<sup>%</sup></span>
													<!--<span class="display-3 fw-500 js-percent d-block text-dark">97.68</span>-->
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="verifikasiTanam" role="tabpanel" aria-labelledby="verifikasiTanam">
										<div class="c-chart-wrapper">
											<div  id = "naschart" class="js-easy-pie-chart color-primary-500 position-relative d-inline-flex align-items-center justify-content-center" data-percent="75.74" data-piesize="145" data-linewidth="10" data-linecap="butt" data-scalelength="7" data-toggle="tooltip" title data-original-title="74,24% dari Kewajiban" data-placement="bottom">
												<div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
													<span class="fs-xxl fw-500 text-dark">74.24<sup>%</sup></span>
													<!--<span class="display-3 fw-500 js-percent d-block text-dark">97.68</span>-->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-7 col-sm-6">
								<nav class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link shadow-1 p-1 btn-block btn-success bg-success-300 rounded overflow-hidden position-relative text-white mb-2 waves-effect waves-themed" id="v-pills-home-tab" data-toggle="pill" href="#real_Tanam" role="tab" aria-controls="v-pills-home" aria-selected="true">
										<div class="">
											<span class="small">Realisasi</span>
											<div class="d-flex">
												<h5 class="d-block l-h-n m-0 fw-500 mr-1" id="total_luastanam">...</h5>
												<span>ha</span>
											</div>
										</div>
										<i class="fal fa-hand-holding-seedling position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:3rem"></i>
									</a>
									<a class="nav-link  shadow-1 p-1 btn-block btn-primary bg-primary-300 rounded overflow-hidden position-relative text-white mb-2 waves-effect waves-themed" id="v-pills-profile-tab" data-toggle="pill" href="#verifikasiTanam" role="tab" aria-controls="v-pills-profile" aria-selected="false">
										<div class="">
											<span class="small">Verifikasi</span>
											<h5 class="d-block l-h-n m-0 fw-500">
												123.456.789 ha
											</h5>
										</div>
										<i class="fal fa-hand-holding-seedling position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:3rem"></i>
									</a>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel" id="panel-2">
				<div class="panel-hdr">
					<h2>
						<i class="subheader-icon fal fa-seedling mr-1"></i>Wajib Produksi
					</h2>
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<!-- Row -->
						<div class="row mb-3 align-items-center">
							<div class="col-lg-5 col-sm-6 align-self-center text-center">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="realisasiProduksi" role="tabpanel" aria-labelledby="v-pills-home-tab">
										<div class="c-chart-wrapper">
											<div  id = "naschart" class="js-easy-pie-chart color-warning-500 position-relative d-inline-flex align-items-center justify-content-center" data-percent="75.74" data-piesize="145" data-linewidth="10" data-linecap="butt" data-scalelength="7" data-toggle="tooltip" title data-original-title="74,24% dari Kewajiban" data-placement="bottom">
												<div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
													<span class="fs-xxl fw-500 text-dark">74.24<sup>%</sup></span>
													<!--<span class="display-3 fw-500 js-percent d-block text-dark">97.68</span>-->
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="verifikasiProduksi" role="tabpanel" aria-labelledby="v-pills-profile-tab">
										<div class="c-chart-wrapper">
											<div  id = "naschart" class="js-easy-pie-chart color-primary-500 position-relative d-inline-flex align-items-center justify-content-center" data-percent="75.74" data-piesize="145" data-linewidth="10" data-linecap="butt" data-scalelength="7" data-toggle="tooltip" title data-original-title="74,24% dari Kewajiban" data-placement="bottom">
												<div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
													<span class="fs-xxl fw-500 text-dark">74.24<sup>%</sup></span>
													<!--<span class="display-3 fw-500 js-percent d-block text-dark">97.68</span>-->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-7 col-sm-6">
								<nav class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link shadow-1 p-1 btn-block btn-warning bg-warning-300 rounded overflow-hidden position-relative text-white mb-2 waves-effect waves-themed" id="v-pills-home-tab" data-toggle="pill" href="#realisasiProduksi" role="tab" aria-controls="realisasiProduksi" aria-selected="true">
										<div class="">
											<span class="small">Realisasi</span>
											<div class="d-flex">
												<h5 class="d-block l-h-n m-0 fw-500 mr-1" id="total_volume">...</h5>
												<span>ton</span>
											</div>
										</div>
										<i class="fal fa-hand-holding-seedling position-absolute pos-right pos-bottom opacity-35 mb-n1 mr-n1" style="font-size:3rem"></i>
									</a>
									<a class="nav-link  shadow-1 p-1 btn-block btn-primary bg-primary-300 rounded overflow-hidden position-relative text-white mb-2 waves-effect waves-themed" id="v-pills-profile-tab" data-toggle="pill" href="#verifikasiProduksi" role="tab" aria-controls="v-pills-profile" aria-selected="false">
										<div class="">
											<span class="small">Verifikasi</span>
											<h5 class="d-block l-h-n m-0 fw-500">
												123.456.789 ton
											</h5>
										</div>
										<i class="fal fa-hand-holding-seedling position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:3rem"></i>
									</a>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
						
	<div class="row">
		<!-- Tabel Verifikasi
			Nilai Tabel chart ini diperoleh dari kueri data verifikasi dengan status mulai dari 0 s. d 5. Temporary tabel sesuai dengan tampilan pada layar html.
			Setiap status merupakan pintasan cepat ke halaman terkait.
		-->
		<div class="col-md-12">
			<div class="panel" id="panel-2">
				<div class="panel-hdr">
					<h2>
						<i class="subheader-icon fal fa-ballot-check mr-1"></i>Verification <span class="fw-300"><i>Tasks</i></span>
					</h2>
					<div class="panel-toolbar">
						@include('layouts.globaltoolbar')
					</div>
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<div class="row">
							<div class="col-md-2">
								<div class="shadow-1 p-2 bg-primary-50 rounded overflow-hidden position-relative text-white mb-2">
									<div class="">
										<h5 class="d-block l-h-n m-0 fw-500">
											123.456.789 ha
										</h5>
										<span class="small">Pengajuan</span>
									</div>
									<i class="fal fa-download position-absolute pos-right pos-bottom opacity-30 mb-n1 mr-n1" style="font-size:3rem"></i>
								</div>
							</div>
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-3">
										<div class="shadow-1 p-2 bg-primary-100 rounded overflow-hidden position-relative text-white mb-2">
											<div class="">
												<h5 class="d-block l-h-n m-0 fw-500">
													123.456.789 ha
												</h5>
												<span class="small">Pengajuan</span>
											</div>
											<i class="fal fa-download position-absolute pos-right pos-bottom opacity-30 mb-n1 mr-n1" style="font-size:3rem"></i>
										</div>
									</div>
									<div class="col-md-3">
										<div class="shadow-1 p-2 bg-primary-200 rounded overflow-hidden position-relative text-white mb-2">
											<div class="">
												<h5 class="d-block l-h-n m-0 fw-500">
													123.456.789 ha
												</h5>
												<span class="small">Diverifikasi</span>
											</div>
											<i class="fal fa-hourglass position-absolute pos-right pos-bottom opacity-30 mb-n1 mr-n1" style="font-size:3rem"></i>
										</div>
									</div>
									<div class="col-md-3">
										<div class="shadow-1 p-2 bg-primary-300 rounded overflow-hidden position-relative text-white mb-2">
											<div class="">
												<h5 class="d-block l-h-n m-0 fw-500">
													123.456.789 ha
												</h5>
												<span class="small">Terverifikasi</span>
											</div>
											<i class="fal fa-check-circle position-absolute pos-right pos-bottom opacity-30 mb-n1 mr-n1" style="font-size:3rem"></i>
										</div>
									</div>
									<div class="col-md-3">
										<div class="shadow-1 p-2 bg-primary-400 rounded overflow-hidden position-relative text-white mb-2">
											<div class="">
												<h5 class="d-block l-h-n m-0 fw-500">
													123.456.789 ha
												</h5>
												<span class="small">Lunas</span>
											</div>
											<i class="fal fa-award position-absolute pos-right pos-bottom opacity-30 mb-n1 mr-n1" style="font-size:3rem"></i>
										</div>
									</div>
								</div>
							</div>
						</div><hr>
						<div class="table dataTables_wrapper dt-bootstrap4">
						<table id="sum_verif"  class="dtr-inline table table-bordered ajaxTable table-hover datatable table-sm w-100">
							<thead  class="bg-primary-100 text-white text-center">
						{{-- <table id="sum_verif" class="table table-bordered table-hover table-sm w-100 dataTable">
							<thead class="bg-gradient text-white text-center fw-500"> --}}
								
								<tr>
									<th  width="10"></th>
									<th rowspan="2">Perusahaan</th>
									<th rowspan="2">Nomor RIPH</th>
									<th colspan="2">Tahap 1 <sup>(Lapangan)</sup></th>
									<th rowspan="2">Tahap 2 <sup>(Online)</sup></th>
									<th rowspan="2">Tahap 3 <sup>SKL</sup></th>
									<th rowspan="2">Status</th>
								</tr>
								<tr>
									<th></th>
									<th>Tanam</th>
									<th>Produksi</th>
								</tr>
							</thead>
							<tbody class="text-center">
								<tr>
									<td></td>
									<td class="text-left">PT. Bawang Nusantara</td>
									<td>xxxx/PP.240/D/MM/YYY</td>
									<td><a class="badge btn-sm btn-info" href="/verifikasi/onfarm">Submitted</a></td>
									<td><a class="badge btn-sm btn-info" href="/verifikasi/onfarm">Submitted</a></td>
									<td><a class="badge btn-sm btn-info" href="/verifikasi/online">Submitted</a></td>
									<td><a class="badge btn-sm btn-default">No Status</a></td>
									<td>-</td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page Content -->

@endcan
@endsection
@section('scripts')
@parent
	
	<script>
		$(document).ready(function() {
			$('#periodetahun').on('change', function() {
				var periodetahun = $(this).val();
				var url = '/api/getApiDashboardDatabyYear/' + periodetahun;

				$.get(url, function (data) {
					$('#jumlah_importir').text(data.jumlah_importir);
					$('#v_pengajuan_import').text(formatNumber(data.v_pengajuan_import));
					$('#v_beban_tanam').text(formatNumber(data.v_beban_tanam));
					$('#v_beban_produksi').text(formatNumber(data.v_beban_produksi));
					$('#company').text(data.company);
					$('#volume_import').text(formatdecimals(data.volume_import));
					$('#total_luastanam').text(formatdecimals(data.total_luastanam));
					$('#total_volume').text(formatdecimals(data.total_volume));
				});

				function formatNumber(number) {
					return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
				}

				function formatdecimals(number) {
					var parts = number.toFixed(2).toString().split(".");
					var formattedNumber = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
					if (parts.length > 1) {
						formattedNumber += "," + parts[1];
					} else {
						formattedNumber += ",00"; // Add two decimal places if there are none
					}
					return formattedNumber;
				}
			});
		});

	</script>
@endsection