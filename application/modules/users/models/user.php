<?php
class User extends ORM
{
	public $table = "users";
	
	public $has_one = array("level","user_type","province","amphur","area","nursery");
	
	public $has_many = array("album_category","album","category","coverpage","hilight","content","classroom","topic");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>