<?php
class Classrooms extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
    
    function index(){
    	$this->template->build('index');
    }
	
	function form(){
		$this->template->build('form');
	}
	
	function save($id=false){
		if($_POST){
			
		}
	}
}
?>