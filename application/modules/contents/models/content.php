<?php
class Content extends ORM {

    var $table = 'contents';
	
	var $has_one = array('user','category');
	
	var $has_many = array('attach');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>