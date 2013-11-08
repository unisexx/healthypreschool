<?php
class Album_Category extends ORM {

    var $table = 'album_categories';
	
	var $has_one = array("user");
	
	var $has_many = array("album");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
}
?>