<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ผู้บริหาร</li>
</ul>

<div class="aboutus">
	<h1>ผู้บริหาร</h1>
	<div class="detail"><?php echo $data->detail?></div>
	<?php if($attachs->result_count() > 0):?>
        <div class="attach">
            <h2>เอกสารแนบ</h2>
            <?php foreach($attachs as $row):?>
                <a href="contents/download/<?=$row->id?>"><span class="btn btn-mini"><i class="icon-file"></i> <?=$row->file_name?></span></a>
            <?php endforeach;?>
        </div>
    <?php endif;?>
</div>