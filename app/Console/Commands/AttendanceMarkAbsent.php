<?php

namespace App\Console\Commands;

use App\Services\AttendanceService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class AttendanceMarkAbsent extends Command {
	protected $name = 'attendance:absent';
	protected $description = 'Marks absent';
	public function __construct() {
		parent::__construct ();
	}
	public function fire() {
		$date = date ( 'Y-m-d' );
		$this->info ( "Marking Absent for " . $date );
		if ($societyId = $this->argument ( 'societyId' )) {
			$this->info ( "Selected society id : " . $societyId );
			return (new AttendanceService ())->markAbsentCommand ( $date, $societyId );
		}
		return (new AttendanceService ())->markAbsentCommand ( $date );
	}
	protected function getArguments() {
		return [ 
				[ 
						'societyId',
						InputArgument::OPTIONAL,
						'society id for marking staff absent' 
				] 
		];
	}
	protected function getOptions() {
		return [ ];
		// ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		
	}
}
