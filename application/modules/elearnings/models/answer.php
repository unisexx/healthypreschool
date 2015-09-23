<?php
class Answer extends ORM {

    public $table = 'question_answers';
	
	public $has_one = array("questionaire","choice");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>