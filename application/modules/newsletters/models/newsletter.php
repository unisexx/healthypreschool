<?php
class Newsletter extends ORM {

    var $table = 'newsletters';
	
	var $has_one = array('user');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>