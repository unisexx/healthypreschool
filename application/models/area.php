<?php
class Area extends ORM {

    var $table = 'areas';
	
	public $has_many = array("v_user","nursery","user","province");
	
	public $has_one = array("area_province");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>