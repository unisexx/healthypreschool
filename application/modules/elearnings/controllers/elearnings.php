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
            $sql = " SELECT
            `users`.`id` AS `user_id`,
            `users`.`name` AS `name`,
            `qt`.`id` AS `topic_id`,
            `qt`.`title` AS `title`,
            `qt`.`set_final` AS `set_final`,
            `qt`.`status` AS `topic_status`,
            `qt`.`pass` AS `pass`,
            `qt`.`random` AS `n_question`,
             IFNULL(n_user_answer,0)n_answer,
            (
                    SELECT
                        ifnull(
                            sum(`question_choices`.`score`),
                            0
                        )
                    FROM
                        (
                            (
                                `question_choices`
                                JOIN `question_answers` ON (
                                    (
                                        `question_choices`.`id` = `question_answers`.`choice_id`
                                    )
                                )
                            )
                            LEFT JOIN `question_titles` ON (
                                (
                                    `question_answers`.`questionaire_id` = `question_titles`.`id`
                                )
                            )
                        )
                    WHERE
                        (
                            (
                                `question_answers`.`user_id` = `users`.`id`
                            )
                            AND (
                                `question_titles`.`topic_id` = `qt`.`id`
                            )
                        )
                ) AS `score`,
                user_question_result.create_date,
                user_question_result.update_date,
                orderlist
        FROM
            (
                `users`
                JOIN `question_topics` `qt`
              LEFT JOIN user_question_result ON users.id = user_question_result.user_id AND qt.id = user_question_result.topic_id
            )
        WHERE
            users.id = ".$user_id." AND status = 'approve' ORDER BY orderlist ";         
            //echo $sql .= " AND topic_status = 'approve' ORDER BY orderlist ";
            $data['topics'] = $this -> db -> query($sql) -> result();
            $data['pass_all_status'] = get_pass_all_status($user_id);
            $data['pass_final_status'] = get_pass_final_status($user_id);
            $this -> template -> append_metadata(js_datepicker());
            $this -> template -> build('testing_index', $data);
        } else {
            set_notify('error', 'กรุณาล้อกอินเข้าสู่ระบบก่อนทำแบบทดสอบ');
            redirect('elearnings/contents');
        }
    }

    function testing_final($topic_id) {
        $user_id = $this -> session -> userdata('id');
        $data = '';
        $sql = "
            SELECT
                qr.*,
                question_topics.orderlist,
                (
                        SELECT
                            `user_question_result`.`create_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `create_date`,
                (
                        SELECT
                            `user_question_result`.`update_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `update_date`,
                (
                        SELECT
                            ifnull(
                                sum(`question_choices`.`score`),
                                0
                            )
                        FROM
                            (
                                (
                                    `question_choices`
                                    JOIN `question_answers` ON (
                                        (
                                            `question_choices`.`id` = `question_answers`.`choice_id`
                                        )
                                    )
                                )
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `score`,
                (
                        SELECT
                            ifnull(count(0), 0)
                        FROM
                            (
                                `question_answers`
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                                AND (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                            )
                    ) AS `n_answer`
                FROM
                (
                SELECT
                    `users`.`id` AS `user_id`,
                    `users`.`name` AS `name`,
                    `qt`.`id` AS `topic_id`,
                    `qt`.`title` AS `title`,
                    `qt`.`set_final` AS `set_final`,
                    `qt`.`status` AS `topic_status`,
                    `qt`.`pass` AS `pass`,
                  `qt`.`random` AS `n_question` 
                FROM
                    (
                        `users`
                        JOIN `question_topics` `qt`
                    )
                WHERE 
                users.id = " . $user_id . "
                )qr
                left join question_topics on qr.topic_id = question_topics.id     
        ";
        $sql .= " WHERE topic_id = " . $topic_id . " AND topic_status = 'approve' ORDER BY orderlist ";
        $data['topic'] = $this -> db -> query($sql) -> row();
        $pass_all_status = get_pass_all_status($user_id);
        $data['pass_all_status'] = get_pass_all_status($user_id);
        if (($data['topic'] -> set_final == 1 && $pass_all_status == TRUE) || $data['topic'] -> set_final == 0) {
            if ($data['topic'] -> n_answer == $data['topic'] -> n_question) {
                $this -> template -> build('testing_result', $data);
            } else {
                $ext_condition = '';
                if ($data['topic'] -> set_final == 1) {
                    $ext_category = '';
                    $sql = "select 
					q_cat.id
					,q_cat.`name`
					,q_cat.random n_question
					,(select count(*) from question_answers qa 
						inner join question_titles qt on qa.questionaire_id = qt.id 
						where 
						qt.topic_id = " . $topic_id . " 
						and qa.user_id = " . $user_id . " 
						and qt.question_category_id = q_cat.id
						)n_answer
					FROM question_categories q_cat
					";
                    $result = $this -> db -> query($sql) -> result();
                    foreach ($result as $row) {
                        if ($row -> n_question > $row -> n_answer) {
                            $ext_category .= $ext_category != '' ? "," . $row -> id : $row -> id;
                        }
                    }
                    $ext_condition = $ext_category != '' ? " AND question_category_id IN (" . $ext_category . ") " : "";
                }
                $ext_condition .= " AND id NOT IN (SELECT questionaire_id FROM question_answers WHERE user_id = " . $user_id . ")";
                $sql = "SELECT * from question_titles WHERE topic_id = " . $topic_id . $ext_condition . " ORDER BY RAND() LIMIT 1 ";
                $data['question'] = $this -> db -> query($sql) -> row();
                $data['answers'] = $this -> db -> query("select * from question_choices WHERE questionaire_id = " . $data['question'] -> id . " ORDER BY RAND() ") -> result();
                $this -> template -> build('testing', $data);
            }
        } else {
            set_notify('error', '*** ผู้ทำแบบทดสอบจะต้องทำแบบทดสอบระหว่างเรียน ผ่านทั้งหมด จึงจะทำแบบทดสอบท้ายบทเรียนได้ ***');
            redirect('elearnings/testing_index');
        }
    }

    function testing($topic_id) {
        $user_id = $this -> session -> userdata('id');
        $data = '';        
        $sql = "SELECT
    `users`.`id` AS `user_id`,
    `users`.`name` AS `name`,
    `qt`.`id` AS `topic_id`,
    `qt`.`title` AS `title`,
    `qt`.`set_final` AS `set_final`,
    `qt`.`status` AS `topic_status`,
    `qt`.`pass` AS `pass`,
    `qt`.`random` AS `n_question`,
   IFNULL(n_user_answer,0)n_answer,
   IFNULL(n_user_score,0)score
FROM
    
        `users`
        JOIN `question_topics` `qt`
        LEFT JOIN user_question_result ON users.id = user_question_result.user_id and user_question_result.topic_id = qt.id
WHERE 1=1 ";
        $sql .= " AND users.id = " . $user_id . " AND `qt`.`id` = " . $topic_id . " AND `qt`.`status` = 'approve'";
        $topic = $this -> db -> query($sql) -> row();
        $random = $topic -> n_question > 0 ? $topic -> n_question : 10;
        $question = $this -> db -> query("select * from question_titles WHERE topic_id = " . $topic_id . " order by rand() limit " . $random) -> result();
        $data['topic'] = $topic;
        $data['question'] = $question;
        $pass_all_status = get_pass_all_status($user_id);
        $data['pass_all_status'] = get_pass_all_status($user_id);
        if (($data['topic'] -> set_final == 1 && $pass_all_status == TRUE) || $data['topic'] -> set_final == 0) {
            if ($data['topic'] -> n_answer == $data['topic'] -> n_question) {
                $this -> template -> build('testing_result', $data);
            } else {
                $this -> template -> build('testing_all', $data);
            }
        } else {
            set_notify('error', '*** ผู้ทำแบบทดสอบจะต้องทำแบบทดสอบระหว่างเรียน ผ่านทั้งหมด จึงจะทำแบบทดสอบท้ายบทเรียนได้ ***');
            redirect('elearnings/testing_index');
        }
    }

    function testing_save_all($topic_id) {
        $user_id = $this -> session -> userdata('id');
        $n_answer=0;
        $this -> db -> query("DELETE FROM question_answers WHERE user_id = " . $user_id . " AND questionaire_id IN (SELECT id from question_titles WHERE topic_id = " . $topic_id . ")");
        foreach ($_POST['question_id'] as $key) {
            $answer = new Answer;
            $answer -> user_id = $this -> session -> userdata('id');
            $answer -> questionaire_id = $key;
            $answer -> choice_id = $_POST[$key . '_answer_id'];
            $answer -> save();  
            $n_answer++;          
        }
        
        $uqr = new User_question_result;
        $uqr -> where('user_id', $user_id);
        $uqr -> where('topic_id', $topic_id) -> get();
        $uqr -> user_id = $user_id;
        $uqr -> topic_id = $topic_id;
        $uqr -> status = 3;
        $uqr -> create_date = $uqr -> create_date > 0 ? $uqr -> create_date : date("Y-m-d H:i:s");
        $uqr -> update_date = date("Y-m-d H:i:s");
        $uqr->n_user_answer = $n_answer;
        $uqr-> save();
		
		$sql = "UPDATE user_question_result
		SET 
		n_user_answer = (select count(*) from question_answers inner join question_titles on question_answers.questionaire_id = question_titles.id  where question_answers.user_id = user_question_result.user_id and question_titles.topic_id = user_question_result.topic_id),
		n_user_score = (
			SELECT
				ifnull(
					sum(`question_choices`.`score`),
					0
				)
			FROM
				(
					(
						`question_choices`
						JOIN `question_answers` ON (
							(
								`question_choices`.`id` = `question_answers`.`choice_id`
							)
						)
					)
					LEFT JOIN `question_titles` ON (
						(
							`question_answers`.`questionaire_id` = `question_titles`.`id`
						)
					)
				)
		WHERE `question_answers`.`user_id` = user_question_result.user_id AND `question_titles`.`topic_id` = user_question_result.topic_id					
		)
		WHERE user_id = ".$user_id." and topic_id = ".$topic_id;		
		$this->db->query($sql);
        redirect('elearnings/testing_index');
    }

    function reset_final($topic_id) {
        $user_id = $this -> session -> userdata('id');
        $this -> db -> query("DELETE FROM question_answers WHERE user_id = " . $user_id . " AND questionaire_id IN (SELECT id from question_titles WHERE topic_id = " . $topic_id . ")");
        $this->db->query("UPDATE user_question_result SET n_user_answer = 0,n_user_score = 0  WHERE user_id=".$user_id." AND topic_id = ".$topic_id);
        redirect('elearnings/testing_final/' . $topic_id);
    }

    function reset($topic_id) {
        $user_id = $this -> session -> userdata('id');
        $this -> db -> query("DELETE FROM question_answers WHERE user_id = " . $user_id . " AND questionaire_id IN (SELECT id from question_titles WHERE topic_id = " . $topic_id . ")");
        $this->db->query("UPDATE user_question_result SET n_user_answer = 0,n_user_score = 0 WHERE user_id=".$user_id." AND topic_id = ".$topic_id);
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
        
        $sql = " SELECT ifnull(count(0), 0)n_answer FROM question_answers LEFT JOIN question_titles ON question_answers.questionaire_id = question_titles.id WHERE question_titles.topic_id = ".$_POST['topic_id']." AND question_answers.user_id = ".$user_id;
        $n_answer = $this -> db -> query($sql)->result();
        $n_answer = @$n_answer[0]->n_answer;                      

        $uqr = new User_question_result;
        $uqr -> where('user_id', $user_id);
        $uqr -> where('topic_id', $topic_id) -> get();
        $uqr -> user_id = $uqr -> user_id > 0 ? $uqr -> user_id : $user_id;
        $uqr -> topic_id = $_POST['topic_id'];
        $uqr -> status = 3;
        $uqr -> create_date = $uqr -> create_date > 0 ? $uqr -> create_date : date("Y-m-d H:i:s");
        $uqr -> update_date = date("Y-m-d H:i:s");
        $uqr -> n_user_answer = $n_answer;
        $uqr -> save();
		
		$sql = "UPDATE user_question_result
		SET 
		n_user_answer = (select count(*) from question_answers inner join question_titles on question_answers.questionaire_id = question_titles.id  where question_answers.user_id = user_question_result.user_id and question_titles.topic_id = user_question_result.topic_id),
		n_user_score = (
			SELECT
				ifnull(
					sum(`question_choices`.`score`),
					0
				)
			FROM
				(
					(
						`question_choices`
						JOIN `question_answers` ON (
							(
								`question_choices`.`id` = `question_answers`.`choice_id`
							)
						)
					)
					LEFT JOIN `question_titles` ON (
						(
							`question_answers`.`questionaire_id` = `question_titles`.`id`
						)
					)
				)
		WHERE `question_answers`.`user_id` = user_question_result.user_id AND `question_titles`.`topic_id` = user_question_result.topic_id					
		)
		WHERE user_id = ".$user_id." and topic_id = ".$topic_id;		
		$this->db->query($sql);
       
        $sql = "
            SELECT
                qr.*,
                question_topics.orderlist,
                (
                        SELECT
                            `user_question_result`.`create_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `create_date`,
                (
                        SELECT
                            `user_question_result`.`update_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `update_date`,
                (
                        SELECT
                            ifnull(
                                sum(`question_choices`.`score`),
                                0
                            )
                        FROM
                            (
                                (
                                    `question_choices`
                                    JOIN `question_answers` ON (
                                        (
                                            `question_choices`.`id` = `question_answers`.`choice_id`
                                        )
                                    )
                                )
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `score`,
                (
                        SELECT
                            ifnull(count(0), 0)
                        FROM
                            (
                                `question_answers`
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                                AND (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                            )
                    ) AS `n_answer`
                FROM
                (
                SELECT
                    `users`.`id` AS `user_id`,
                    `users`.`name` AS `name`,
                    `qt`.`id` AS `topic_id`,
                    `qt`.`title` AS `title`,
                    `qt`.`set_final` AS `set_final`,
                    `qt`.`status` AS `topic_status`,
                    `qt`.`pass` AS `pass`,
                  `qt`.`random` AS `n_question` 
                FROM
                    (
                        `users`
                        JOIN `question_topics` `qt`
                    )
                WHERE 
                users.id = " . $user_id . "
                )qr
                left join question_topics on qr.topic_id = question_topics.id     
        ";
        $sql .= " WHERE topic_id = " . $topic_id . " AND topic_status = 'approve' ORDER BY orderlist ";
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
                qr.*,
                question_topics.orderlist,
                (
                        SELECT
                            `user_question_result`.`create_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `create_date`,
                (
                        SELECT
                            `user_question_result`.`update_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `update_date`,
                (
                        SELECT
                            ifnull(
                                sum(`question_choices`.`score`),
                                0
                            )
                        FROM
                            (
                                (
                                    `question_choices`
                                    JOIN `question_answers` ON (
                                        (
                                            `question_choices`.`id` = `question_answers`.`choice_id`
                                        )
                                    )
                                )
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `score`,
                (
                        SELECT
                            ifnull(count(0), 0)
                        FROM
                            (
                                `question_answers`
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                                AND (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                            )
                    ) AS `n_answer`
                FROM
                (
                SELECT
                    `users`.`id` AS `user_id`,
                    `users`.`name` AS `name`,
                    `qt`.`id` AS `topic_id`,
                    `qt`.`title` AS `title`,
                    `qt`.`set_final` AS `set_final`,
                    `qt`.`status` AS `topic_status`,
                    `qt`.`pass` AS `pass`,
                  `qt`.`random` AS `n_question` 
                FROM
                    (
                        `users`
                        JOIN `question_topics` `qt`
                    )
                WHERE 
                users.id = " . $user_id . "
                )qr
                left join question_topics on qr.topic_id = question_topics.id     
        ";
        $sql .= " WHERE topic_id = " . $topic_id . " AND topic_status = 'approve' ORDER BY orderlist ";
        $data['topic'] = $this -> db -> query($sql) -> row();
        $this -> load -> view('ajax_show_result', $data);
    }

    function ajax_show_question($topic_id) {
        $user_id = $this -> session -> userdata('id');
        $data = '';
        $sql = "
            SELECT
                qr.*,
                question_topics.orderlist,
                (
                        SELECT
                            `user_question_result`.`create_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `create_date`,
                (
                        SELECT
                            `user_question_result`.`update_date`
                        FROM
                            `user_question_result`
                        WHERE
                            (
                                (
                                    `user_question_result`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `update_date`,
                (
                        SELECT
                            ifnull(
                                sum(`question_choices`.`score`),
                                0
                            )
                        FROM
                            (
                                (
                                    `question_choices`
                                    JOIN `question_answers` ON (
                                        (
                                            `question_choices`.`id` = `question_answers`.`choice_id`
                                        )
                                    )
                                )
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                                AND (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                            )
                    ) AS `score`,
                (
                        SELECT
                            ifnull(count(0), 0)
                        FROM
                            (
                                `question_answers`
                                LEFT JOIN `question_titles` ON (
                                    (
                                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                                    )
                                )
                            )
                        WHERE
                            (
                                (
                                    `question_titles`.`topic_id` = `qr`.`topic_id`
                                )
                                AND (
                                    `question_answers`.`user_id` = `qr`.`user_id`
                                )
                            )
                    ) AS `n_answer`
                FROM
                (
                SELECT
                    `users`.`id` AS `user_id`,
                    `users`.`name` AS `name`,
                    `qt`.`id` AS `topic_id`,
                    `qt`.`title` AS `title`,
                    `qt`.`set_final` AS `set_final`,
                    `qt`.`status` AS `topic_status`,
                    `qt`.`pass` AS `pass`,
                  `qt`.`random` AS `n_question` 
                FROM
                    (
                        `users`
                        JOIN `question_topics` `qt`
                    )
                WHERE 
                users.id = " . $user_id . "
                )qr
                left join question_topics on qr.topic_id = question_topics.id     
        ";
        $sql .= " WHERE topic_id = " . $topic_id . " AND topic_status = 'approve' ORDER BY orderlist ";
        $data['topic'] = $this -> db -> query($sql) -> row();
        $ext_condition = '';
        if ($data['topic'] -> set_final == 1) {
            $ext_category = '';
            $sql = "select 
			q_cat.id
			,q_cat.`name`
			,q_cat.random n_question
			,(select count(*) from question_answers qa 
				inner join question_titles qt on qa.questionaire_id = qt.id 
				where 
				qt.topic_id = " . $topic_id . " 
				and qa.user_id = " . $user_id . " 
				and qt.question_category_id = q_cat.id
				)n_answer
			FROM question_categories q_cat
			";
            $result = $this -> db -> query($sql) -> result();
            foreach ($result as $row) {
                if ($row -> n_question > $row -> n_answer) {
                    $ext_category .= $ext_category != '' ? "," . $row -> id : $row -> id;
                }
            }
            $ext_condition = $ext_category != '' ? " AND question_category_id IN (" . $ext_category . ") " : "";
        }
        $ext_condition .= " AND id NOT IN (SELECT questionaire_id FROM question_answers WHERE user_id = " . $user_id . ")";
        $sql = "SELECT * from question_titles WHERE topic_id = " . $topic_id . $ext_condition . " ORDER BY RAND() LIMIT 1 ";
        $data['question'] = $this -> db -> query($sql) -> row();
        $data['answers'] = $this -> db -> query("select * from question_choices WHERE questionaire_id = " . $data['question'] -> id . " ORDER BY RAND() ") -> result();
        $this -> load -> view('ajax_testing', $data);
    }

    function cert() {
        if (is_login()) {
            $user_id = $this -> session -> userdata('id');
            $pass_final_status = get_pass_final_status($user_id);
            if ($pass_final_status == TRUE) {
                $user_id = $this -> session -> userdata('id');
                $data['user'] = new User($user_id);

                $sql = "SELECT
    `users`.`id` AS `user_id`,
    `users`.`name` AS `name`,
    `qt`.`id` AS `topic_id`,
    `qt`.`title` AS `topic_title`,
    `qt`.`set_final` AS `set_final`,
    `qt`.`status` AS `topic_status`,    
    (
        SELECT
            `user_question_result`.`update_date`
        FROM
            `user_question_result`
        WHERE
            (
                (
                    `user_question_result`.`user_id` = `users`.`id`
                )
                AND (
                    `user_question_result`.`topic_id` = `qt`.`id`
                )
            )
    ) AS `update_date`,
    `qt`.`pass` AS `pass`    
FROM
    (
        (SELECT * FROM `users` WHERE id = " . $user_id . ")as users
        JOIN `question_topics` `qt`
    )
WHERE 
set_final = 1    
ORDER BY
    `users`.`id`,
    `qt`.`orderlist`";

                $data['questionresult'] = $this -> db -> query($sql) -> result();
                $this -> load -> view('admin/certs/diploma', $data);
            } else {
                set_notify('error', 'ขออภัยคุณยังไม่ผ่านแบบทดสอบหลังเรียน');
                redirect('pages/view/1');
            }
        } else {
            set_notify('error', 'กรุณาล้อกอินเข้าสู่ระบบ');
            redirect('pages/view/1');
        }
    }

}
?>