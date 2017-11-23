<?php

namespace App\Http\Controllers;

use App\Services\VisitorService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Util\Constant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Visit;
use phpDocumentor\Reflection\Types\Null_;

class VisitorController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		// print_r("****");
	}
	public function getVisitorByMobile($societyId, $mobile) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($mobile) {
			try {
				$response = (new VisitorService ())->getVisitorByMobile ( $societyId, $mobile );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getVisitorByMobile( $mobile )" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "Fill the mobile number";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getVisitsByDateInterval($societyId) {
		$params = $_GET;
		$toDate = date ( 'Y-m-d' );
		if ($params && isset ( $params ['fromDate'] )) {
			$fromDate = $params ['fromDate'];
		} else {
			return $this->setDataResponse ( null, "No Date Input" );
		}
		if (isset ( $params ['toDate'] )) {
			$toDate = $params ['toDate'];
			if ($toDate == null) {
				$toDate = date ( 'Y-m-d' );
			}
		}
		if (isset ( $params ['visitorId'] )) {
			$visitorId = $params ['visitorId'];
			if (! $visitorId) {
				$visitorId = null;
			}
		}
		
		$response = null;
		$errorMessage = null;
		Log::debug ( "[" . self::class . "] Entered getVisitsByDateInterval controller" );
		try {
			$response = (new VisitorService ())->getVisitsByDateInterval ( $societyId, $fromDate, $toDate, $visitorId );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
			Log::error ( "[" . self::class . "] Error at line no " . $e->getLine () . "" );
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	
	
	public function getAllVisitors($societyId) {
		$response = null;
		$errorMessage = null;
		try {
			$response = (new VisitorService ())->getAllVisitors ( $societyId );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getVisitorDetailsArray($societyId) {
		$params = Input::all ();
		$response = null;
		$errorMessage = null;
		if ($params ['mobile']) {
			try {
				$response = (new VisitorService ())->getVisitorDetailsArray ( $societyId, $params ['mobile'] );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getVisitorDetailsArray" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "Fill the mobile number";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function LastTenVistorsAdded($societyId) {
		$response = null;
		$errorMessage = null;
		
		try {
			$response = (new VisitorService ())->LastTenVistorsAdded ( $societyId );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
			Log::error ( "[" . self::class . "] Error : " . $e->getMessage () . " at Line " . $e->getLine () . "" );
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getVisitsForResident($societyId) {
		$params = Input::all ();
		$errorMessage = null;
		$response = null;
		$residentId = $params ['residentId'];
		$input = $params ['input'];
		try {
			$response = (new VisitorService ())->getVisitsForResident ( $societyId, $residentId, $input );
		} catch ( \Exception $e ) {
			Log::error ( "[" . self::class . "] Error in getVisitsForResident controller at line " . $e->getLine () . "" );
			$errorMessage = $e->getMessage ();
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getVisitorById($societyId, $visitorId) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($visitorId) {
			try {
				$response = (new VisitorService ())->getVisitorById ( $societyId, $visitorId );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getVisitorById( $visitorId )" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "There is no visitor id";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getVisitByVisitor($societyId, $visitorId) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($visitorId) {
			try {
				$response = (new VisitorService ())->getVisitByVisitor ( $societyId, $visitorId );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getVisitByVisitor( $visitorId )" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "There is no visitor id";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function blockVisitor($societyId) {
		$params = Input::all ();
		$visitorId = $params ['visitorId'];
		$remarks = $params ['remarks'];
		$block = $params ['block'];
		$response = null;
		$errorMessage = null;
		try {
			$response = (new VisitorService ())->blockVisitor ( $societyId, $visitorId, $block, $remarks );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function allowVisitByResident($societyId) {
		$params = Input::all ();
		$allow = $params ['allow'];
		$visitId = $params ['visitId'];
		$residentId = $params['user-id'];
		$response = null;
		$errorMessage = null;
		try {
			$response = (new VisitorService ())->allowVisitByResident ( $societyId, $visitId, $allow,$residentId);
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getVisitsForResidentForAllow($societyId) {
		$params = Input::all ();
		$residentId = $params ['user-id'];
		$response = null;
		$errorMessage = null;
		try {
			$response = (new VisitorService ())->getVisitsForResidentForAllow ( $societyId, $residentId );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
			Log::error ( " Error at getVisitsForResidentForAllow at line no " . $e->getLine () . "" );
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getCardExistForTower($societyId, $cardNo, $tower) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($cardNo) {
			try {
				$response = (new VisitorService ())->getCardExistForTower ( $societyId, $cardNo, $tower );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getCardExistForTower( $cardNo )" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "There is some problem with card number";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getAllVisitExistForSociety($societyId) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($societyId) {
			try {
				$response = (new VisitorService ())->getAllVisitExistForSociety ( $societyId );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getAllVisitExistForSociety( $societyId ) " . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "No Society Id";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function searchAllVisitorForTimeExceeded($societyId) {
		$errorMessage = null;
		$response = null;
		Log::debug ( self::class . 'Enetering TimeExceeded-visits' );
		try {
			$response = (new VisitorService ())->getAllVisitorForTimeExceeded( $societyId );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function endVisit($societyId, $visitorId) {
		$errorMessage = null;
		$response = null;
		Log::debug ( self::class . 'Enetering end-visit' );
		try {
			$response = (new VisitorService ())->endVisit ( $societyId, $visitorId );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getAllWrongVisitExistForSociety($societyId) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		Log::debug ( self::class . 'Enetering wrongVisit controller' );
		if ($societyId) {
			try {
				$response = (new VisitorService ())->getAllWrongVisitExistForSociety ( $societyId );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getAllVisitExistForSociety( $societyId ) " . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "No Society Id";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function editVisitorDetails($societyId, $visitorId) {
		$params = Input::all ();
		$response = null;
		$errorMessage = null;
		Log::debug ( " Entered in edit Visitor Details controller" );
		try {
			$response = (new VisitorService ())->editVisitorDetails ( $societyId, $visitorId, $params );
		} catch ( \Exception $e ) {
			$errorMessage = $e->getMessage ();
			Log::error ( " Error in edit visitor details controller at line " . $e->getLine () . "" );
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function addVisitor($societyId, $mobile) {
		Log::debug ( self::class . 'Enetering addVisitor' );
		
		// $params = Input::all ();
		if(isset($params['resident_id'])){
			$residentId = $params['resident_id'];
		}else{
			$residentId = "";
		}
		
		$params = Input::all ();
		// print_r($params);
		$response = null;
		$errorMessage = "Visitor not Added";
			if (! preg_match ( "/^[7-9]{1}[0-9]{9}$/i", $mobile )) {
				$errorMessage = "Incorrect Mobile number";
			} else {
				
				Log::debug ( self::class . '  params' . print_r ( $params, true ) );
				$visitorService = new VisitorService ();
				try {
					$response = $visitorService->addVisitor ( $params ['mobile'], $params ['name'], $params ['image'], $params ['status'], $societyId, $params ['type'], $params ['email'], $params ['address'], $residentId, $params ['code'], $params ['pass_id'] );
				} catch ( \Exception $e ) {
					$errorMessage = $e->getMessage();
					Log::error ( self::class . "Error in addVisitor( $mobile )" . " Line Number " . $e->getLine () . " Error Message " . $e->getMessage() );
				}
			}
		
		// echo "<script>alert(".$response.")</script>";
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function addVisit($societyId, $visitor) {
		Log::debug ( self::class . 'Enetering addVisit' );
		// $visitorId = (new VisitorService())->getVisitorByMobile($societyId, $mobile);
		$params = Input::all ();
		Log::debug ( self::class . ' params' . print_r ( $params, true ) );
		$visitorService = new VisitorService ();
		$response = null;
		$errorMessage = "Visit not added";
		$location = '';
		if(isset($params ['location_id'])){
			$location = $params ['location_id'];
		}
		
		$residentId = isset($params ['resident_id']) ? $params ['resident_id'] : "";
		$params ['purpose'] = isset($params ['purpose']) ? $params ['purpose'] : null;
		
		if ($params ['whom_to_meet']) {
			try {
				$response = $visitorService->addVisit ( $visitor, '', '', $societyId, $params ['extra_visitors'], $params ['material'], $params ['purpose'], $params ['vehicle'], $params ['whom_to_meet'], $location, '', $params ['card_no'], $params ['allowed_time'], $params ['pass_id'], $residentId, $params ['created_by'], $params ['updated_by'], $params ['pass_id'] );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage();
				Log::error ( self::class . "Error in addVisit( $visitor )" . " Line Number " . $e->getLine () . " Error Message " . $e->getMessage() );
			}
		} else {
			$errorMessage = "Please enter the name for a person whom you want to meet";
		}
		
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function getAllVisitByMobile($societyId, $mobile) {
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($mobile) {
			try {
				$response = (new VisitorService ())->getAllVisitByMobile ( $societyId, $mobile );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getVisitorByMobile( $mobile )" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "Fill the mobile number";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	public function searchVisitorByMobile($societyId) {
		$params = Input::all ();
		
		$mobile = $params ['mobile'];
		$response = null;
		$errorMessage = null;
		if ($mobile) {
			try {
				$response = (new VisitorService ())->searchVisitorByMobile ( $societyId, $mobile );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getVisitorByMobile" . " Line Number " . $e->getLine () );
			}
		} else {
			$errorMessage = "Fill the mobile number";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	
	
	public function addVisitorVisit($societyId) {
		Log::debug ( self::class . 'Enetering addVisitorVisit' );
		
		// $params = Input::all ();
		
		$params = Input::only ( 'name', 'mobile', 'address', 'image', 'type', 'whom_to_meet', 'purpose', 'location_id', 'extra_visitors', 'allowed_time', 'resident_id','email','created_by', 'updated_by','pass_id' );
		// print_r($params);
		$response = null;
		$errorMessage = "Visitor not Added";
		$mobile = $params ['mobile'];
		
			if (! preg_match ( "/^[7-9]{1}[0-9]{9}$/i", $mobile )) {
				$errorMessage = "Incorrect Mobile number";
			} else {
				
				$visitorService = new VisitorService ();
				try {
					//$mobile, $name, $image, $status, $societyId, $type, $email, $address, $residentId, $code,$pass
					$visitor = $visitorService->addVisitor ( $params ['mobile'], $params ['name'], $params ['image'], 1, $societyId, 
							$params ['type'],$params['email'], $params ['address'], $params ['resident_id'],'',$params['pass_id']);
					//$visitorId, $startTime, $endTime, $societyId, $extraVisitors, $material, $purpose, $vehicle, $whomToMeet,
					//$towerId, $unitNo, $cardNo, $allowedTime, $passId, $residentId, $created_by, $updated_by, $pass
					$response = $visitorService->addVisit ( $visitor->id, '', '', $societyId, $params ['extra_visitors'], '', 
							$params ['purpose'], '', $params ['whom_to_meet'], $params ['location_id'],'','', $params ['allowed_time'], '', 
							$params ['resident_id'], $params ['created_by'], $params ['updated_by'],$params['pass_id'] );
				} catch ( \Exception $e ) {
					$errorMessage = $e->getMessage ();
					Log::error ( self::class . "Error in addVisitorVisit( $mobile )" . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
				}
			}
		
		// echo "<script>alert(".$response.")</script>";
		return $this->setDataResponse ( $response, $errorMessage );
	}
	
	public function getAllActiveVisit($societyId){
		$params = $_GET;
		$response = null;
		$errorMessage = null;
		if ($societyId) {
			try {
				$response = (new VisitorService ())->getAllSocietyActiveVisit( $societyId );
			} catch ( \Exception $e ) {
				$errorMessage = $e->getMessage ();
				Log::error ( self::class . "Error in getAllActiveVisit( $societyId ) " . " Line Number " . $e->getLine () . " Error Message " . $errorMessage );
			}
		} else {
			$errorMessage = "No Society Selected";
		}
		return $this->setDataResponse ( $response, $errorMessage );
	}
	
	
	private function setDataResponse($result, $errMsg, $metadata = null, $status = null) {
		if ($result) {
			Log::debug ( self::class . ' Result size ==  ' . sizeof ( $result ) );
			if ($status == null) {
				$status = Constant::SUCCESS;
			}
			$arr = array (
					
					Constant::STATUS => $status,
					Constant::DATA => $result 
			);
			if ($metadata)
				$arr [Constant::METADATA] = $metadata;
			return $arr;
		} else
			return array (
					Constant::STATUS => Constant::ERROR,
					Constant::MESSAGE => $errMsg 
			);
	}
	
	//
}

