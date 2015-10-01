<h1>หน้าเพจ</h1>
<div class="search">
	<form class="form-inline" method="get">
		<table class="form">
			<tr>
				<th>หัวข้อ</th><td><input type="text" name="search" value="<?php echo (isset($_GET['search']))?$_GET['search']:'' ?>" /></td>
				<td><input class="btn" type="submit" value="ค้นหา" /></td>
			</tr>
		</table>
	</form>
</div>
<?php echo $pages->pagination()?>
<table class="table table-striped">
	<tr>
		<th>หัวข้อ</th>
		<th>Url</th>
		<th>โดย</th>
		<th width="90"><a class="btn btn-mini btn-primary" href="pages/admin/pages/form" >เพิ่มรายการ</a></th>
	</tr>
	<?php foreach($pages as $page): ?>
	<tr <?php echo cycle()?>>
		<td><?php echo lang_decode($page->title,'th');?></td>
		<td><?php echo anchor(base_url().'pages/view/'.$page->id) ?></td>
		<td><?php echo $page->user->display?></td>
		<td>
			<a class="btn btn-mini" href="pages/admin/pages/form/<?php echo $page->id?>" >แก้ไข</a>
			<a class="btn btn-mini" href="pages/admin/pages/delete/<?php echo $page->id?>" >ลบ</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo $pages->pagination()?>