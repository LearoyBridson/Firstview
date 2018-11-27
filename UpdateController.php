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

class UpdateController extends Controller
{
	public function updateCompany(Request $request) {
		$destinationPath = public_path('images\\');
		
		if (isset($request->name) && $request->name != '') {
			DB::table('companies')->where('id', $request->companyID)->update(array('name' => $request->name));
		}
		if (isset($request->email) && $request->email != '') {
			DB::table('companies')->where('id', $request->companyID)->update(array('email' => $request->email));
		}
		if ($request->hasFile('logo')) {
			$prevImage = DB::table('companies')->select('logo')->where('id', $request->companyID)->first();
			if ($prevImage->logo != '') {
				if (realpath($destinationPath . $prevImage->logo)) {
					unlink($destinationPath . $prevImage->logo);
				}
			}
			
			$image = $request->file('logo');
			list($width, $height) = getimagesize($image);
			$imgName = time() . '.' . $image->getClientOriginalExtension();
			$image->move($destinationPath, $imgName);
			
			DB::table('companies')->where('id', $request->companyID)->update(array('logo' => $imgName));
		}
		if (isset($request->website) && $request->website != '') {
			DB::table('companies')->where('id', $request->companyID)->update(array('website' => $request->website));
		}
		
		$company = DB::table('companies')->where('id', $request->companyID)->first();
		
		return response()->json(array('name' => $company->name, 
									'email' => $company->email, 
									'logo' => '/images/' . $company->logo, 
									'website' => $company->website));
	}
	
	public function deleteAsset() {
		$id = DB::table('assets')
		->select('id')
		->where(function($query) {
			$query->where('description', '=', request()->description)
				  ->where('model', '=', request()->model)
				  ->where('company_id', '=', request()->companyID);
		})
		->first();
		
		DB::table('assets')
		->where(function($query) {
			$query->where('description', '=', request()->description)
				  ->where('model', '=', request()->model)
				  ->where('company_id', '=', request()->companyID);
		})
		->delete();
		
		return response()->json(array('id' => $id->id));
	}
	
	public function deleteCompany() {
		DB::table('assets')
		->where('company_id', request()->companyID)
		->delete();
		
		DB::table('companies')
		->where('id', request()->companyID)
		->delete();
		
		return response()->json(array('id' => request()->companyID));
	}
}
