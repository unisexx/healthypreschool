<?php
class Contents extends Admin_Controller
{
	public $array = array('informations'=>'ข่าวประชาสัมพันธ์','articles'=>'บทความน่าสนใจ','vdos'=>'vdo แนะนำ','downloads'=>'เอกสารดาวน์โหลด','histories'=>'ความเป็นมาศูนย์เด็กเล็กปลอดโรค','newsletters'=>'จดหมายข่าว');
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index($type=false)
	{
		$data['type'] = $type;
		$data['type_name']=$this->array[$type];
		// $data['contents'] = new $type();
		$data['contents'] = new Content();
		if(@$_GET['search'])$data['contents']->where("title like '%".$_GET['search']."%'");
		if(@$_GET['status'])$data['contents']->where('status',$_GET['status']);
		if(@$_GET['category_id'])$data['contents']->where("category_id = ".$_GET['category_id']);
		$data['contents']->where('module = "'.$type.'"');
		$data['contents']->order_by('id','desc')->get_page();
		$this->template->append_metadata(js_lightbox());
		$this->template->append_metadata(js_checkbox('approve'));
		$this->template->build('admin/index',$data);
	}
	
	function form($type=false,$id=FALSE)
	{
		$data['type'] = $type;
		$data['type_name']=$this->array[$type];
		$data['content'] = new Content($id);
        
        // ไฟล์แนบ
        if($id){
        	$data['attachs'] = new Attach();
        	$data['attachs']->where("module = '".$type."' and content_id = ".$id)->order_by('id','asc')->get();
        }
        
		//$this->template->append_metadata(js_datepicker());
		if($type=='vdos'){
			$this->template->build('admin/vdo_form',$data);
		}elseif($type=='downloads'){
			$this->template->build('admin/download_form',$data);
		}else{
			$this->template->build('admin/form',$data);
		}
	}
	
	function save($type=false,$id=FALSE)
	{
		if($_POST)
		{
			$content = new Content($id);
			$_POST['status'] = 'approve';
			$_POST['module'] = $type;
			$_POST['slug'] = clean_url($_POST['title']);
			if(!$id)$_POST['user_id'] = $this->session->userdata('id');
			if(@$_FILES['image']['name'])
			{
				if($id)$content->delete_file($content->id,'uploads/content/thumbnail','image');
				$content->image = $content->upload($_FILES['image'],'uploads/content/');
			}
			$content->from_array($_POST);
			$content->save();
			
            //ไฟล์แนบ
            if(!empty($_POST['file'])){
	            foreach($_POST['file'] as $key=>$item){
	                if($item){
	                    if(!$id){
	                        $id = new Content($id);
	                        $id = $id->order_by('id','desc')->get(1)->id;
	                    }
	                    $attach = new Attach();
	                    $attach->from_array(array(
	                        'id' => @$_POST['attach_id'][$key],
	                        'content_id' => $id,
	                        'file_name' => @$_POST['file_name'][$key],
	                        'file' => $_POST['file'][$key],
	                        'module' => $type
	                    ));
	                    $attach->save();
	                }
	            }
			}
            
			set_notify('success', lang('save_data_complete'));
		}
		if($type=='histories'){ // one_page_form
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect($_POST['referer']);
		}
	}
	
	function approve($type=false,$id)
	{
		if($_POST)
		{
			$content = new Content($id);
			$_POST['approve_id'] = $this->session->userdata('id');
			$content->approve_date = date("Y-m-d H:i:s");
			$content->from_array($_POST);
			$content->save();
			// echo approve_comment($content);
		}

	}
	
	function delete($type=false,$id=FALSE)
	{
		if($id)
		{
			$content = new Content($id);
			$content->delete();
            $attachs = new Attach();
            $attachs->where("module = '".$type."' and content_id = ".$id)->get();
            foreach($attachs as $item) $item->delete();
			set_notify('success', lang('delete_data_complete'));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

    function delfile(){
        if($_POST){
            $attach = new Attach($_POST['id']);
            $attach->delete();
        }
    }
	
	function save_orderlist($type=false,$id=FALSE){
		if($_POST)
		{
			foreach($_POST['orderlist'] as $key => $item)
			{
				if($item)
				{
					$content = new $type(@$_POST['orderid'][$key]);
					$content->from_array(array('orderlist' => $item));
					$content->save();
				}
			}
			set_notify('success', lang('save_data_complete'));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>