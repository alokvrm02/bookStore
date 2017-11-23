<?php
namespace App\Util;

class Constant{
	//response params
	const PASS_UNUSED = '0';
	const PASS_USED = '1';
	const PASS_CANCELED = '2';
	
	const STATUS='status';
	const MESSAGE='message';
	const DATA='data';
	const METADATA='metadata';
	//response status
	const SUCCESS='success';
	const WARNING='warning';
	const ERROR='error';
	const TOTALCOUNT = 'totalCount';
	const UN_AUTH_ACCESS = 'You are not authorized to access this service';
	
	const SYNCH_STAGE_INITIATED = 0;
	const SYNCH_STAGE_DUMP_READING = 1;
	const SYNCH_STAGE_DUMP_METER_CHANGE = 2;
	const SYNCH_STAGE_SYNCH_READING = 3;
	const SYNCH_STAGE_SYNCH_METER_CHANGE = 4;
	const SYNCH_STAGE_PROCESSED = 5;
	const SYNCH_STAGE_ERROR = -1;
	
	const METER_CHANGE = "METER_CHANGE";
	
	const FROM_DATE = "2016-01-01";
	
	const BATCH_INSERT_SIZE = 100;
	//READING
	const ERROR_PREV_READING_MORE = "ERMTRRD01";
	const ERROR_READING_ALREADY_EXIST = "ERMTRRD02";
	const ERROR_READING_LESS_METER_START = "ERMTRRD03";
	//METER CHANGE
	const ERROR_METER_DUPLICATE_METER_NO = "ERMTRCH01";
	const ERROR_METER_ALREADY_CHANGED = "ERMTRCH02";
	const ERROR_METER_GRID_END_LESS = "ERMTRCH03";
	const ERROR_METER_DG_END_LESS = "ERMTRCH04";
	//ADD METER
	const ERROR_METER_ALREADY_EXIST = "ERMTRAD01";
	
	//METER ACTIONS
	const ACTION_START = 'POWERRESTORE';
	const ACTION_STOP = 'POWERCUT';
	
	//METER ACTION STATUS
	const ACTION_STATUS_INITIATED = 'initiated';
	const ACTION_STATUS_WAITING = 'waiting';
	const ACTION_STATUS_COMPLETED = 'completed';
	const ACTION_STATUS_FAILED = 'failed';
	const ACTION_STATUS_UNKNOWN = 'unknown';
	
	//METER ACTION CONFIGURATION
	const ACTION_SLEEP_WAITING_TIME = 2;
	const ACTION_MAX_ATTEMPTS = 5;
	
	const ACTION_AUTO_REMARKS_RESTART = 'restart'; 
	const MINIMUM_TIME_FOR_ENTRY = 15;
	
	///////////////////////////////////////
	public static function getIsmUrl(){
		return env('ISM_API_URL', 'http://test-api.isocietymanager.com/');
	}
}