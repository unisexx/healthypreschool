<script type="text/javascript">
$(document).ready(function(){
    $("select[name='area_id']").live("change",function(){
  		$.post('ajax/get_province',{
  				'area_id' : $(this).val()
  			},function(data){
  				$("#province").html(data);
  			});

  			$('select[name=amphur_id] option:first-child,select[name=district_id] option:first-child').attr("selected", "selected").attr("disabled", "disabled");
			$('select[name=amphur_id],select[name=district_id]').attr("disabled", "disabled");
  	});
  	$("select[name='province_id']").live("change",function(){
  		$.post('ajax/get_amphur',{
  				'province_id' : $(this).val()
  			},function(data){
  				$("#amphur").html(data);
  			});

  			$('select[name=district_id] option:first-child').attr("selected", "selected").attr("disabled", "disabled");
			$('select[name=district_id]').attr("disabled", "disabled");
  	});

  	$("select[name='amphur_id']").live("change",function(){
  		$.post('ajax/get_district',{
  				'amphur_id' : $(this).val()
  			},function(data){
  				$("#district").html(data);
  			});
  	});
  	
  	// ถ้าเป็นเจ้าหน้าที่อำเภอ ให้ disable สคร และ จังหวัด
	if(<?=user_login()->user_type_id;?> == 8){
		$("select[name=area_id],select[name=province_id]").attr("disabled", true);
	}
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">เจ้าหน้าที่ศูนย์เด็กเล็ก</li>
</ul>

<form method="get" action="staffs">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('user_type_id',array('9'=>'เจ้าหน้าที่ศูนย์','10'=>'เจ้าหน้าที่ครู / ผู้ดูแลเด็ก'),@$_GET['user_type_id'],'','--- เลือกเจ้าหน้าที่ ---');?>
	<input type="text" name="name" value="<?=@$_GET['name']?>" placeholder="ค้นหาชื่อ, อีเมล์">
	<input type="text" name="nursery_name" value="<?=@$_GET['nursery_name']?>" placeholder="ค้นหาศูนย์เด็กเล็ก">
	
	<?php get_area_dropdown(@$_GET['area_id']);?>
	<span id="province">
	<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
	</span>
	<span id="amphur">
	<?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
	</span>
	<span id="district">
	<?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
	</span>
	
	  <input type="hidden" name="search" value="1">
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
      <img class="loading" style="display: none;" src="media/images/ajax-loader.gif">
	</div>
</form>




<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>





<div style="margin-bottom: 10px;">
	พบเจ้าหน้าที่ทั้งหมด <span class="badge badge-success"><?=$count['total'];?></span>
</div>
    	
<!-- <div style="float: right; margin-bottom:5px;">
	<a class="btn btn-mini btn-info" href="staff/form">เพิ่มเจ้าหน้าที่ศูนย์</a> | <a class="btn btn-mini btn-info" href="#">เพิ่มเจ้าหน้าที่ครู</a>
</div> -->
<table class="table">
    <tr>
        <th>ลำดับ</th>
        <th>สถานะเจ้าหน้าที่</th>
        <th>อีเมล์</th>
        <th>ชื่อ - นามสกุล</th>
        <th>เจ้าหน้าที่ศูนย์เด็กเล็ก</th>
        <th>ที่อยู่</th>
        <!-- <th>อำเภอ</th>
        <th>ตำบล</th> -->
        <th>วันที่สมัคร</th>
        <th width="90">
        	<!-- <a class="btn btn-mini btn-info" href="staffs/adform">เพิ่มเจ้าหน้าที่</a> -->
        </th>
    </tr>
    <?php foreach($users as $key=>$user):?>
        <tr>
             <td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
            <td><?=($user->user_type_id == 9)? 'เจ้าหน้าที่ศูนย์' : 'เจ้าหน้าที่ครู / ผู้ดูแลเด็ก' ;?></td>
            <td><?=$user->email?></td>
            <td><?=$user->name?></td>
            <td>
            	<?=$user->nursery_name?>
            	<ul>
	        		<li>
	        			<a href="childrens?nursery_id=<?=$user->nursery_id?>" target="_blank">รายชื่อเด็ก/นักเรียน</a>
	        			<!-- <a href="childrens/list_guest/<?=$user->nursery_id?>" target="_blank">รายชื่อเด็ก/นักเรียน</a> -->
	        			<?
	        				$rs = $this->db->query("SELECT COUNT(id) total FROM classroom_details where nursery_id = ".$user->nursery_id)->row_array();
							echo '<span style="color:#666666;">('.$rs['total'].')</span>';
	        			?>
	        		</li>
	        		<li>
	        			<a href="classrooms?nursery_id=<?=$user->nursery_id?>" target="_blank">รายชื่อห้องเรียน</a>
	        			<!-- <a href="classrooms/list_guest/<?=$user->nursery_id?>" target="_blank">รายชื่อห้องเรียน</a> -->
	        			<?
	        				$rs = $this->db->query("SELECT COUNT(id) total FROM classrooms where nursery_id = ".$user->nursery_id)->row_array();
							echo '<span style="color:#666666;">('.$rs['total'].')</span>';
	        			?>
	        		</li>
	        		<li>
	        			<a href="teachers?nursery_id=<?=$user->nursery_id?>" target="_blank">รายชื่อครู/เจ้าหน้าที่</a>
	        			<!-- <a href="teachers/list_guest/<?=$user->nursery_id?>" target="_blank">รายชื่อครู/เจ้าหน้าที่</a> -->
	        			<?
	        				// $rs = $this->db->query("SELECT COUNT(id) total FROM users where user_type_id = 10 and nursery_id = ".$user->nursery_id)->row_array();
							$rs = $this->db->query("SELECT
																count(classroom_teachers.id) total
																FROM
																classrooms
																INNER JOIN classroom_teachers ON classrooms.id = classroom_teachers.classroom_id
																WHERE
																classrooms.nursery_id = ".$user->nursery_id)->row_array();
							echo '<span style="color:#666666;">('.$rs['total'].')</span>';
	        			?>
	        		</li>
	        		<li><a href="diseases/list_guest/<?=$user->nursery_id?>" target="_blank">บันทึกแบบคัดกรองโรค</a></li>
	        		<li><a href="diseases/report_guest?nursery_id=<?=$user->nursery_id?>" target="_blank">รายงานแบบคัดกรองโรค</a></li>
	        		<li><a href="assessments/preview/<?=$user->nursery_id?>" target="_blank">รายงานแบบประเมินสมัครเข้าร่วมโครงการ</a></li>
	        	</ul>
            </td>
            <td>จ.<?=$user->province_name?><br>อ.<?=$user->amphur_name?><br>ต.<?=$user->district_name?></td>
            <td><?=mysql_to_th($user->created)?></td>
            <td>
            	<!-- <a class="btn btn-mini" href="staffs/form/<?=$user->nursery_id?>">เพิ่มเจ้าหน้าที่ครู</a> -->
                <a class="btn btn-mini" href="staffs/form/<?=$user->nursery_id?>/<?=$user->id?>">แก้ไข</a>
                <a class="btn btn-mini" href="staffs/delete/<?=$user->id?>" style="width:27px;" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?=$pagination;?>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="height: 500px;">
    <div>&nbsp;<img class="loader" src="media/images/ajax-loader.gif"></div>
    <div class="modal-body-form"></div>
  </div>
</div>




<?endif;?>
