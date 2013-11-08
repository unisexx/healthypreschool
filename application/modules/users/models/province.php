<?php
class Province extends ORM {

    var $table = 'provinces';
	
	var $has_one = array("area");
	
	var $has_many = array("user","camp","register","nursery","amphur","district");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>