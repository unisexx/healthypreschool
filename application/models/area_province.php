<?php
class Area_Province extends ORM {

    var $table = 'area_provinces';
	
	public $has_many = array("v_user","user","area","province");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>