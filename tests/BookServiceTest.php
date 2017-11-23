<?php


class PassServiceTest extends TestCase{
    
    
    public function setUp() {
        parent::setUp ();
        DB::beginTransaction ();
    }
    public function tearDown() {
        DB::rollBack ();
    }
    
    
   
}