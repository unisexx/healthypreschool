<?php
class Disease_log extends ORM
{
	public $table = "disease_logs";
	
	// public $has_one = array("classroom_detail");
	
	// public $has_many = array("classroom_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>