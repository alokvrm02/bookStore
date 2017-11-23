<?php

namespace App\Exceptions;

class BookException extends \Exception {
    protected $message = 'Book exception';
    protected $errorCode;
    protected $data;
    public function __construct($message = null, $errorCode = null, $data = null) {
        parent::__construct ( $message );
        $this->message = $message;
        $this->errorCode = $errorCode;
        $this->data = $data;
    }
    public function getErrorCode() {
        return $this->errorCode;
    }
    public function getData() {
        return $this->data;
    }
    public function getDataAsString() {
        return json_encode ( $this->data );
    }
}
