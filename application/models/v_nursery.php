<?php
class V_Nursery extends ORM {

    var $table = 'v_nurseries';
	
	public $has_one = array("amphur","district","province","nursery_category","area");
	
	public $has_many = array("classroom","user","assessment"	
	,'assessment' => array(
	      'class'=>'assessment',
	      'join_self_as' => 'nursery'
	      #'other_field' => 'nurseries_id'
	)
	,'disease_watch' => array(
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