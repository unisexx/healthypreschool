<?php
class Area extends ORM {

    var $table = 'areas';
	
	public $has_many = array("nursery","user","province");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>