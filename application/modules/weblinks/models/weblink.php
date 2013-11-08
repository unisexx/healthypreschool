<?php
class Weblink extends ORM {

    var $table = 'weblinks';
	
	var $has_one = array('user');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>