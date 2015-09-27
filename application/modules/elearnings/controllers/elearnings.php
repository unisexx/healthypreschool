<?php
class Elearnings extends Public_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$data['topics'] = new Topic();
		if(@$_GET['search'])$data['topics']->like('title','%'.$_GET['search'].'%');
		// if(@$_GET['group_id'])$data['topics']->where_related('user','group_id',$_GET['group_id']);
		if(@$_GET['start'])$data['topics']->where('DATE(question_topics.created) >= DATE(\''.Date2DB($_GET['start']).'\')');
		if(@$_GET['end'])$data['topics']->where('DATE(question_topics.created) <= DATE(\''.Date2DB($_GET['end']).'\')');
		$data['topics']->where('status','approve');
		$data['topics']->order_by('id','desc')->get_page();
		$this->template->append_metadata(js_datepicker());
		$this->template->build('public_index',$data);
	}
	
	function questionaire($id)
	{
		// if(!is_login())
		// {
			// $answer = new Answer;
			// $answer->where('session',$this->session->userdata('session_id'));
			// $answer->where_related('questionaire/topic','id',$id)->get();
			// if($answer->exists())
			// {
				// set_notify('error','ท่านได้ทำการตอบแบบสอบถามนี้แล้วค่ะ');
				// redirect($_SERVER['HTTP_REFERER']);
				// exit();
			// }
		// }
		$data['topic'] = new Topic($id);
		if($data['topic']->status == "draft")
		{
			set_notify('success','ท่านไม่สามารถเข้าใช้งานในส่วนนี้ค่ะ');
			redirect('docs/publics');
		}
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
			if(($_POST['type'][$key]=="text")||($_POST['type'][$key]=="textarea")||($_POST['type'][$key]=="scale"))
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
					else
					{
						$answer->where('session',$this->session->userdata('session_id'));
						$answer->where('questionaire_id',$value)->get();
						$answer->session = $this->session->userdata('session_id');
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
					else
					{
						$answer->where('session',$this->session->userdata('session_id'));
						$answer->where('questionaire_id',$value)->get();
						$answer->session = $this->session->userdata('session_id');
					}
					$answer->questionaire_id = $value;
					$answer->choice_id = $_POST['answer'][$value];
					if($_POST['answer'][$value]=='other')
					{
						$answer->choice_id = 0;
						$answer->answer = $_POST['other'][$value];
					}
					$answer->save();
				}
			}
			elseif($_POST['type'][$key]=="checkbox")
			{
				if(@$_POST['answer'][$value])
				{
					$answer = new Answer;
					if(is_login())
					{
						$answer->where('user_id',$this->session->userdata('id'));
					}
					else
					{
						$answer->where('session',$this->session->userdata('session_id'));
					}
					$answer->where('questionaire_id',$value)->get()->delete_all();
					foreach($_POST['answer'][$value] as $key => $ans)
					{
						if(is_login())
						{
							$answer = new Answer;
							$answer->user_id = $this->session->userdata('id');
						}
						else
						{
							$answer = new Answer;
							$answer->session = $this->session->userdata('session_id');
						}
						$answer->questionaire_id = $value;
						$answer->choice_id = $ans;
						if($ans=='other')
						{
							$answer->choice_id = 0;
							$answer->answer = $_POST['other'][$value];
						}
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
						else
						{
							$answer->where('session',$this->session->userdata('session_id'));
							$answer->where('choice_id',$key);
							$answer->where('questionaire_id',$value)->get();
							$answer->session = $this->session->userdata('session_id');
						}
						$answer->questionaire_id = $value;
						$answer->choice_id = $key;
						$answer->answer = $ans;
						$answer->save();
					}
				}
			}
			
		}
		redirect($_SERVER['HTTP_REFERER']);
		// redirect('elearnings/thankyou');
	}
	
	function thankyou()
	{
		$this->template->build('thankyou');
	}
	
	
}
?>