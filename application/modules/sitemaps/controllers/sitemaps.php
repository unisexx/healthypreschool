<?php
class Sitemaps extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    function index(){
       $this->load->view('index');
    }
}
?>