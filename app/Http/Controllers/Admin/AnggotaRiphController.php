<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterPoktan;
use App\Models\Pks;
use App\Models\MasterAnggota;
use App\Models\Lokasi;
use App\Models\PullRiph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnggotaRiphController extends Controller
{

	public function index()
	{
		if (Auth::user()->roles[0]->title == 'User') {
			$npwp_company = Auth::user()->data_user->npwp_company;
			$lokasis = Lokasi::where('npwp', $npwp_company)->get();
		} else {
			$lokasis = Lokasi::all();
		}
	}


	public function create()
	{
		//
	}


	public function store(Request $request)
	{
		//
	}


	public function show($id)
	{
		//
	}


	public function lokasi($anggotaId)
	{
		$module_name = 'Realisasi';
		$page_title = 'Lokasi Tanam';
		$page_heading = 'Realisasi Tanam';
		$heading_class = 'fal fa-farm';

		$npwp_company = Auth::user()->data_user->npwp_company;
		$anggota = Lokasi::where('npwp', $npwp_company)
			->where('anggota_id', $anggotaId) // Use anggota_id instead of id
			->firstOrFail();
		// dd($anggota);
		$commitment = PullRiph::where('no_ijin', $anggota->no_ijin)
			->first();

		$pks = Pks::where('npwp', $npwp_company)
			->where('no_ijin', $anggota->no_ijin)
			->where('poktan_id', $anggota->poktan_id)
			->first();

		if (empty($commitment->status) || $commitment->status == 3 || $commitment->status == 5) {
			$disabled = false; // input di-enable
		} else {
			$disabled = true; // input di-disable
		}

		return view('admin.lokasitanam.lokasi', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'anggota', 'npwp_company', 'commitment', 'pks', 'disabled'));
	}

	public function update(Request $request, $anggotaId)
	{
		//
		$npwp_company = Auth::user()->data_user->npwp_company;
		$filenpwp = str_replace(['.', '-'], '', $npwp_company);
		$anggota = Lokasi::where('npwp', $npwp_company)
			->where('anggota_id', $anggotaId) // Use anggota_id instead of id
			->firstOrFail();

		$commitment = PullRiph::where('no_ijin', $anggota->no_ijin)
			->first();

		switch ($request->input('form_action')) {
			case 'form1':
				$anggota->nama_lokasi = $request->input('nama_lokasi');
				$anggota->latitude = $request->input('latitude');
				$anggota->longitude = $request->input('longitude');
				$anggota->altitude = $request->input('altitude');
				$anggota->luas_kira = $request->input('luas_kira');
				$anggota->polygon = $request->input('polygon');
				break;

			case 'form2':
				$anggota->tgl_tanam = $request->input('tgl_tanam');
				$anggota->luas_tanam = $request->input('luas_tanam');
				$anggota->varietas = $request->input('varietas');
				break;

			case 'form3':
				if ($request->hasFile('tanam_doc')) {
					$attch = $request->file('tanam_doc');
					$attchname = 'tanam_doc' . $anggota->anggota_id . '_' . $anggota->poktan_id . '.' . $attch->getClientOriginalExtension();
					$attch->storeAs('uploads/' . $filenpwp . '/' . $commitment->periodetahun, $attchname, 'public');
					$anggota->tanam_doc = $attchname;
				}

				if ($request->hasFile('tanam_pict')) {
					$attch = $request->file('tanam_pict');
					$attchname = 'tanam_pict' . $anggota->anggota_id . '_' . $anggota->poktan_id . '.' . $attch->getClientOriginalExtension();
					$attch->storeAs('uploads/' . $filenpwp . '/' . $commitment->periodetahun, $attchname, 'public');
					$anggota->tanam_pict = $attchname;
				}
				break;

			case 'form4':
				$anggota->tgl_panen = $request->input('tgl_panen');
				$anggota->volume = $request->input('volume');
				break;

			case 'form5':
				if ($request->hasFile('panen_doc')) {
					$attch = $request->file('panen_doc');
					$attchname = 'panen_doc' . $anggota->anggota_id . '_' . $anggota->poktan_id . '.' . $attch->getClientOriginalExtension();
					$attch->storeAs('uploads/' . $filenpwp . '/' . $commitment->periodetahun, $attchname, 'public');
					$anggota->panen_doc = $attchname;
				}

				if ($request->hasFile('panen_pict')) {
					$attch = $request->file('panen_pict');
					$attchname = 'panen_pict' . $anggota->anggota_id . '_' . $anggota->poktan_id . '.' . $attch->getClientOriginalExtension();
					$attch->storeAs('uploads/' . $filenpwp . '/' . $commitment->periodetahun, $attchname, 'public');
					$anggota->panen_pict = $attchname;
				}
				break;

				//this line will execute by admin/verifikator only
			case 'form6':
				$anggota->status = $request->input('status');
				break;
			default:
				//# code...
				break;
		}
		$anggota->save();

		return redirect()->route('admin.task.lokasi.tanam', $anggota->anggota_id)
			->with('success', 'Data Realisasi berhasil diperbarui');
	}


	public function destroy($id)
	{
		//
	}
}
