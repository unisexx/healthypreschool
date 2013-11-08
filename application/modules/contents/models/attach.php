<?php
class Attach extends ORM {

    var $table = 'attachs';

	var $has_one = array('content');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>