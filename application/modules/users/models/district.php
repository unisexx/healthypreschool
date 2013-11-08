<?php
class District extends ORM {

    var $table = 'districts';
	
	var $has_one = array("amphur",'province');
	
	var $has_many = array("register","nursery");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>