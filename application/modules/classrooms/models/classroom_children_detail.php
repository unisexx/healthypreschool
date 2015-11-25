<?php
class Classroom_children_detail extends ORM
{
	public $table = "classroom_children_details";
	
	public $has_one = array("classroom","children");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>