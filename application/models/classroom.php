<?php
class Classroom extends ORM
{
	public $table = "classrooms";
	
	public $has_one = array("nursery");
	
	public $has_many = array("classroom_detail","disease","classroom_children","classroom_teacher");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>