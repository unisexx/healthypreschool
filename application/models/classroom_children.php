<?php
class Classroom_children extends ORM
{
	public $table = "classroom_childrens";
	
	public $has_one = array("classroom","children");
	
	public $has_many = array("bmi");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>