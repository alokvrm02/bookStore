<?php
namespace App\Services;

use App\Models\Books;
use App\Exceptions\BookException;

class BooksService
{

    public function getAllBooks()
    {
        $books = (new Books())->getAllBooks();
        return $books;
    }

    // public function filterTag($newTag){
    // if($newTag == '' || strlen($newTag)<1){
    // $tag = '{}';
    // }else{
    // $tag = '{'.$newTag.'}';
    // }
    // return $tag;   
    // }
    
    public function addBook($params, $tmpFileType)
    {
        if ($tmpFileType != 'application/pdf') {
            throw new BookException("Only pdf files accepted");
        }
        if ($params['name'] == '' || $params['auther'] == '') {
            throw new BookException("Book Name and auther name is mandatory");
        }
        // -------check if book exists
        $fileName = $params['name'] . '_' . $params['auther'] . '.pdf';
        $params['filename'] = $fileName;
        $file = $params['file']->move('upload/', $fileName);
        $result = (new Books())->fill($params);
        $result->save();
        return $result;
    }
    
    public function renameTag($oldTag,$newTag){
        if($newTag == '' || strlen($newTag)<1){
            throw new BookException("Please provide new tag name");
        }
        if($oldTag == '' || strlen($oldTag)<1){
            throw new BookException("Please provide old tag name");            
        }
        $result = (new Books())->renameTag($oldTag, $newTag);
        return  $result;
    }
    
    public function getFilterdList($params){
        $data = null;
        print_r(sizeof($params));
        if(sizeof($params)==1){
            foreach($params as $key => $item){
                if($key=='price'){
                    $data = (new Books())->getBooksByPrice($item);
                }else if($key == 'limit'){
                    $data = (new Books())->getBooksByLimit($item);
                }else if($key == 'date'){
                    $data = (new Books())->getBooksByDate($item);
                }else{
                    $data = (new Books())->getRes($key, $item);
                }
            }
        }else{
            throw new BookException('Use one filter at a time');
        }
        return $data;
    }

    public function deleteBook($id)
    {
        $result = (new Books())->deleteBook($id);
        return $result;
    }
}