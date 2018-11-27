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

class InsertController extends Controller
{
    public function insertCompany(Request $request) {
		$imgName = "";
		
		if ($request->hasFile('logo')) {
			$image = $request->file('logo');
			list($width, $height) = getimagesize($image);
			$imgName = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('images\\');
			$image->move($destinationPath, $imgName);
		}
		
		$company = new Company();
		$company->name = $request->name;
		$company->email = (isset($request->email)) ? $request->email : "";
		$company->logo = $imgName;
		$company->website = (isset($request->website)) ? $request->website : "";
		$company->user_id = Auth::user()->id;
		$company->save();
		
		$id = DB::table('companies')->select('id')->where('name', $request->name)->first();
		
		return response()->json(array('success' => 'Your company details have been saved.<br/>' . 
													'You can edit your company details or add asset ' .
													'details', 'companyID' => $id->id), 200);
	}
	
	public function insertAsset(Request $request) {
		$asset = new Asset();
		$asset->description = $request->description;
		$asset->model = $request->model;
		$asset->value = $request->value;
		$asset->company_id = $request->companyID;
		$asset->save();
		
		$asset = DB::table('assets')->where(function($query) {
			$query->where('description', request()->description)
				->where('model', '=', request()->model)
				->where('company_id', '=', request()->companyID);
		})
		->first();
		
		return response()->json(array('description' => $asset->description, 
									'model' => $asset->model, 
									'value' => $asset->value));
	}
}
