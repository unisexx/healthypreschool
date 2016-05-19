<?php
class Reports extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('blank');
	}
	
	// รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค
	function nursery_register(){
		$this->template->build('nursery_register');
	}

	// กราฟแสดงเกณฑ์อ้างอิงการเจริญเติบโต (น้ำหนัก)
	function children_weight(){
		$data['text'] = "กราฟแสดงเกณฑ์อ้างอิงการเจริญเติบโต (น้ำหนัก)";

		if(isset($_GET['classroom_id']) && ($_GET['classroom_id']!="")){
			$data['rs'] = new Classroom();
			$data['rs']->where('id = ',$_GET['classroom_id'])->order_by('room_name','asc')->get();
		}elseif(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
			$data['rs'] = new Classroom();
			$data['rs']->where('nursery_id = ',$_GET['nursery_id'])->order_by('room_name','asc')->get();
		}elseif(isset($_GET['district_id']) && ($_GET['district_id']!="")){
			$data['rs'] = new Nursery();
			$data['rs']->where('district_id = ',$_GET['district_id'])->order_by('name','asc')->get();
		}elseif(isset($_GET['amphur_id']) && ($_GET['amphur_id']!="")){
			$data['rs'] = new District();
			$data['rs']->where('amphur_id = ',$_GET['amphur_id'])->order_by('district_name','asc')->get();
		}elseif(isset($_GET['province_id']) && ($_GET['province_id']!="")){
			$data['rs'] = new Amphur();
			$data['rs']->where('province_id = '.$_GET['province_id'])->order_by('amphur_name','asc')->get();
		}elseif(isset($_GET['area_id']) && ($_GET['area_id']!="")){
			$data['rs'] = new Province();
			$data['rs']->where('area_id = '.$_GET['area_id'])->order_by('name','asc')->get();
		}else{
			$data['rs'] = new Area();
			$data['rs']->order_by('id','asc')->get();
		}

		$this->template->build('children_weight',$data);
	}

	// รายงานข้อมูลแบบคัดกรองโรค -- ภาพรวม --
	function desease_overall(){
		if(@$_GET['export_type']!=''){
			$this->load->view('desease_overall');
		}else{
			$this->template->build('desease_overall');
		}
	}

	function desease_overall_export(){
		$this->load->view('desease_overall_export');
	}

	// รายงานข้อมูลแบบคัดกรองโรค -- จำแนกตามปัจจัยต่างๆ --
	function desease_factor(){
		if(@$_GET['export_type']!=''){
			if(@$_GET['export_type']=='excel'){
                $filename= "รายงานจำนวนและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค_".date("Y-m-d_H_i_s").".xls";
                header("Content-Disposition: attachment; filename=".$filename);
            }
			$this->load->view('desease_factor');
		}else{
			$this->template->build('desease_factor');
		}
	}

	function desease_watch_number(){
		$data = '';
        if(@$_GET['export_type']!=''){
            if(@$_GET['export_type']=='excel'){
                $filename= "รายงานข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ_".date("Y-m-d_H_i_s").".xls";
                header("Content-Disposition: attachment; filename=".$filename);
            }
            $this->load->view('desease_watch_number',$data);
        }else{
            $this->template->build('desease_watch_number',$data);    
        }
		
	}
    function desease_watch_number_table_year(){
        $data = '';        
        $this->load->view('desease_watch_number_table_year',$data);
    }
    function desease_watch_number_table_month_year(){
        $data = '';
        $this->load->view('desease_watch_number_table_month_year',$data);
    }
    function desease_watch_number_table_time(){
        $data = '';
        $this->load->view('desease_watch_number_table_time',$data);
    }
    function desease_watch_number_table_default(){
        $data = '';
        $this->load->view('desease_watch_number_table_default',$data);
    }

    function desease_watch_symptom(){
        
        $start_date = @$_GET['start_date']!='' ? @$_GET['start_date'] : '';
        $end_date = @$_GET['end_date']!='' ? @$_GET['end_date'] : '';
        if($start_date!='' && $end_date != ''){
            $time_condition = " AND date(start_date) BETWEEN '".Date2DB($start_date)."' AND '".Date2DB($end_date)."' ";
        }else if($start_date!='' && $end_date==''){
            $time_condition = " AND date(start_date) >= '".Date2DB($start_date)."' ";
        }else if($start_date=='' && $end_date!=''){
            $time_condition = " AND date(start_date) <= '".Date2DB($start_date)."' ";
        }else{
            $time_condition = '';
        } 
        $data['time_condition'] = $time_condition;
        
        $list_condition = "";
        $list_condition.= @$_GET['desease']!='' ? " AND desease = ".$_GET['desease'] : '';
        $list_condition.= @$_GET['place_type']!='' ? " AND place_type = ".$_GET['place_type'] : '';
        $list_condition.= $time_condition;
        $data['list_condition'] = $list_condition;
        if(@$_GET['export_type']!=''){
            if(@$_GET['export_type']=='excel'){
                $filename= "รายงานกลุ่มอาการป่วยจากข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ".date("Y-m-d_H_i_s").".xls";
                header("Content-Disposition: attachment; filename=".$filename);
            }
            $this->load->view('desease_watch_symptom',$data);
        }else{
            $this->template->build('desease_watch_symptom',$data);    
        }
    }

    function desease_watch_symptom_table_default(){
        $data = '';
        $this->load->view('desease_watch_symptom_table_default',$data);
    }
    
    function elearning_result(){
        $start_date = @$_GET['start_date']!='' ? @$_GET['start_date'] : '';
        $end_date = @$_GET['end_date']!='' ? @$_GET['end_date'] : '';
        if($start_date!='' && $end_date != ''){
            $time_condition = " AND date(start_date) BETWEEN '".Date2DB($start_date)."' AND '".Date2DB($end_date)."' ";
        }else if($start_date!='' && $end_date==''){
            $time_condition = " AND date(start_date) >= '".Date2DB($start_date)."' ";
        }else if($start_date=='' && $end_date!=''){
            $time_condition = " AND date(start_date) <= '".Date2DB($start_date)."' ";
        }else{
            $time_condition = '';
        } 
        $data['time_condition'] = $time_condition;
        
        $list_condition = "";
        //$list_condition.= @$_GET['desease']!='' ? " AND desease = ".$_GET['desease'] : '';
        //$list_condition.= @$_GET['place_type']!='' ? " AND place_type = ".$_GET['place_type'] : '';
        //$list_condition.= $time_condition;
        //$data['list_condition'] = $list_condition;
        if(@$_GET['export_type']!=''){
            if(@$_GET['export_type']=='excel'){
                $filename= "รายงานผลการทดสอบ E-Learning ศูนย์เด็กเล็กและโรงเรียนอนุบาลคุณภาพปลอดโรค".date("Y-m-d_H_i_s").".xls";
                header("Content-Disposition: attachment; filename=".$filename);
            }
            $this->load->view('elearning',$data);
        }else{
            $this->template->build('elearning',$data);    
        }
    }

    function elearning_table_default(){
        $data = '';
        $this->load->view('elearning_table_default',$data);
    }
    
    function ajax_user_exam_list(){
    $start_date = @$_GET['start_date']!='' ? @$_GET['start_date'] : '';
    $end_date = @$_GET['end_date']!='' ? @$_GET['end_date'] : '';
    
    $list_condition = " WHERE 1=1 ";
    $list_condition.= @$_GET['user_type']!='' ? ' AND user_type_id = '.$_GET['user_type'] : ''; 
    $list_condition.= @$_GET['area_id']!='' ? " AND v_users.area_id = ".$_GET['area_id'] : '';       
    $list_condition.= @$_GET['province_id']!='' ? " AND v_users.province_id = ".@$_GET['province_id'] : '';
    $list_condition.= @$_GET['amphur_id']!=''  ? " AND v_users.amphur_id = ".@$_GET['amphur_id'] : '';
    $list_condition.= @$_GET['district_id']!='' ? " AND v_users.district_id = ".@$_GET['district_id'] : '';
    $list_condition.= @$_GET['nursery_id']!='' ? " AND v_users.nursery_id = ".@$_GET['nursery_id'] : '';
    
    $time_condition = '';
    switch (@$_GET['range_type']) {
        case 'year':
            $start_year = @$_GET['report_end_year']!='' ? @$_GET['report_end_year'] : date("Y");
            $end_year =   @$_GET['report_start_year']!='' ? @$_GET['report_start_year'] : $start_year-5;
            $time_condition = " AND (year(update_date) between ".$end_year." AND ".$start_year.")";
            
            break;
        case'month_year':
        break; 
        default:
            if($start_date!='' && $end_date != ''){
                $time_condition = " AND date(update_date) BETWEEN '".Date2DB($start_date)."' AND '".Date2DB($end_date)."' ";
            }else if($start_date!='' && $end_date==''){
                $time_condition = " AND date(update_date) >= '".Date2DB($start_date)."' ";
            }else if($start_date=='' && $end_date!=''){
                $time_condition = " AND date(update_date) <= '".Date2DB($start_date)."' ";
            }else{
                $time_condition = '';
            }
            break;
    }
    $list_condition.= $time_condition;
        
        
        $sql = '
            select 
            user_exam.*,
            v_users.name,
            v_users.user_type_id,
            v_users.area_id,
            v_users.province_id,
            v_users.amphur_id,
            v_users.district_id,
            v_users.nursery_id,
            provinces.name province_name,
            amphures.amphur_name,
            districts.district_name,
            nurseries.`name` nursery_name,
            user_types.`name` user_type_name
            from(
            select 
            uqr.*, qt.pass
            from user_question_result uqr
            left join question_topics qt on uqr.topic_id = qt.id
            WHERE
            set_final = 1
            )user_exam
            left join v_users on user_exam.user_id = v_users.id
            left join provinces on province_id = provinces.id
            left join amphures on v_users.amphur_id = amphures.id
            left join districts on v_users.district_id = districts.id
            left join nurseries on v_users.nursery_id = nurseries.id
            left join user_types on v_users.user_type_id = user_types.id       
        ';
        $sql=$sql.$list_condition;
        //echo $sql;
        $data['result'] = $this->db->query($sql)->result();
        $this->load->view('ajax_exam_user',$data);
    }
}
?>
