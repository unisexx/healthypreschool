<?php
class Question_category extends ORM {

    public $table = 'question_categories';
	
	public $has_many = array("questionaire");

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>