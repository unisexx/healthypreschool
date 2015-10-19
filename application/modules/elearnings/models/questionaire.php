<?php
class Questionaire extends ORM {

    public $table = 'question_titles';
	
	public $has_one = array("topic","question_category");
	
	public $has_many = array("choice","answer");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>