<?php
class Nursery extends ORM {

    var $table = 'nurseries';
	
	public $has_one = array("amphur","district","province","nursery_category","area");
	
	public $has_many = array("classroom","user","assessment", 
            'disease_watch' => array(
                  'class'=>'disease_watch',
                  'join_self_as' => 'nurseries'
                  #'other_field' => 'nurseries_id'
            )
      );

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}
?>