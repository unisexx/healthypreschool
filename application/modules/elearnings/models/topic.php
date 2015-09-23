<?php
class Topic extends ORM {

    public $table = 'question_topics';
	
	public $has_many = array("questionaire");
	
	public $has_one = array("user");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>