<?php
class Elearnings extends Admin_Controller
{
	
	function __construct()
	{
		// if(!is_publish('questionaire'))
		// {
				// //set_notify('error','คุณไม่มีสิทธิเข้าใช้งานในส่วนนี้ค่ะ');
				// redirect('docs/publics');
		// }
		parent::__construct();
	}
	
	function index()
	{
		$data['topics'] = new Topic();
		if(@$_GET['search'])$data['topics']->like('title','%'.$_GET['search'].'%');
		if((isset($_GET['status']))&&($_GET['status']<>''))$data['topics']->where('status',$_GET['status']);
		// if(@$_GET['group_id'])$data['topics']->where_related('user','group_id',$_GET['group_id']);
		if(@$_GET['start'])$data['topics']->where('DATE(question_topics.created) >= DATE(\''.Date2DB($_GET['start']).'\')');
		if(@$_GET['end'])$data['topics']->where('DATE(question_topics.created) <= DATE(\''.Date2DB($_GET['end']).'\')');
		$data['topics']->order_by('orderlist','asc')->get_page();
		$this->template->append_metadata(js_lightbox());
		$this->template->append_metadata(js_checkbox('approve'));
		$this->template->build('admin/index',$data);
	}
	
	function form($id = NULL)
	{
		$data['topic'] = new Topic($id);
		if($data['topic']->set_final == 1){
			$data['categories'] = new Question_category();
			$data['categories']->get();
		}
		$this->template->build('admin/form',$data);
	}

