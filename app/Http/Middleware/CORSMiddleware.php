<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Util\Util;

class CORSMiddleware{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	private $acceptableDomains = ['bookstore.com'];
	public function handle($request, Closure $next){
		$origin=array_key_exists('HTTP_ORIGIN', $_SERVER) ? $_SERVER['HTTP_ORIGIN'] :'';
		$response = $next($request);
		if(Util::checkOrigin($this->acceptableDomains, $origin)){
			$response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
			$response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
			$response->header('Access-Control-Allow-Origin', '*');
		}
		return $response;
	}
}
