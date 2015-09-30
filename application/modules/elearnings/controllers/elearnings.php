<?php
class Elearnings extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data = '';
		$this -> template -> build('contents', $data);
	}

	function contents() {
		$data = '';
		$this -> template -> build('contents', $data);
	}

	function learns() {
		$data = '';
		$this -> template -> build('learns', $data);
	}

	function testing_index() {
		if (is_login()) {
			$user_id = $this -> session -> userdata('id');
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
				(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = qt.id)n_answer,
				qt.set_final
			FROM
				question_topics qt
			LEFT JOIN (
				SELECT
					*
				FROM
					user_question_result
				WHERE
					user_id = " . $user_id . "
			) uqr ON qt.id = uqr.topic_id
			WHERE
				qt.status = 'approve'
			ORDER BY orderlist
			";
			$data['topics'] = $this -> db -> query($sql) -> result();
			$data['pass_all_status'] = get_pass_all_status($user_id);
			$this -> template -> append_metadata(js_datepicker());
			$this -> template -> build('testing_index', $data);
		} else {
			set_notify('error', 'กรุณาล้อกอินเข้าสู่ระบบก่อนทำแบบทดสอบ');
			redirect('elearnings/contents');
		}
	}

	function testing($topic_id) {
		$user_id = $this -> session -> userdata('id');
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
			,qt.set_final
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = " . $user_id . "
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = " . $topic_id . "
			AND qt.id NOT IN ( SELECT questionaire_id FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = " . $topic_id . " )
		ORDER BY orderlist
		";
		$data['topic'] = $this -> db -> query($sql) -> row();
		$pass_all_status = get_pass_all_status($user_id);
		$data['pass_all_status'] = get_pass_all_status($user_id);
		if (($data['topic'] -> set_final == 1 && $pass_all_status == TRUE) || $data['topic'] -> set_final == 0) {
			if ($data['topic'] -> n_answer == $data['topic'] -> n_question) {
				$this -> template -> build('testing_result', $data);
			} else {
				$sql = "SELECT * from question_titles WHERE topic_id = " . $topic_id . " ORDER BY RAND() LIMIT 1 ";
				$data['question'] = $this -> db -> query($sql) -> row();
				$data['answers'] = $this -> db -> query("select * from question_choices WHERE questionaire_id = " . $data['question'] -> id . " ORDER BY RAND() ") -> result();
				$this -> template -> build('testing', $data);
			}
		} else {
			set_notify('error', '*** ผู้ทำแบบทดสอบจะต้องทำแบบทดสอบระหว่างเรียน ผ่านทั้งหมด จึงจะทำแบบทดสอบท้ายบทเรียนได้ ***');
			redirect('elearnings/testing_index');
		}
	}

	function reset($topic_id) {
		$user_id = $this -> session -> userdata('id');
		$this -> db -> query("DELETE FROM question_answers WHERE user_id = " . $user_id . " AND questionaire_id IN (SELECT id from question_titles WHERE topic_id = " . $topic_id . ")");
		redirect('elearnings/testing/' . $topic_id);
	}

	function save() {
		$user_id = $this -> session -> userdata('id');
		$topic_id = $_POST['topic_id'];

		$answer = new Answer;
		$answer -> user_id = $this -> session -> userdata('id');
		$answer -> questionaire_id = $_POST['question_id'];
		$answer -> choice_id = $_POST['answer_id'];
		$answer -> save();

		$uqr = new User_question_result;
		$uqr -> where('user_id', $user_id);
		$uqr -> where('topic_id', $topic_id) -> get();
		$uqr -> user_id = $uqr -> user_id > 0 ? $uqr -> user_id : $user_id;
		$uqr -> topic_id = $uqr -> topic_id > 0 ? $uqr -> topic_id : $_POST['topic_id'];
		$uqr -> status = 3;
		$uqr -> create_date = $uqr -> create_date > 0 ? $uqr -> create_date : date("Y-m-d H:i:s");
		$uqr -> update_date = date("Y-m-d H:i:s");
		$uqr -> save();

		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = " . $topic_id . ")n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = " . $user_id . "
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = " . $topic_id . "
		ORDER BY orderlist
		";
		$topic = $this -> db -> query($sql) -> row();
		if ($topic -> n_question == $topic -> n_answer) {
			$this -> ajax_show_result($topic_id);
		} else {
			$this -> ajax_show_question($topic_id);
		}
	}

	function ajax_show_result($topic_id) {
		$user_id = $this -> session -> userdata('id');
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
				user_id = " . $user_id . "
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = " . $topic_id . "
			AND qt.id NOT IN ( SELECT questionaire_id FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = " . $topic_id . " )
		ORDER BY orderlist
		";
		$data['topic'] = $this -> db -> query($sql) -> row();
		$this -> load -> view('ajax_show_result', $data);
	}

	function ajax_show_question($topic_id) {
		$user_id = $this -> session -> userdata('id');
		$data = '';
		$sql = "
		SELECT
			qt.id topic_id,
			qt.title,
			uqr.user_id,
			qt.random n_question,
			(SELECT COUNT(*) FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE topic_id = " . $topic_id . ")n_answer
		FROM
			question_topics qt
		LEFT JOIN (
			SELECT
				*
			FROM
				user_question_result
			WHERE
				user_id = " . $user_id . "
		) uqr ON qt.id = uqr.topic_id
		WHERE
			qt.id = " . $topic_id . "
		ORDER BY orderlist
		";
		$data['topic'] = $this -> db -> query($sql) -> row();
		$sql = "SELECT * from question_titles WHERE topic_id = " . $topic_id . " ORDER BY RAND() LIMIT 1 ";
		$data['question'] = $this -> db -> query($sql) -> row();
		$data['answers'] = $this -> db -> query("select * from question_choices WHERE questionaire_id = " . $data['question'] -> id . " ORDER BY RAND() ") -> result();
		$this -> load -> view('ajax_testing', $data);
	}

}
?>