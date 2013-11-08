<?php
class Newsletters_email_list extends ORM {

    var $table = 'newsletters_email_lists';
	
	var $has_one = array('user');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>