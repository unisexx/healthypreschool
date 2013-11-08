<?php

class Users extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$data['users'] = new User;
		$data['users']->where('level_id',2);
		$this->template->build('admin/users/index',$data);
	}
	
	public function form($id = NULL)
	{	
		$data['user'] = new User($id);
		
		$register_category = new Category();
		$data['register_categories'] = $register_category->where("module = 'registers' and id in (select distinct category_id from registers)")->order_by('id','asc')->get();
		
		$buyproduct = new Buyproduct();
		$data['buyproducts'] = $buyproduct->order_by('id','asc')->get();
		
		//media
		$this->template->append_metadata('<script type="text/javascript" src="media/js/jquery.rsv.js"></script>');
		$this->template->build('admin/users/form',$data);
	}
	
	public function save($id = NULL)
	{
		if($_POST)
		{
			$user = new User($id);
			$user->from_array($_POST);
			if(isset($_POST['know'])){
				$user->know = implode(',',$_POST['know']);
			}
			if(isset($_POST['buyproduct'])){
				$user->buyproduct = implode(',',$_POST['buyproduct']);
			}
			$user->save();
			set_notify('success', lang('save_data_complete'));	
		}
		redirect('users/admin/users');
	}
	
	public function delete($id)
	{
		if($id)
		{
			$user = new User($id);
			$user->delete();	
			set_notify('success', lang('delete_data_complete'));	
		}
		redirect('users/admin/users');
	}
	
}

?>