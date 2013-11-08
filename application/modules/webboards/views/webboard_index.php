<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">เว็บบอร์ด</li>
</ul>

<div id="webboardpage">
	<h1 class="green">
		<span>เว็บบอร์ด</span>
		<div class="corner_left"></div>
		<div class="corner_right"></div>
	</h1>
	<div id="data">
		<table class="tbwebboard table">
			<tbody>
				<?php foreach($categories as $category): ?>
				 <tr>
                  <td><img src="media/images/webboard/ico_folder.png" height="32" width="32" style="max-width:32px; height:32px;"></td>
                  <td><a href="webboards/category/<?php echo $category->id?>" class="topicpost"><?php echo $category->name?></a><br><?php echo $category->description;?></td>
                  <td width="10%"><?php echo $category->webboard_quiz->result_count()?> กระทู้<br><?php echo $category->webboard_answer->result_count() ?> ตอบ</td>
                  <td width="25%">กระทู้ล่าสุด <br><span class="f10"><?php echo mysql_to_th($category->webboard_quiz->order_by("id", "desc")->limit(1)->get()->created,'S',TRUE)?></span>
                    <?php if($category->webboard_quiz->user->id): ?>                                       
                                                            โดย <a href="users/profile/<?php echo $category->webboard_quiz->user->id?>" class="name"><?php echo $category->webboard_quiz->user->display?></a>
                    <?php else: ?>
                                                            โดย <a href="javascript:;" class="name"><?php echo $category->webboard_quiz->author?></a>
                    <?php endif; ?>
                  </td>
                </tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>