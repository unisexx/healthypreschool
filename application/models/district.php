<?php
class District extends ORM {

    var $table = 'districts';
	
	var $has_one = array("amphur",'province');
	
	var $has_many = array("register","v_nursery","nursery","v_user");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>