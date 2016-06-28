<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ประเมินผล</li>
</ul>

<h1>การประเมินผล <?=get_nursery_name($nursery_id);?></h1>

<!-- <div style="float:right; padding:10px 0;"><a href="assessments/form"><div class="btn btn-primary">ทำแบบประเมิน</div></a></div> -->

<table class="table table-striped table-bordered">
	<tr>
		<th class="span1">ลำดับ</td>
		<th>ปีที่ประเมิน</th>
		<th>สถานะการประเมิน</th>
		<th>รูปแบบการประเมิน</th>
		<th>ปีที่หมดอายุ</th>
	</tr>
	<?foreach($assessments as $key=>$assessment):?>
	<tr>
		<td><?=$key+1?></td>
		<td><?=$assessment->approve_year?></td>
		<td><?=get_assessment_status($assessment->status)?></td>
		<td><?=get_assessment_approve_type($assessment->approve_type,$assessment->approve_user_id,$assessment->total,$assessment->id)?></td>
		<td>
			<?
				if($assessment->status == 1){ // ถ้าผ่านเกณฑ์
					echo ($assessment->approve_year)+2;
					echo ' <a href="nurseries/cert/index/'.$assessment->id.'" target="_blank" style="color:teal"><i class="fa fa-print" aria-hidden="true" style="color:orange;" title="พิมพ์ใบประกาศ"></i></a>';
				}
			?>
		</td>
	</tr>
	<?endforeach;?>
</table>