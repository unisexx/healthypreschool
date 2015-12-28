<?php
class Province extends ORM {

    var $table = 'provinces';
	
	var $has_one = array("area","area_province");
	
	var $has_many = array("v_user","user","camp","register","v_nursery","nursery","amphur","district",'disease_watch');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>