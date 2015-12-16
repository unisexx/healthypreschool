<?php
class Bmi extends ORM
{
	public $table = "bmis";
	
	public $has_one = array("classroom_detail","classroom_children");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>