<?php
class Bmi extends ORM
{
	public $table = "bmis";
	
	public $has_one = array("classroom_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>