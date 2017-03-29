<!-- <style type="text/css">
.child {text-align:center;}
.child img{margin:10px 0;}
</style>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ศูนย์เด็กเล็กปลอดโรค</li>
</ul>
<div id="data" class="child">
    
    <?php if(user_login()->m_status == 'active'):?>
    	
	    <?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7 or user_login()->user_type_id == 8):?>
			<a href="nurseries/register"><img src="themes/hps/images/child_register.jpg" width="520" height="75"></a>
			
			<a href="nurseries/estimate/0"><img src="themes/hps/images/child_estimate.jpg" width="520" height="75"></a>
		<?php endif;?>
		
	    <?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7):?>
	        <a href="officers"><img src="themes/hps/images/banner6.jpg" width="520" height="75"></a>
	    <?php endif;?>
	    
	    <?php if(user_login()->user_type_id == 9): //เจ้าหน้าที่ศูนย์ ?>
	    	<a href="teachers"><img src="themes/hps/images/banner7.jpg" width="520" height="75" alt="จัดการครู / ผู้ดูแลเด็ก"></a>
	    <?php endif;?>
	    
	    <?php if(user_login()->user_type_id == 10): //เจ้าหน้าที่ครู / ผู้ดูแลเด็ก ?>
	    	<a href="classrooms"><img src="themes/hps/images/banner8.jpg" width="520" height="75" alt="ห้องเรียน ชั้นเรียน และเด็ก"></a> <a href="diseases/form?nursery_id=<?=user_login()->nursery_id?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=date("m")?>&year=<?=date("Y")+543?>" target="_blank"><img src="themes/hps/images/banner10.jpg" width="520" height="75" alt="บันทึกผลแบบคัดกรองโรค"></a>
	    <?php endif;?>
	    
	<?php else:?>
    	สถานะ : <span style="color:orangered;">รอการตรวจสอบ</span>
    <?php endif;?>
    
</div> -->

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>ขอความร่วมมือในการทำแบบสอบถาม</h3>
  </div>
  <div class="modal-body">
  	<center>
    <h4 style="line-height: 30px;"><a href="http://thaigcd.ddc.moph.go.th/docs/publics/questionaire/67" target="_blank">- แบบสำรวจความพึงพอใจต่อการใช้บริการฐานข้อมูล ศูนย์เด็กเล็กโรงเรียนอนุบาลคุณภาพปลอดโรค ประจำปี พ.ศ. 2559</a></h4>
    </center>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
  </div>
</div>


<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>