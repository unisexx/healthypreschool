<?php
class Disease extends ORM
{
	public $table = "diseases";
	
	public $has_one = array("classroom_detail","classroom");
	
	// public $has_many = array("classroom_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>