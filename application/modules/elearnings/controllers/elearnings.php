<?php
class Elearnings extends Public_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		//$data['topics'] = new Topic();
		//if(@$_GET['search'])$data['topics']->like('title','%'.$_GET['search'].'%');
		// if(@$_GET['group_id'])$data['topics']->where_related('user','group_id',$_GET['group_id']);
		//if(@$_GET['start'])$data['topics']->where('DATE(question_topics.created) >= DATE(\''.Date2DB($_GET['start']).'\')');
		//if(@$_GET['end'])$data['topics']->where('DATE(question_topics.created) <= DATE(\''.Date2DB($_GET['end']).'\')');
		//$data['topics']->where('status','approve');
		//$data['topics']->order_by('id','desc')->get_page();
		$user_id = $this->session->userdata('id');
		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,		  	
			(
			SELECT sum(score) FROM question_choices 
			INNER JOIN question_answers ON question_choices.id = question_answers.choice_id 
			LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id 
			WHERE question_answers.user_id = 288 AND question_titles.topic_id = qt.id
			)
			score,
			qt.pass,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = qt.id)n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = ".$user_id."
		) uqr ON qt.id = uqr.topic_id
		WHERE
			1 = 1
		ORDER BY orderlist
		";
		$data['topics'] = $this->db->query($sql)->result();
		$this->template->append_metadata(js_datepicker());
		$this->template->build('public_index',$data);
	}
	
	function testing($topic_id){
		$user_id = $this->session->userdata('id');
		$data = '';
		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,		  	
			(
			SELECT sum(score) FROM question_choices 
			INNER JOIN question_answers ON question_choices.id = question_answers.choice_id 
			LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id 
			WHERE question_answers.user_id = 288 AND question_titles.topic_id = qt.id
			)
			score,
			qt.pass,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = qt.id)n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = ".$user_id."
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = ".$topic_id."
			AND qt.id NOT IN ( SELECT questionaire_id FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = ".$topic_id." )
		ORDER BY orderlist
		";
		$data['topic'] = $this->db->query($sql)->row();
		if($data['topic']->n_answer == $data['topic']->n_question){
			$this->template->build('testing_result',$data);
		}else{
			$sql = "SELECT * from question_titles WHERE topic_id = ".$topic_id." ORDER BY RAND() LIMIT 1 ";
			$data['question'] = $this->db->query($sql)->row();
			$data['answers'] = $this->db->query("select * from question_choices WHERE questionaire_id = ".$data['question']->id." ORDER BY RAND() " )->result();
			$this->template->build('testing',$data);	
		}		
	}
	function reset($topic_id){
		$user_id = $this->session->userdata('id');
		$this->db->query("DELETE FROM question_answers WHERE user_id = ".$user_id." AND questionaire_id IN (SELECT id from question_titles WHERE topic_id = ".$topic_id.")");		
		redirect('elearnings/testing/'.$topic_id);
	}
	function save(){
		$user_id = $this->session->userdata('id');
		$topic_id = $_POST['topic_id'];
		
		$answer = new Answer;			
		$answer->user_id = $this->session->userdata('id');
		$answer->questionaire_id = $_POST['question_id'];
		$answer->choice_id = $_POST['answer_id'];
		$answer->save();				
		
		$uqr = new User_question_result;
		$uqr->where('user_id',$user_id);
		$uqr->where('topic_id',$topic_id)->get();
		$uqr->user_id = $uqr->user_id > 0 ? $uqr->user_id : $user_id;
		$uqr->topic_id = $uqr->topic_id > 0 ? $uqr->topic_id : $_POST['topic_id'];
		$uqr->status = 3;
		$uqr->create_date = $uqr->create_date > 0 ? $uqr->create_date : date("Y-m-d H:i:s");
		$uqr->update_date = date("Y-m-d H:i:s");
		$uqr->save();
		
		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = ".$topic_id.")n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = ".$user_id."
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = ".$topic_id."
		ORDER BY orderlist
		";
		$topic = $this->db->query($sql)->row();
		if($topic->n_question == $topic->n_answer){
			$this->ajax_show_result($topic_id);
		}else{
			$this->ajax_show_question($topic_id);
		}
	}
	
	function ajax_show_result($topic_id){
		$user_id = $this->session->userdata('id');
		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,		  	
			(
			SELECT sum(score) FROM question_choices 
			INNER JOIN question_answers ON question_choices.id = question_answers.choice_id 
			LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id 
			WHERE question_answers.user_id = 288 AND question_titles.topic_id = qt.id
			)
			score,
			qt.pass,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = qt.id)n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = ".$user_id."
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = ".$topic_id."
			AND qt.id NOT IN ( SELECT questionaire_id FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = ".$topic_id." )
		ORDER BY orderlist
		";
		$data['topic'] = $this->db->query($sql)->row();
		$this->load->view('ajax_show_result',$data);
	}
	function ajax_show_question($topic_id){
		$user_id = $this->session->userdata('id');
		$data = '';
		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = ".$topic_id.")n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = ".$user_id."
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = ".$topic_id."
		ORDER BY orderlist
		";
		$data['topic'] = $this->db->query($sql)->row();
		$sql = "SELECT * from question_titles WHERE topic_id = ".$topic_id." ORDER BY RAND() LIMIT 1 ";
		$data['question'] = $this->db->query($sql)->row();
		$data['answers'] = $this->db->query("select * from question_choices WHERE questionaire_id = ".$data['question']->id." ORDER BY RAND() " )->result();
		$this->load->view('ajax_testing',$data);
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