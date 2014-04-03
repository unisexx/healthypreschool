<?php
class Classroom_detail extends ORM
{
	public $table = "classroom_details";
	
	public $has_one = array("classroom");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>