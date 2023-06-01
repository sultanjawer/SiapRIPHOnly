@extends('layouts.admin')
@section('content')
@include('partials.subheader')
<div class="row">
	<div class="col-12">
		<div id="panel-1" class="panel panel-lock show" data-panel-sortable data-panel-close data-panel-collapsed>
			<form action="{{ route('admin.profile.pejabat.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="panel-container show">
					<div class="panel-content">
						<div class="row mb-3">
							<div class="col-12">
								<div class="form-group">
									<label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
									<input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="nama" id="nama" value="{{ old('name', $user->name) }}" required>
									@if($errors->has('name'))
										<div class="invalid-feedback">
											{{ $errors->first('name') }}
										</div>
									@endif
									<span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-4">
								<div class="form-group">
									<label class="required" for="nip">Nomor Induk Pegawai</label>
									<input class="form-control {{ $errors->has('nip') ? 'is-invalid' : '' }}" type="text" name="nip" id="nip" value="{{ old('nip', $data_admin->nip ?? '') }}" required>
									@if($errors->has('nip'))
										<div class="invalid-feedback">
											{{ $errors->first('nip') }}
										</div>
									@endif
									<span class="help-block">isi data jabatan.</span>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label class="required" for="jabatan">Jabatan</label>
									<input class="form-control {{ $errors->has('jabatan') ? 'is-invalid' : '' }}" type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $data_admin->jabatan ?? '') }}" required>
									@if($errors->has('jabatan'))
										<div class="invalid-feedback">
											{{ $errors->first('jabatan') }}
										</div>
									@endif
									<span class="help-block">isi data jabatan.</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-5">
								<div class="form-group">
									<label class="form-label" for="sign_img">Scan Tandatangan</label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input {{ $errors->has('sign_img') ? 'is-invalid' : '' }}" id="sign_img" name="sign_img" aria-describedby="sign_img" value="{{ old('sign_img', $data_admin->sign_img ?? '') }}" required>
											<label class="custom-file-label" for="sign_img">
												@if($data_admin->sign_img)
													{{$data_admin->sign_img}}
												@else
												Pilih ttd...
												@endif
											</label>
										</div>
									</div>
									@if($errors->has('sign_img'))
										<div class="invalid-feedback">
											{{ $errors->first('sign_img') }}
										</div>
									@endif
									<span class="help-block">Unggah hasil pindah tandatangan Anda</span>
								</div>
							</div>
							<div class="col-lg-8 col-md-7">
								<div class="form-group">
									<label class="required" for="digital_sign">Tandatangan Digital (API KEY)</label>
									<input class="form-control {{ $errors->has('digital_sign') ? 'is-invalid' : '' }}" type="text" name="digital_sign" id="digital_sign" value="{{ old('digital_sign', $data_admin->digital_sign ?? '') }}" disabled="">
									@if($errors->has('digital_sign'))
										<div class="invalid-feedback">
											{{ $errors->first('digital_sign') }}
										</div>
									@endif
									<span class="help-block">API Key untuk tandatangan digital Anda (BSN). <span class="text-danger">Sementara belum tersedia.</span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-between align-items-center">
					<div>{{$data}}</div>
					<div class="form-group">
						<a class="btn btn-danger  waves-effect waves-themed btn-sm mr-2" href="{{ route('admin.users.index') }}">
							{{ trans('global.cancel') }}
						</a>
						<button class="btn btn-primary  waves-effect waves-themed btn-sm mr-2" type="submit">
							{{ trans('global.save') }}
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



@endsection