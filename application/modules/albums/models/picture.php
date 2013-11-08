<?php
class Picture extends ORM {

    var $table = 'pictures';
	
	var $has_one = array('album');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function upload(&$file,$path = 'uploads/',$width = FALSE,$height = FALSE,$ratio = FALSE)
	{
		if($file['name'])
		{
			ini_set("max_execution_time","600");
			ini_set("memory_limit","12M");
			$this->filename = uniqid();
			$this->load->library('uploader');
			$handle = new Uploader();
			$handle->Upload($file);
			$this->handle =& $handle;
			if($width)
			{
				return $this->thumb($path, $width, $height, $ratio);
			} 
			else
			{
				if($this->handle->image_src_x > 600)
				{
					return $this->thumb($path, 600, $height, 'y');
				} 
				if(!empty($this->watermark['image']))
				{
					$this->handle->image_watermark = 'uploads/icon/watermark/'.$this->watermark['image'];
					$this->handle->image_watermark_position = $this->watermark['position'];
				}
				$this->handle->file_new_name_body = $this->filename; 
				$this->handle->process($path);
				if($this->handle->processed) 
				{
					return $this->handle->file_dst_name;
				}
			}	
		}	
	}
}
?>