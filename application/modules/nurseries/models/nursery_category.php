<?php
class Nursery_category extends ORM {

    var $table = 'nursery_categories';
	
	public $has_many = array("nursery");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>