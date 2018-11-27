<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Company;
use App\Asset;
use DB;

class SelectController extends Controller
{
    public function selectUserCompanies() {
		if (Auth::check()) {
			$companies = DB::table('companies')
			->where('user_id', Auth::user()->id)
			->paginate(10);
			
			return view('/companyList', compact('companies'));
		} else {
			return view('/companyList');
		}
	}
	
	public function selectUserCompanyDetails($companyID) {
		$company = DB::table('companies')
        ->select('*')
        ->where('id', $companyID)
        ->first();
		
		$assets = DB::table('assets')
		->select('*')
		->where('company_id', $companyID)
		->paginate(10);
		
		return view('company', compact('company', 'assets'));
	}
	
	
	/*
		This is basically a pagination implementation.
	*/
	public function getRowSet($table, $direction, $ID, $lastRowID, $set) {
		$idColumn = ($table == 'assets') ? 'company_id' : 'user_id';
		$sign = ($direction == 'r') ? '>' : '<';
		$rowSet = $assets = DB::table($table)
			->select('*')
			->where($idColumn, $ID)
			->where('id', $sign, $lastRowID)
			->paginate($set);
		return $rowSet;
	}
	
	public function getData($table, $direction, $ID, $lastRowID) {
		$dataArray = array();
		
		if ($table == 'assets') {
			$data = $this->getRowSet('assets', $direction, $ID, $lastRowID, 11);
			foreach($data as $d) {
				$dataArray[] = array('id' => $d->id, 
										'description' => $d->description, 
										'model' => $d->model, 
										'value' => $d->value);
			}
		} else if ($table == 'companies') {
			$data = $this->getRowSet('companies', $direction, $ID, $lastRowID, 11);
			foreach($data as $d) {
				$dataArray[] = array('url' => url('/company/') . $d->id,
										'id' => $d->id, 
										'name' => $d->name, 
										'email' => $d->email, 
										'logo' => $d->logo,
										'website' => $d->website);
			}
		}
		
		
		return response()->json($dataArray);
	}
}
