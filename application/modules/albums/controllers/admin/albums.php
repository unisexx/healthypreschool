<?php
class Albums extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$data['albums'] = new Album;
		$data['albums']->order_by('id','desc')->get_page();
		//$data['albums']->where('agency_id',$_GET['agency_id'])->order_by('id','desc')->get_page();
		$this->template->build('admin/album_index',$data);
	}
	
	function form($id = NULL)
	{	
		$data['album'] = new Album($id);
		$this->template->append_metadata(js_lightbox());
		$this->template->build('admin/album_form',$data);	
	}
	
	function save($id=FALSE)
	{
		if($_POST)
		{
			$album = new Album($id);
			$album->user_id = $this->session->userdata('id');
			$album->from_array($_POST);
			$album->save();
			
			fix_file($_FILES['image']);
			foreach($_FILES['image'] as $key => $image)
			{
					$picture = new Picture(@$_POST['picture_id'][$key]);
					if($image['name'])
					{
						if(@$_POST['picture_id'][$key])
						{
							$picture->delete_file('uploads/albums/'.$album->id,'image');
							$picture->delete_file('uploads/albums/thumbnail/'.$album->id,'image');
						}
						if(@$_POST['watermark'])
						{
							$picture->watermark($_POST['watermark'], $_POST['position']);
						}
						$picture->image = $picture->upload($image,'uploads/albums/'.$album->id);
						$picture->thumb('uploads/albums/'.$album->id.'/thumbnail',275,180);	
						$picture->album_id = $album->id;
						$picture->save();
					}		
					
				
			}
			
			set_notify('success', lang('save_data_complete'));
		}
		redirect('albums/admin/albums/form/'.$album->id.'?agency_id='.$_POST['agency_id']);
	}
	
	function delete($id)
	{
		if($id)
		{
			$album = new Album($id);
			remove_dir('uploads/albums/'.$album->id);
			$album->picture->delete_all();
			$album->delete();
			set_notify('success', lang('delete_data_complete'));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_picture($id)
	{
		if($id)
		{
			$picture = new Picture($id);
			$picture->delete_file('uploads/albums/'.$album->id,'image');
			$picture->delete_file('uploads/albums/thumbnail/'.$album->id,'image');
			$picture->delete();
		}
	}
	
	function category_save($id = NULL)
	{
		$category = new Album_category($id);
		$category->from_array($_POST);
		$category->save();
		echo form_dropdown('album_category_id',get_option('id','name','album_categories'),$category->id);
	}
	
	function category_delete($id)
	{
		$category = new Album_category($id);
		$category->delete();
		echo form_dropdown('album_category_id',get_option('id','name','album_categories'));
	}
	
}
?>