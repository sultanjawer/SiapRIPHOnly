<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/v2/register', function () {
	return view('v2register');
});

Route::get('/home', function () {
	if (session('status')) {
		return redirect()->route('admin.home')->with('status', session('status'));
	}

	return redirect()->route('admin.home');
});


Auth::routes(['register' => true]); // menghidupkan registration

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

	// landing
	Route::get('/', 'HomeController@index')->name('home');
	// Dashboard
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('/dashboard/monitoring', 'DashboardController@monitoring')->name('dashboard.monitoring');
	Route::get('/dashboard/map', 'DashboardController@map')->name('dashboard.map');

	// Permissions
	Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
	Route::resource('permissions', 'PermissionsController');

	// Roles
	Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
	Route::resource('roles', 'RolesController');

	// Users
	Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
	Route::resource('users', 'UsersController');

	// Audit Logs
	Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

	Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');

	Route::get('profile', 'ProfileController@index')->name('profile.show');
	Route::post('profile', 'ProfileController@store')->name('profile.store');
	Route::post('profile/{id}', 'ProfileController@update')->name('profile.update');

	//posts
	Route::put('posts/{post}/restore', 'PostsController@restore')->name('posts.restore');
	Route::resource('posts', 'PostsController');
	Route::get('allblogs', 'PostsController@allblogs')->name('allblogs');
	Route::post('posts/{post}/star', 'StarredPostController@star')->name('posts.star');
	Route::delete('posts/{post}/unstar', 'StarredPostController@unstar')->name('posts.unstar');

	//posts categories
	Route::resource('categories', 'CategoryController');

	//messenger
	Route::get('messenger', 'MessengerController@index')->name('messenger.index');
	Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
	Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
	Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
	Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
	Route::post('messenger/{topic}/update', 'MessengerController@updateTopic')->name('messenger.updateTopic');
	Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
	Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
	Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
	Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');

	//verifikasi
	Route::get('dir_check_b', 'MessengerController@showReply')->name('verifikasi.dir_check_b');
	Route::get('dir_check_c', 'MessengerController@showReply')->name('verifikasi.dir_check_c');


	Route::resource('riphAdmin', 'RiphAdminController');

	//skl-admin
	Route::resource('skl', 'AdminSKLController');

	//daftar pejabat penandatangan SKL
	Route::get('daftarpejabats', 'PejabatController@index')->name('pejabats');
	Route::get('pejabat/create', 'PejabatController@create')->name('pejabat.create');
	Route::post('pejabat/store', 'PejabatController@store')->name('pejabat.store');
	Route::get('pejabat/{id}/show', 'PejabatController@show')->name('pejabat.show');
	Route::get('pejabat/{id}/edit', 'PejabatController@edit')->name('pejabat.edit');
	Route::put('pejabat/{id}/update', 'PejabatController@update')->name('pejabat.update');
	Route::delete('pejabat/{id}/delete', 'PejabatController@destroy')->name('pejabat.delete');
	Route::put('pejabat/{id}/activate', 'PejabatController@activate')->name('pejabat.activate');

	//daftar varietas
	Route::get('varietas', 'VarietasController@index')->name('varietas');
	Route::get('varietas/create', 'VarietasController@create')->name('varietas.create');
	Route::get('varietas/{id}/edit', 'VarietasController@edit')->name('varietas.edit');
	Route::get('varietas/{id}/show', 'VarietasController@show')->name('varietas.show');
	Route::post('varietas/store', 'VarietasController@store')->name('varietas.store');
	Route::put('varietas/{id}/update', 'VarietasController@update')->name('varietas.update');
	Route::delete('varietas/{id}/delete', 'VarietasController@destroy')->name('varietas.delete');
	Route::patch('varietas/{id}/restore', 'VarietasController@restore')->name('varietas.restore');

	//user task
	Route::group(['prefix' => 'task', 'as' => 'task.'], function () {

		Route::get('pull', 'PullRiphController@index')->name('pull');
		Route::get('getriph', 'PullRiphController@pull')->name('pull.getriph');
		Route::post('pull', 'PullRiphController@store')->name('pull.store');

		Route::get('commitment', 'CommitmentController@index')->name('commitment');
		Route::get('commitment/{pullriph}', 'CommitmentController@show')->name('commitment.show');
		Route::get('commitment/{id}/edit', 'CommitmentController@edit')->name('commitment.edit');
		Route::put('commitment/{id}/update', 'CommitmentController@update')->name('commitment.update');
		Route::delete('commitment/{pullriph}', 'CommitmentController@destroy')->name('commitment.destroy');
		Route::post('commitment/unggah', 'CommitmentController@store')->name('commitment.store');
		Route::delete('commitmentmd', 'CommitmentController@massDestroy')->name('commitment.massDestroy');

		//master penangkar
		Route::get('penangkar', 'MasterPenangkarController@index')->name('penangkar');
		Route::get('penangkar/create', 'MasterPenangkarController@create')->name('penangkar.create');
		Route::post('penangkar/store', 'MasterPenangkarController@store')->name('penangkar.store');
		Route::get('penangkar/{id}/edit', 'MasterPenangkarController@edit')->name('penangkar.edit');
		Route::put('penangkar/{id}/update', 'MasterPenangkarController@update')->name('penangkar.update');
		Route::delete('penangkar/{id}/delete', 'MasterPenangkarController@destroy')->name('penangkar.delete');

		//pengisian data realisasi
		Route::get('commitment/{id}/realisasi', 'CommitmentController@realisasi')->name('commitment.realisasi');
		Route::get('commitment/{id}/penangkar', 'PenangkarRiphController@mitra')->name('commitment.penangkar');
		Route::post('commitment/{id}/penangkar/store', 'PenangkarRiphController@store')->name('commitment.penangkar.store');
		Route::delete('mitra/{id}/delete', 'PenangkarRiphController@destroy')->name('mitra.delete');

		// daftar pks
		Route::get('pks/{id}/edit', 'PksController@edit')->name('pks.edit');
		Route::put('pks/{id}/update', 'PksController@update')->name('pks.update');
		Route::get('lokasitanam/{id}', 'PksController@anggotas')->name('pks.anggotas');

		Route::get('pks/create/{noriph}/{poktan}', 'PksController@create')->name('pks.create');
		Route::delete('pksmd', 'PksController@massDestroy')->name('pks.massDestroy');

		// Route::resource('pks', 'PksController')->except(['create']);

		//realisasi lokasi tanam
		Route::get('realisasi/lokasi/{anggota_id}', 'AnggotaRiphController@lokasi')->name('lokasi.tanam');
		Route::post('realisasi/lokasi/{id}/update', 'AnggotaRiphController@update')->name('lokasi.tanam.update');

		// pengajuan
		Route::get('commitment/{id}/submit', 'PengajuanController@create')->name('commitment.submit');
		Route::post('commitment/{id}/review/submit', 'PengajuanController@store')->name('commitment.review.submit');

		Route::resource('pengajuan', 'PengajuanController');
		Route::delete('pengajuan/destroy', 'PengajuanController@massDestroy')->name('pengajuan.massDestroy');

		//verifikasi
		// Route::resource('verifikasi', 'VerifOnlineController');
		Route::get('verifikasi/data', 'VerifOnlineController@index')->name('verifikasi.data');
		Route::get('verifikasi/data/{id}', 'VerifOnlineController@show')->name('verifikasi.data.show');

		Route::resource('skl', 'SklController');

		//berkas
		Route::get('berkas', 'BerkasController@indexberkas')->name('berkas');

		//galeri
		Route::get('galeri', 'BerkasController@indexgaleri')->name('galeri');

		//template
		Route::delete('template/destroy', 'BerkasController@massDestroy')->name('template.massDestroy');
		Route::get('template/create', 'BerkasController@createtemplate')->name('template.create');
		Route::delete('template/{id}', 'BerkasController@destroytemplate')->name('template.destroy');
		Route::post('template', 'BerkasController@storetemplate')->name('template.store');
		//Route::get('template/{berkas}', 'BerkasController@showtemplate')->name('template.show');
		Route::get('template/{berkas}/edit', 'BerkasController@edittemplate')->name('template.edit');
		Route::put('template/{berkas}', 'BerkasController@updatetemplate')->name('template.update');
		Route::get('template', 'BerkasController@indextemplate')->name('template');
	});
});

Route::group(['prefix' => 'verification', 'as' => 'verification.', 'namespace' => 'Verifikator', 'middleware' => ['auth']], function () {
	Route::resource('onfarm', 'OnfarmController');
	Route::resource('online', 'OnlineController');
	Route::resource('completed', 'CompletedController');
	//Route::resource('skl', 'SklController' );   
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {



	// Change password
	if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
		Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
		Route::post('password', 'ChangePasswordController@update')->name('password.update');
		Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
		Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
	}
});