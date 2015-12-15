<?php
class Assessment extends ORM
{
	public $table = "assessments";
	
	public $has_one = array("v_nursery","nursery","user");
	
	// public $has_many = array("classroom_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>