	function save($id = NULL)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		// exit();
		$topic = new Topic($id);
		$topic->title = $_POST['title'];
		$topic->detail = $_POST['detail'];
		$topic->status = $_POST['status'];
		$topic->pass = $_POST['pass'];
		$topic->random = $_POST['random'];
		if(!$id)$topic->user_id = $this->session->userdata('id');
		$topic->save();
		foreach($_POST['question_id'] as $key => $value)
		{
			if(@$_POST['question'][$key])
			{
				$question = new Questionaire($value);
				$question->question = $_POST['question'][$key];
				$question->type = $_POST['type'][$key];
				if(@$_POST['question_category_id'][$key]) $question->question_category_id = $_POST['question_category_id'][$key];
				if(@$_POST['min'][$key]) $question->min = $_POST['min'][$key];
				if(@$_POST['max'][$key]) $question->max = $_POST['max'][$key];
				if(@$_POST['range'][$key]) $question->range = $_POST['range'][$key];
				if(@$_POST['other'][$key]) $question->other = $_POST['other'][$key];
				if(@$_POST['optional'][$key]) $question->optional = json_encode($_POST['optional'][$key]);
				$question->topic_id = $topic->id;
				$question->sequence = $key;
				$question->save();
			}
			if(@$_POST['choice'][$key])
			{
				foreach($_POST['choice'][$key] as $index => $data)
				{
					if($data)
					{
						$choice = new Choice(@$_POST['choice_id'][$key][$index]);
						$choice->name = $data;
						$choice->score = (@$_POST['score'][$key][$index] == "")? 0 : @$_POST['score'][$key][$index];
						$choice->questionaire_id = $question->id;
						$choice->save();
					}
				}
			}
		}
		set_notify('success','บันทึกข้อมูลเรียบร้อยแล้วค่ะ');
		redirect('elearnings/admin/elearnings');
	}
	
	function questionaire($id)
	{
		$data['topic'] = new Topic($id);
		$this->template->build('questionaire',$data);
	}
	
	function questionaire_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		exit();*/
		foreach($_POST['question_id'] as $key => $value)
		{
			if(($_POST['type'][$key]=="text")||($_POST['type'][$key]=="textarea")||($_POST['type'][$key]=="radio")||($_POST['type'][$key]=="scale"))
			{
				if(@$_POST['answer'][$value])
				{
					$answer = new Answer;
					if(is_login())
					{
						$answer->where('user_id',$this->session->userdata('id'));
						$answer->where('questionaire_id',$value)->get();
						$answer->user_id = $this->session->userdata('id');
					}
					$answer->questionaire_id = $value;
					$answer->answer = $_POST['answer'][$value];
					$answer->save();
				}
			}
			elseif($_POST['type'][$key]=="radio")
			{
				if(@$_POST['answer'][$value])
				{
					$answer = new Answer;
					if(is_login())
					{
						$answer->where('user_id',$this->session->userdata('id'));
						$answer->where('questionaire_id',$value)->get();
						$answer->user_id = $this->session->userdata('id');
					}
					$answer->questionaire_id = $value;
					$answer->choice_id = $_POST['answer'][$value];
					$answer->save();
				}
			}
			elseif($_POST['type'][$key]=="checkbox")
			{
				if(@$_POST['answer'][$value])
				{
					$answer = new Answer;
					$answer->where('user_id',$this->session->userdata('id'));
					$answer->where('questionaire_id',$value)->get()->delete_all();
					foreach($_POST['answer'][$value] as $key => $ans)
					{
						if(is_login())
						{
							$answer = new Answer;
							$answer->user_id = $this->session->userdata('id');
						}
						$answer->questionaire_id = $value;
						$answer->choice_id = $ans;
						$answer->save();
					}
				}
			}
			elseif($_POST['type'][$key]=="grid")
			{
				if(@$_POST['answer'][$value])
				{
					foreach($_POST['answer'][$value] as $key => $ans)
					{
						$answer = new Answer;
						if(is_login())
						{
							$answer->where('user_id',$this->session->userdata('id'));
							$answer->where('choice_id',$key);
							$answer->where('questionaire_id',$value)->get();
							$answer->user_id = $this->session->userdata('id');
						}
						$answer->questionaire_id = $value;
						$answer->choice_id = $key;
						$answer->answer = $ans;
						$answer->save();
					}
				}
			}
			
		}
	}
	
	function status()
	{
		$topic = new Topic($_POST['id']);
		$topic->status = $_POST['status'];
		$topic->save();
	}
	
	function report($id)
	{
		$data['topic'] = new Topic($id);
		$this->template->build('admin/report',$data);
	}
	
	function delete($id)
	{
		$topic = new Topic($id);
		$question = new Questionaire();
		$answer = new Answer;
		$answer->where_related('questionaire','topic_id',$id)->get()->delete_all();
		$choice = new Choice;
		$choice->where_related('questionaire','topic_id',$id)->get()->delete_all();
		$question->where('topic_id',$id)->get()->delete_all();
		$topic->delete();
		set_notify('success','ลบข้อมูลเรียบร้อยแล้วค่ะ');
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_question()
	{
		$question = new Questionaire($_POST['id']);
		$question->answer->delete_all();
		$question->choice->delete_all();
		$question->delete();
	}
	
	function delete_choice($id)
	{
		$choice = new Choice($id);
		$choice->answer->delete();
		$choice->delete();
	}
	
	function other($id)
	{
		
		$data['answers'] = new Answer;
		$data['answers']->where('questionaire_id',$id)
		->where('choice_id',0)
		->get();
		$this->load->view('other',$data);
	}
	
	function approve($id)
	{
		if($_POST)
		{
			$topic = new Topic($id);
			$_POST['approve_id'] = $this->session->userdata('id');
			$topic->approve_date = date("Y-m-d H:i:s");
			$topic->from_array($_POST);
			$topic->save();
		}
	}
	
	function save_orderlist($id=FALSE){
        if($_POST)
        {
                foreach($_POST['orderlist'] as $key => $item)
                {
                    if($item)
                    {
                        $topic = new Topic(@$_POST['orderid'][$key]);
                        $topic->from_array(array('orderlist' => $item));
                        $topic->save();
                    }
                }
            set_notify('success', lang('save_data_complete'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
	
	function set_final($id)
	{
		$data = new Topic($id);
		$data->set_final = 1;
		$data->save();
		$data->clear();
		$data->where('id <>', $id)->get();
		$data->update_all('set_final',0);
		
		set_notify('success', 'ตั้งค่าแบบทดสอบสุดท้ายเรียบร้อย');
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function save_topic_category($id=FALSE){
		if($_POST){
			$rs = new Question_category($_POST['category_id']);
			$rs->from_array($_POST);
			$rs->save();
			set_notify('success', 'เพิ่มหมวดคำถามเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function save_random(){
		if($_POST){
			foreach($_POST['category_id'] as $key=>$item){
				$rs = new Question_category(@$item);
				$rs->random = $_POST['random'][$key];
                $rs->from_array();
                $rs->save();
			}
			set_notify('success', 'เพิ่มหมวดคำถามเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_category($id=false){
		if($id){
			$rs = new Question_category($id);
			$rs->delete();
			set_notify('success','ลบข้อมูลเรียบร้อยแล้วค่ะ');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}
?>