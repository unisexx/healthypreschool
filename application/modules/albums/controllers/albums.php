<?php
class Albums extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index($slug='main')
	{
		$data['slug'] = $slug;
		$data['category'] = new Category;
		$data['category']->get_by_slug($slug);
		$data['albums'] = new Album;
		if($slug=='main')
		{
			//$data['albums']->where('agency_id in (1,105,132,204)');
		}
		else
		{
			$data['albums']->where('agency_id',$data['category']->id);
		}
		$data['albums']->order_by('id','desc')->get_page(10);
		$this->template->build('album_index',$data);
	}

	function view($id,$slug = NULL)
	{
		$data['album'] = new Album($id);
		$data['category'] = new Category($data['album']->agency_id);
		$data['slug'] = ($slug)?$slug:$data['category']->slug;
		$data['theme'] = new Category();
		$data['theme']->get_by_slug($data['slug']);
		$this->template->build('album_view',$data);
	}
	
	function inc_index($slug = 'main')
	{
		$data['slug'] = $slug;
		$data['category'] = new Category;
		$data['category']->get_by_slug($slug);
		$data['albums'] = new Album;
		
		if($slug=='main')
		{
			$where = '';
		}
		else
		{
			$where = ' and agency_id = '.$data['category']->id;
		}
		
		$sql = 'select albums.* 
		from albums
		where albums.id in (select album_id from pictures)
		'.$where.'
		order by id desc
		limit 3';
		
		$data['albums']->query($sql);
		$this->load->view('inc_index',$data);
	}
}
?>