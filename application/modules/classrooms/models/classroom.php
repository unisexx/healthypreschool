<?php
class Classroom extends ORM
{
	public $table = "classrooms";
	
	public $has_one = array("nursery","user");
	
	public $has_many = array("classroom_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>