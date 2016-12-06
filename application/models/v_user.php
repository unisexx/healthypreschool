<?php
class V_User extends ORM
{
	public $table = "v_users";
	
	public $has_one = array("level","user_type","province","amphur","district","area","nursery","area_province");
	
	public $has_many = array("album_category","album","category","coverpage","hilight","content","classroom","topic","questionresult","page","classroom_teacher_detail");
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>