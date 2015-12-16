<?php
class Classroom_teacher extends ORM
{
	public $table = "classroom_teachers";
	
	public $has_one = array("classroom","user");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>