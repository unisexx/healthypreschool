<?php
class _dbquery extends Public_Controller{
	
	function __construct(){
		parent::__construct();
		ini_set('memory_limit', '-1');
	}
	
	function index(){
		$nurseries = new Nursery();
		$nurseries->order_by('id','asc')->get();
		
		foreach($nurseries as $n){
			
			$assessment = new Assessment();
			$assessment->where("nursery_id =".$n->id)->get();
			if(!$assessment->exists())
			{
				$_POST['nursery_id'] = $n->id;
				$_POST['approve_year'] = $n->approve_year;
				$_POST['approve_date'] = $n->approve_date;
				$_POST['approve_user_id'] = $n->approve_user_id;
				$_POST['approve_type'] = $n->approve_type;
				
			    $a = new Assessment();
				$a->from_array($_POST);
				$a->save();
			}
			
		}
	}
	
}
?>
