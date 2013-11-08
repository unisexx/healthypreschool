<?php
class Nursery extends ORM {

    var $table = 'nurseries';
	
	public $has_one = array("amphur","district","province","nursery_category","area");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>