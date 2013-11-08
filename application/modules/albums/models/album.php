<?php
class Album extends ORM {

    var $table = 'albums';
	
	var $has_one = array("user",'album_category');
	
	var $has_many = array("picture");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
}
?>