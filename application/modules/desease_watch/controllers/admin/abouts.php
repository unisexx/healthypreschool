<?php
Class Abouts extends Admin_Controller{
	
	function __construct(){
		parent::__construct();	
	}
	
	function form($id=FALSE){
		$data['about'] = new About($id);
		
		if($id){
        $data['attachs'] = new Attach();
        $data['attachs']->where("module = 'abouts' and content_id = ".$id)->order_by('id','asc')->get();
        }
		
		$this->template->build('admin/about_form',$data);
	}
	
	function save($id=FALSE)
	{
		if($_POST){
			$about = new About($id);
			$_POST['user_id'] = $this->session->userdata('id');
			$about->from_array($_POST);
			$about->save();
			
			//ไฟล์แนบ
            foreach($_POST['file'] as $key=>$item){
                if($item){
                    if(!$id){
                        $id = new About($id);
                        $id = $id->order_by('id','desc')->get(1)->id;
                        
                    }
                    $attach = new Attach();
                    $attach->from_array(array(
                        'id' => $_POST['attach_id'][$key],
                        'content_id' => $id,
                        'file_name' => $_POST['file_name'][$key],
                        'file' => $_POST['file'][$key],
                        'module' => 'abouts'
                    ));
                    $attach->save();
                }
            }
			
			set_notify('success', lang('save_data_complete'));
		}
		redirect('abouts/admin/abouts/form/'.$_POST['id']);
	}
	
}
?>