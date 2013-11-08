<?php
class Rss extends Public_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('xml');  
        $this->load->helper('text');  
    }
    
    function information()
    {
        $data['feed_name'] = 'เว็บไซต์เครือข่ายบริการ สำนักตรวจและประเมินผล กระทรวงสาธารณสุข';  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = '';  
        $data['page_description'] = 'ประชาสัมพันธ์';  
        $data['page_language'] = 'en-en';  
        $data['creator_email'] = '';  
        $data['posts'] = new Information();
        $data['posts']->where("status = 'approve'")->order_by('id','desc')->get_page();
        header("Content-Type: application/rss+xml"); 
        $this->load->view('information', $data);
    }
}