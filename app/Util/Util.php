<?php

namespace App\Util;

use Illuminate\Support\Facades\Log;
use App\Models\StaffAttendance;
use Illuminate\Support\Facades\DB;

class Util {
	
	/**
	 *
	 * @param unknown $dataArr
	 * @param unknown $size
	 *        	return Array : Arrays of Array where each array contains only records <= size
	 */
	public static function getArraysOfSize($dataArr, $size) {
		$dataArrays = [ ];
		$dataSize = sizeof ( $dataArr );
		$parts = intval ( $dataSize / $size );
		$noOfChunks = ($dataSize % $size) == 0 ? $parts : $parts + 1;
		for($i = 0; $i < $noOfChunks; $i ++) {
			$dataArrays [$i] = array_slice ( $dataArr, $i * $size, $size, true );
		}
		return $dataArrays;
	}
	
	
	public static function isValidateRequest($reqdParams) {
		foreach ( $reqdParams as $parm ) {
			if (! $parm ) {
				return true;
			}
		}
		Log::debug ( "[ " . self::class . " ] Valid Request ".print_r($reqdParams, true));
		return false;
	}
	public static function getStringForArray($array){
		$string = "("; $temp = sizeof($array);
		foreach ($array as $element){
			$temp--;
			$string .="'".$element."'";
			if($temp != 0){
				$string .=',';
			}else{
				$string .=")";
			}
		}
		return $string;
	}
	
	
	
	public static function postWebService($url, $data, $returnTransfer = true, $sslVerifyPeer = false, $timeout = 10) {
		Log::debug ( "[ " . self::class . " ] entering requestWebService( $url ) " );
		$response = null;
		try {
			$ch = curl_init ();
			// $url = "https://myxenius.com/thirdparty/api/meter_reading?login_id=jpapi@8002&password=8002&location_id=8002180403";
			curl_setopt_array ( $ch, array (
					CURLOPT_RETURNTRANSFER => $returnTransfer,
					CURLOPT_URL => $url,
					CURLOPT_POST => true,
					CURLOPT_SSL_VERIFYPEER => $sslVerifyPeer,
					CURLOPT_TIMEOUT => $timeout,
					CURLOPT_POSTFIELDS => urldecode(http_build_query($data))
			) );
			$response = curl_exec ( $ch );
			curl_close ( $ch );
			Log::debug ( "[ " . self::class . " ] Result for | ==> $url <== |\n" . $response );
		} catch ( \Exception $e ) {
			Log::error ( "[ " . self::class . " ] Error while Calling | ==> $url <== |" . " Line Number " . $e->getLine () . " Error Message " . $e->getMessage ());
			throw $e;
		}
		return $response;
	}
	
	public static function getWebService($url, $returnTransfer= true, $sslVerifyPeer = false, $timeout = 30) {
		$response = null;
		Log::debug ( "[ " . self::class . " ] entering requestCall( $url ) " );
		Log::info ( "[ " . self::class . " ] Calling | ==>  " . $url . "  <== |" );
		try {
			$ch = curl_init ();
			curl_setopt_array ( $ch, array (
					CURLOPT_RETURNTRANSFER => $returnTransfer,
					CURLOPT_URL => $url,
					CURLOPT_SSL_VERIFYPEER => $sslVerifyPeer,
					CURLOPT_TIMEOUT => $timeout
			) );
			$response = curl_exec ( $ch );
			curl_close ( $ch );
			Log::debug ( "[ " . self::class . " ] Result for | ==> $url <== |\n" . $response );
		} catch ( \Exception $e ) {
			Log::error ( "[ " . self::class . " ] Error while Calling | ==> $url <== |" . " Line Number " . $e->getLine () . " Error Message " . $e->getMessage ());
		}
		return $response;
	}
	
	
	public static function stringArrayReplace($string, $replaceStringsArray){
		foreach ($replaceStringsArray as $from=>$to){
			$string = str_replace($from, $to, $string);
		}
		return $string;
	}
	
	
	public static function setNormalResponse($result, $sucMsg, $errMsg, $data = null, $metadata=null) {
		if ($result)
			$res = array (
					Constant::STATUS => Constant::SUCCESS,
					Constant::MESSAGE => $sucMsg
			);
		else
			$res = array (
					Constant::STATUS => Constant::ERROR,
					Constant::MESSAGE => $errMsg
			);
		if ($data)
			$res [Constant::DATA] = $data;
		if($metadata)
			$res [Constant::METADATA] = $metadata;
		return $res;
	}
	
	public static function getCollectionObjectsArrayKeyMapped($collection, $key) {
		$result = [ ];
		foreach ( $collection as $object ) {
			if (! isset ( $result [$object->{$key}] )) {
				$result [$object->{$key}] = [ ];
			}
			$result [$object->{$key}] [] = $object;
		}
		return $result;
	}
	public static function getCollectionKeysArray($collection, $key) {
		$result = [ ];
		foreach ( $collection as $object ) {
			if(isset($object->{$key}))
				$result [] = $object->{$key};
		}
		return $result;
	}
	
	public static function insertDataArray($modelName, $dataArr) {
		Log::debug ( "[ " . self::class . " ] Entering insertDataArray($modelName) " );
		//print_r($dataArr);
		if (sizeof ( $dataArr ) <= Constant::BATCH_INSERT_SIZE) {
			$response = DB::table('staff_attendance')->insert($dataArr);
		} else {
			$dataArrays = self::getArraysOfSize ( $dataArr, Constant::BATCH_INSERT_SIZE );
			foreach ( $dataArrays as $dataArray ) {
				$response = DB::table('staff_attendance')->insert($dataArr);
			}
		}
		Log::debug ( "[ " . self::class . " ] Leaving insertDataArray response is " . $response );
		
		return $response;
	}
	
	
	public static function checkOrigin($domainArr, $origin) {
		$urlParse = parse_url( $origin );
		$found = false;
		if (isset($urlParse['host'])){
			$host =  $urlParse['host'];
			foreach ( $domainArr as $domain ) {
				if (strpos ( $host, $domain ) !== false) {
					$found = true;
					break;
				}
			}
		}
		return $found;
	}
	
	public static function getDuration($datetime1, $datetime2) {
		
		$interval = null;
		if(($datetime2 != null || $datetime2 != '0000-00-00 00:00:00') && $datetime2 > $datetime1){
			$interval = $datetime1->diff($datetime2);
			$days = $interval->format('%d');
			$hours = $interval->format('%H');
			$minutes = $interval->format('%i');
			if($days!=0){
				return $interval->format('%d Days');
			}else if($hours!=0){
				return $interval->format('%H Hours');
			}else if($minutes!=0){
				return $interval->format('%i Minutes');
			}else if($hours==0 && $hours==0 && $minutes==0){
				return "";
			}
			$interval = $interval->format('%d Days %H Hours %i Minutes');
		}
		return $interval;
	}
}