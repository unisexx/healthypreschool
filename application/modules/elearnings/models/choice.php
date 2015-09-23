<?php
class Choice extends ORM {

    public $table = 'question_choices';
	
	public $has_one = array("questionaire");
	
	public $has_many = array("answer");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>