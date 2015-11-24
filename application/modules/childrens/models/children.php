<?php
class Children extends ORM
{
	public $table = "childrens";
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>