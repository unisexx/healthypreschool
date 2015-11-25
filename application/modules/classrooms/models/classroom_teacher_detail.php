<?php
class Classroom_teacher_detail extends ORM
{
	public $table = "classroom_teacher_details";
	
	public $has_one = array("classroom","user");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>