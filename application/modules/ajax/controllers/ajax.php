<?php
Class Ajax extends Public_Controller
{
function get_province(){
		$area_id = @$_POST['area_id']!=''? $_POST['area_id'] : @$_GET['area_id'];
        $mode = @$_POST['mode']!='' ? $_POST['mode'] : '';
		get_province_dropdown($area_id,'',$mode);
	}

function get_amphur(){
		$province_id = @$_POST['province_id']!=''? $_POST['province_id'] : @$_GET['province_id'];
        $mode = @$_POST['mode']!='' ? $_POST['mode'] : '';
		get_amphur_dropdown(@$province_id,'',$mode);
	}

function get_district(){
		$amphur_id = @$_POST['amphur_id']!=''? $_POST['amphur_id'] : @$_GET['amphur_id'];
        $mode = @$_POST['mode']!='' ? $_POST['mode'] : '';
		get_district_dropdown(@$amphur_id,'',$mode);
	}

function get_nursery(){
	if(isset($_GET['district_id']) && ($_GET['district_id']!="")){
		echo @form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.@$_GET['district_id'].' order by name asc'),@$_GET['nursery_id'],'id="nursery"','--- เลือกศูนย์เด็กเล็ก ---');
	}else{
		echo form_dropdown('nursery_id',array(''=>'--- เลือกศูนย์เด็กเล็ก ---'),'','id="nursery" class="span4" disabled');
	}
}

function get_classroom(){
	if(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
		echo @form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.@$_GET['nursery_id'].' order by room_name asc'),@$_GET['classroom_id'],'id="classroom"','--- เลือกห้องเรียน ---');
	}else{
		echo form_dropdown('nursery_id',array(''=>'--- เลือกห้องเรียน ---'),'','id="classroom" class="span4" disabled');
	}
}

function show_province(){
	if($_POST){
		$sql = "SELECT
						v_provinces.name
					FROM
						v_provinces
					WHERE
						v_provinces.area_id = ".$_POST['area_id'];
					
		$rs = $this->db->query($sql)->result();
		// var_dump($rs);
		echo "<div style='border:1px dashed #F44336;padding:10px;width:247px;'>";
		echo "<b>ครอบคลุมพื้นที่จังหวัด</b><br>";
		foreach($rs as $row){
			echo "- ".$row->name."<br>";
		}
		echo "</div>";
	}
}

function save_nurseries($id=false){
    if($_POST){
        $captcha = $this->session->userdata('captcha');
        if(($_POST['captcha'] == $captcha) && !empty($captcha)){

            if(@$id == ""){
                $nuchk = new Nursery();
                $nuchk = $nuchk->where('name like "%'.$_POST['name'].'%" and district_id = '.$_POST['district_id'])->get()->result_count();
                if($nuchk > 0){
                    set_notify('error', 'ชื่อศูนย์เด็กเล็กนี้มีแล้วค่ะ');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            
            $area_province = new Area_Province();
            $area_province->where("province_id = ".$_POST['province_id']);
            $area_province->get();
            $_POST['area_province_id'] = $area_province->area_province_id;

            $_POST['user_id'] = $this->session->userdata('id'); // ไอดีเจ้าหน้าที่ที่แอด nursery
            //$_POST['area_id'] = login_data('nursery');
            $nursery = new Nursery(@$id);
            $nursery->from_array($_POST);
            
            $nursery->save();
            $nursery->select_max('id');
            $nursery->get();
            $id = $nursery->id;
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
            echo $id;
        }else{
            set_notify('error','กรอกรหัสไม่ถูกต้อง');
            echo 'false';
        }        
    }
}

function get_other_disease_detail(){
	if($_GET){
		$sql = "SELECT other, count(*) AS count
					FROM diseases d
					INNER JOIN nurseries AS n ON d.nursery_id = n.id
					INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
					INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
					INNER JOIN area_provinces ON n.area_province_id = area_provinces.area_province_id
					WHERE
						1 = 1
					AND d.c1 = 'O'
					".$_GET['condition']."
					GROUP BY other
					ORDER BY other ASC";
		
		$query = $this->db->query($sql);
		echo "<table class='table table-striped table-bordered'>";
		echo "<tr><th>โรค</th><th>จำนวน</th></tr>";
		foreach($query->result() as $row){
			echo"<tr>";
			echo"<td>".$row->other."</td><td>".$row->count."</td>";
			echo"</tr>";
		}
		echo "</table>";
	}
}

function check_children_name()
{
	$rs = new Children();
	$rs = $rs->where('name = "'.$_GET['name'].'"')->get()->result_count();
	echo ($rs > 0)?"false":"true";
}

function ajax_get_teacher_detail(){
	if($_GET){
		$rs = new User($_GET['id']);
		echo '<tr><td>'.$rs->name.'</td><td>'.$rs->sex.'</td><td>'.$rs->position.'</td><td>'.$rs->phone.'</td><td>'.$rs->email.'</td><td><input type="hidden" name="teacherID[]" value="'.$rs->id.'"><button class="btn btn-mini btn-danger delButton">ลบ</button></td></tr>';
	}
}

// ประเมินผลโดยเจ้าหน้าที่
function officerAssessmentSubmit(){
	if($_GET){
		// หาข้อมูลใน db ถ้ามีให้อัพเดท ถ้าไม่มีให้ insert
		$a1 = new Assessment();
		$a1->where('nursery_id = '.$_GET['nursery_id']);
		$a1->where('approve_year = '.$_GET['approve_year'])->get(1);
		//echo $assessment->id;
		
		$a2 = new Assessment($a1->id);
		$_GET['approve_date'] = date("Y-m-d H:i:s");
		$a2->from_array($_GET);
	    $a2->save();	
		
		$assessment = new Assessment();
		$assessment->where('nursery_id = '.$_GET['nursery_id'])->order_by('approve_year','asc')->get();
		foreach($assessment as $key=>$row){
			echo "<tr>";
			echo "<td>".($key+1)."</td>";
			echo "<td>".$row->approve_year."</td>";
			echo "<td>".get_assessment_status($row->status)."</td>";
			echo "<td>".get_assessment_approve_type_2($row->status,$row->approve_type,$row->approve_user_id,$row->total,$row->id,'nurseries/estimate_form/'.$_GET['nursery_id'].'/'.$row->id)."</td>";
			echo "<td>";
				if($row->status == 1){ // ถ้าผ่านเกณฑ์
					echo (($row->approve_year)+2);
				}
			echo "</td>";
			echo "</tr>";
		}
		
		/*** อัพเดท status ของ approve_year ล่าสุด ที่ table nursery ***/
		update_last_assessment_status($_GET['nursery_id']);
	}
}

}
?>
