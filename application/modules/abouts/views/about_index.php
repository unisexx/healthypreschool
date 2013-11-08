<style>
.aboutus h1{background:#ddd; padding:2px 10px;}
.aboutus .about-blk{margin-bottom: 30px;}
.aboutus .detail{padding:0 10px;}
</style>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">เกี่ยวกับองค์กร</li>
</ul>

<div class="aboutus">
	<div class="about-blk">
		<h1>ทำเนียบผู้บริหาร</h1>
		<table class="table">
	    	<tr>
	    		<th>รูป</th>
	    		<th>เบอร์ติดต่อ</th>
	    	</tr>
	    	<?php foreach($seats as $row):?>
	    	<tr>
	    		<td>
	    			<?=thumb("uploads/content/".$row->image,110,135,1,'style="margin:0 10px 0 0;" class="img-polaroid"')?>
	    			<div><b><?=$row->title?></b></div>
	    			<div>ตำแหน่ง <?=$row->position?></div>
	    		</td>
	    		<td>
	    			<table class="table pdetail">
	    				<tr>
	    					<th>โทรศัพท์</th>
	    					<td><?=$row->tel?></td>
	    				</tr>
	    				<tr>
	    					<th>มือถือ</th>
	    					<td><?=$row->mobile?></td>
	    				</tr>
	    				<tr>
	    					<th>โทรสาร</th>
	    					<td><?=$row->fax?></td>
	    				</tr>
	    				<tr>
	    					<th>อีเมล์</th>
	    					<td><?=$row->email?></td>
	    				</tr>
	    				<tr>
	    					<th>สถานที่ปฏิบัติงาน</th>
	    					<td><?=$row->location?></td>
	    				</tr>
	    			</table>
	    		</td>
	    	</tr>
			<?php endforeach;?>
	    </table>
	</div>
	<?php foreach($abouts as $row):?>
		<div class="about-blk">
			<h1><?php echo $row->title?></h1>
			<div class="detail">
				<?php echo $row->detail?>
				
				<?php
					$attachs = new Attach();
		        	$attachs->where("module = 'abouts' and content_id = ".$row->id)->order_by('id','asc')->get();
				?>
				<?php if($attachs->result_count() > 0):?>
			        <div class="attach">
			            <h2>เอกสารแนบ</h2>
			            <?php foreach($attachs as $row):?>
			                <a href="contents/download/<?=$row->id?>"><span class="btn btn-mini"><i class="icon-file"></i> <?=$row->file_name?></span></a>
			            <?php endforeach;?>
			        </div>
			    <?php endif;?>
		    </div>
	    </div>
	<?php endforeach;?>
</div>
