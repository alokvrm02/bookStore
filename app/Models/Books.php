<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model {
	protected $table = "books";
	public $timestamps = true;
	protected $fillable = [
			'name',
			'auther',
			'price',
			'tags',
			'filename'
	];
	
	public function getAllBooks(){
		return $this->get();
	}
	public function renameTag($oldTag,$newTag){
	    return $this->where('tags',$oldTag)->update(['tags'=>$newTag]);
	}
	public function getBooksByDate($date){
	    return $this->where('created_at','>',$date)->get();
	}
	public function getBooksByPrice($price){
	    return $this->where('price','<=',$price)->get();
	}
	public function getBooksByLimit($limit){
	    return $this->take($limit)->get();
	}
	public function getRes($col,$data){
	    return $this->where($col,'LIKE',$data.'%')->get();
	}
	public function deleteBook($id){
	    return $this->where('id',$id)->delete();
	}
}