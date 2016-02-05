<?php
Class Ajax extends Public_Controller
{
function get_province(){
		$area_id = @$_POST['area_id']!=''? $_POST['area_id'] : @$_GET['area_id'];
		get_province_dropdown($area_id,'');
	}

function get_amphur(){
		$province_id = @$_POST['province_id']!=''? $_POST['province_id'] : @$_GET['province_id'];
		get_amphur_dropdown(@$province_id,'');
	}

function get_district(){
		$amphur_id = @$_POST['amphur_id']!=''? $_POST['amphur_id'] : @$_GET['amphur_id'];
		get_district_dropdown(@$amphur_id,'');
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

}
?>
