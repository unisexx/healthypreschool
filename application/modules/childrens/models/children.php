<?php
class Children extends ORM
{
	public $table = "childrens";
	
	public $has_many = array("classroom_children_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>