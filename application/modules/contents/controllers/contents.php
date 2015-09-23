<?php
class Contents extends Public_Controller
{
	public $array = array('informations'=>'ข่าวประชาสัมพันธ์','articles'=>'บทความน่าสนใจ','vdos'=>'vdo แนะนำ','downloads'=>'เอกสารดาวน์โหลด','histories'=>'ความเป็นมาศูนย์เด็กเล็กปลอดโรค','newsletters'=>'จดหมายข่าว');
	
	public $header_img = array('informations'=>'<img src="themes/hps/images/title_news.png" width="698" height="47">','articles'=>'<img src="themes/hps/images/title_article.png" width="698" height="47">','vdos'=>'<img src="themes/hps/images/title_vdo.png" width="698" height="47">','histories'=>'','downloads'=>'');
	
    function __construct()
    {
        parent::__construct();
    }
    
    function download($id)
    {
        if($id){
            $attach = new Attach($id);
            $attach->counter();
            $this->load->helper('download');
            $data = file_get_contents(urldecode($attach->file));
            $name = basename($attach->file);
            force_download($name, $data); 
        }
    }
	
	function inc_home_informations(){
		$data['contents'] = new Content();
		$data['contents']->where("module = 'informations'")->order_by('id','desc')->get(4);
		$this->load->view('inc_home_informations',$data);
	}
	
	function inc_home_articles(){
		$data['contents'] = new Content();
		$data['contents']->where("module = 'articles'")->order_by('id','desc')->get(5);
		$this->load->view('inc_home_articles',$data);
	}
	
	function inc_home_newsletter(){
		$data['contents'] = new Content();
		$data['contents']->where("module = 'newsletters'")->order_by('id','desc')->get(7);
		$this->load->view('inc_home_newsletter',$data);
	}
	
	function inc_home_vdos(){
		$data['contents'] = new Content();
		$data['contents']->where("module = 'vdos'")->order_by('id','desc')->get(7);
		$this->load->view('inc_home_vdos',$data);
	}
	
	function more($type){
		@$data['header_img'] = $this->header_img[$type]; 
		$data['type_name'] = $this->array[$type];
		$data['contents'] = new Content();
		$data['contents']->where("module = '".$type."'")->order_by('id','desc')->get_page();
		if($type=="downloads"){
			$this->template->build('index_download',$data);
		}elseif($type == 'vdos'){
			$this->template->build('index_vdo',$data);
		}else{
			$this->template->build('index',$data);
		}
	}
	
	function view($type,$id){
		$data['content'] = new Content($id);
		$data['type'] = $data['content']->module;
		$data['type_name'] = $this->array[$data['content']->module];
		@$data['header_img'] = $this->header_img[$data['content']->module];
		if($type == 'histories'){
			$this->template->build('view_onepage',$data);
		}elseif($type == 'vdos'){
			$this->template->build('view_vdo',$data);
		}else{
			$this->template->build('view',$data);
		}
	}
}
?>