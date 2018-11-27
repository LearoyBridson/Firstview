<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ValidateCompanyUpdateDetails
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$validator = Validator::make($request->all(), 
			array('name' => 'sometimes|unique:companies',
				'email' => 'sometimes|unique:companies',
				'logo' => 'sometimes|unique:companies|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
				'website' => 'sometimes|unique:companies'
			));
		
		if ($validator->fails()) {
			return response()->json(array('success' => false, 'errors' => $validator->getMessageBag()->toArray()), 200);
		}
		
        return $next($request);
    }
}
