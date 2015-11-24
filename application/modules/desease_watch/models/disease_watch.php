<?php
class Disease_watch extends ORM
{
	public $table = 'disease_watch';
	
	#public $has_one = array('user');
	
	public $has_one = array(
		'nursery' => array(
			'class' => 'nursery',
			'join_self_as' => 'disease_watch',
			'join_other_as' => 'nurseries'
		)
	);
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
	
}
?>