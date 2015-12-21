<?php
class Classroom_detail extends ORM
{
	public $table = "classroom_details";
	
	public $has_one = array("classroom");
	
	public $has_many = array("disease","bmi");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>