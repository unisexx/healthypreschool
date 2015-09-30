<?php
class Questionresult extends ORM {

    public $table = 'questionresults';
	
	public $has_one = array("user");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>