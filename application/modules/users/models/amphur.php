<?php
class Amphur extends ORM {

    var $table = 'amphures';
	
    var $has_one = array("province");
    
	var $has_many = array("register","nursery","user","district");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>