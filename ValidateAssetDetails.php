<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ValidateAssetDetails
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
			array('description' => 'bail|required',
				'model' => 'bail|required|between:0,999999.99|unique:assets',
				'value' => 'bail|required'
			));
		
		if ($validator->fails()) {
			return response()->json(array('success' => false, 'errors' => $validator->getMessageBag()->toArray()), 200);
		}
		
		return $next($request);
    }
}
