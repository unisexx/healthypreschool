<?php
/*
 * Author: Yotsakon Pitinanon
 * Email: iyottt@gmail.com
 * Version: 1.1
 */
class ORM extends DataMapper
{
	public $handle = NULL;
	public $filename = NULL;
	public $sql = NULL;
    public $watermark = array();
    
    public $sql_page_total = null;
    public $sql_pagination = null;
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	public function sql($sql = NULL)
	{
		$this->sql = $sql;
		return $this;
	}
	
	public function get_page($page_size = 20, $page_num_by_rows = FALSE, $info_object = 'paged', $iterated = FALSE)
	{
		$page = @$_GET['page'];
		// first, duplicate this query, so we have a copy for the query
		$count_query = $this->get_clone(TRUE);
		$clone = $this->get_clone(TRUE);
		
		if($page_num_by_rows)
		{
			$page = 1 + floor(intval($page) / $page_size);
		}

		// never less than 1
		$page = max(1, intval($page));
		$offset = $page_size * ($page - 1);
		
		// for performance, we clear out the select AND the order by statements,
		// since they aren't necessary and might slow down the query.
		$count_query->db->ar_select = NULL;
		$count_query->db->ar_orderby = NULL;
		$total = $count_query->db->ar_distinct ? $count_query->count_distinct() : $count_query->count();
		
		// common vars
		$last_row = $page_size * floor($total / $page_size);
		$total_pages = ceil($total / $page_size);

		if($offset >= $last_row)
		{
			// too far!
			$offset = $last_row;
			$page = $total_pages;
		}

		// now query this object
		if($iterated)
		{
			$this->get_iterated($page_size, $offset);
			$clone->get();
		}
		else if($this->sql)
		{
			$clone->query($this->sql);			
			$query = $this->db->query($this->sql." limit $offset,$page_size");	
			$this->_process_query($query);	
		}
		else
		{
			$this->get($page_size, $offset);
			$clone->get();
		}
		
		$this->{$info_object} = new stdClass();

		$this->{$info_object}->page_size = $page_size;
		$this->{$info_object}->items_on_page = $this->result_count();
		$this->{$info_object}->current_page = $page;
		$this->{$info_object}->current_row = $offset;
		$this->{$info_object}->total_rows = $clone->result_count();;
		$this->{$info_object}->last_row = $last_row;
		$this->{$info_object}->total_pages = $total_pages;
		$this->{$info_object}->has_previous = $offset > 0;
		$this->{$info_object}->previous_page = max(1, $page-1);
		$this->{$info_object}->previous_row = max(0, $offset-$page_size);
		$this->{$info_object}->has_next = $page < $total_pages;
		$this->{$info_object}->next_page = min($total_pages, $page+1);
		$this->{$info_object}->next_row = min($last_row, $offset+$page_size);

		return $this;
	}
	
	function pagination()
	{
		$string = $_SERVER['REQUEST_URI'];
		$pattern = '/(&page=[0-9]+)/i';
		$replacement = '';
		$target = preg_replace('/([&?]+page=[0-9]+)/i', '',  $_SERVER['REQUEST_URI']);
		$this->load->library('pagination');
		$page = new pagination();
		$page->target($target);
		$page->limit($this->paged->page_size);
		@$page->currentPage($this->paged->current_page);
		$page->Items($this->paged->total_rows);
		return $page->show();
	}
    
    function sql_page($sql, $limit = 20)
    {
        $db = get_instance()->db;
        $this->sql_page_total = $db->query($sql)->num_rows();
        
        $this->load->library('pagination');
        $page = new pagination();
        $page->target(preg_replace('/([&?]+page=[0-9]+)/i', '',  $_SERVER['REQUEST_URI']));
        $page->limit($limit);
        @$page->currentPage($_GET['page']);
        $page->Items($this->sql_page_total);
        $this->sql_pagination = $page->show();
        $c_page = ($page->page == 1) ? 0 : ($page->page-1) * $page->limit; 
        return $db->query($sql.' limit '.$c_page.','.$page->limit)->result();
    }
	
	function counter($field = 'counter')
	{
		$this->where('id',$this->id)->update($field,$field.' + 1',FALSE);
		return $this;
	}
	
	function upload(&$file,$path = 'uploads/',$width = FALSE,$height = FALSE,$ratio = FALSE)
	{
		if($file['name'])
		{
			ini_set("max_execution_time","600");
			ini_set("memory_limit","-1");
			$this->filename = uniqid();
			$this->load->library('uploader');
			$handle = new Uploader();
			$handle->Upload($file);
			$this->handle =& $handle;
            if(!empty($this->watermark['image']))
            {
                $this->handle->image_watermark = 'uploads/watermark/'.$this->watermark['image'];
                $this->handle->image_watermark_position = $this->watermark['position'];
            }
			if($width)
			{
				return $this->thumb($path, $width, $height, $ratio);
			} 
			else
			{
				$this->handle->file_new_name_body = $this->filename; 
				$this->handle->process($path);
				if($this->handle->processed) 
				{
					return $this->handle->file_dst_name;
				}
			}	
		}	
	}
	
	function thumb($path,$width,$height,$ratio = FALSE)
	{
		if($this->handle)
		{
			$this->handle->image_resize = TRUE;
			$this->handle->image_ratio_crop = TRUE;
			if($ratio)
			{
				if($ratio == 'x')
				{
					$this->handle->image_y = $height;
					$this->handle->image_ratio_x = TRUE;			
				}
				if($ratio == 'y')
				{
					$this->handle->image_x = $width;
					$this->handle->image_ratio_y = TRUE;			
				}
			}
			else
			{
				$this->handle->image_x = $width;	
				$this->handle->image_y = $height;
			}
			$this->handle->file_new_name_body = $this->filename; 
			$this->handle->process($path);
			if($this->handle->processed) 
			{
				return $this->handle->file_dst_name;
			}
		}
	}
    
    public function watermark($image, $position)
    {
        $this->watermark = array(
            'image' => $image,
            'position' => $position
        );
        return $this;
    }
	
	function delete_file($path,$field = 'image')
	{
		$this->get_by_id($this->id);
		@unlink($path.$this->$field);
	}
	
    /*
     * $config = arrray('field' => 'model');
     */
    function get_order($config = null)
    {
        if(!empty($_GET['order']) and !empty($_GET['sort']))
        {
            if ($this->db->field_exists($_GET['order'], $this->table))
            {
                $field = $this->db->query('select '.$_GET['order'].' from '.$this->table.' limit 1')->field_data();
                $order = ($field[0]->type) ? 'CONVERT('.$_GET['order'].' USING TIS620)' : $_GET['order'];
                $this->order_by($order, $_GET['sort']);   
            }
            else if(is_array($config))
            {
                $class = $config[$_GET['order']];
                $obj = new $class;
                $field = $this->db->query('select '.$_GET['order'].' from '.$obj->table.' limit 1')->field_data();
                $order = ($field[0]->type) 
                ? $this->order_by_func('CONVERT', array('@'.$class.'/'.$_GET['order'], '[USING TIS620]'),$_GET['sort']) 
                : $this->order_by($order, $_GET['sort']);
            }           
        }
        return $this;
    }
}
?>