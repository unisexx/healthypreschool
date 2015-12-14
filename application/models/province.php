<?php
class Province extends ORM {

    var $table = 'provinces';
	
	var $has_one = array("area","area_province");
	
	var $has_many = array("v_user","user","camp","register","nursery","amphur","district");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>