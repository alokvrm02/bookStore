<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Util\Constant;
use App\Services\BooksService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\BookException;

class BooksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function getAllBooks() {
        $response = null;
        $errorMessage = null;
            try {
                $response = (new BooksService())->getAllBooks();
            } catch ( \Exception $e ) {
                $errorMessage = $e->getMessage ();
                Log::error ( self::class . "Error at Line Number " . $e->getLine () . " Error Message " . $errorMessage );
            }
        return $this->setDataResponse ( $response, $errorMessage );
    }
    
    public function addBook() {
        $params = Input::all();
        $response = null;
        $errorMessage = null;
        try {
            if (Input::hasFile ( 'file' )) {
                $tmpFileType = Input::file('file')->getClientMimeType();
                $response = (new BooksService())->addBook($params,$tmpFileType);
            }else{
                $errorMessage = "File not Found";
            }
        }catch (BookException $err){
            $errorMessage = $err->getMessage();
        }catch ( \Exception $e ) {
            $errorMessage = "Server not available";
            Log::error ( self::class . "Error at Line Number " . $e->getLine () . " Error Message " . $errorMessage );
        }
        return $this->setDataResponse ( $response, $errorMessage );
    }
    
    public function deleteBook($id){
        $response = null;
        $errorMessage = null;
        try {
            $response = (new BooksService())->deleteBook($id);
        } catch ( \Exception $e ) {
            $errorMessage = $e->getMessage ();
            Log::error ( self::class . "Error at Line Number " . $e->getLine () . " Error Message " . $errorMessage );
        }
        return $this->setDataResponse ( $response, $errorMessage );
    }
    
    public function getFilterdlist(){
        $params = Input::all();
        $response = null;
        $errorMessage = null;
        try {
            $response = (new BooksService())->getFilterdList($params);
        }catch (BookException $e){
            $errorMessage = $e->getMessage();
        }catch (\Exception $e){
            Log::error(self::class."Error Message = ".$e->getMessage()." at line no = ".$e->getLine());
            $errorMessage = "Server error";
        }
        return $this->setDataResponse($response, $errorMessage);
    }
    
    public function renameTag($oldTag,$newTag){
        $response = null;
        $errorMessage = null;
        try {
            $response = (new BooksService())->renameTag($oldTag, $newTag);
        }catch (BookException $e){
            $errorMessage = $e->getMessage();
        }catch (\Exception $e){
            Log::error(self::class."Error Message = ".$e->getMessage()." at line no = ".$e->getLine());
            $errorMessage = "Server error";
        }
        return $this->setDataResponse($response, $errorMessage);
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
