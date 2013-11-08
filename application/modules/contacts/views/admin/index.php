<h1>ติดต่อสอบถาม</h1>
<?php echo $contacts->pagination()?>
<table class="list">
	<tr>
		<th>หัวข้อ</th>
		<th>ชื่อ-นามสกุล</th>
		<th>อีเมล์</th>
		<th width="114"></th>
	</tr>
	<?php foreach($contacts as $contact): ?>
	<tr <?php echo cycle()?>>
		<td><?php echo $contact->title ?></td>
		<td><?php echo $contact->name ?></td>
		<td><?php echo $contact->email ?></td>
		<td>
			<a class="btn" href="contacts/admin/contacts/form/<?php echo $contact->id?>" >รายละเอียด</a> 
			<?php if(permission('contacts', 'delete')):?>
			<a class="btn" href="contacts/admin/contacts/delete/<?php echo $contact->id?>" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
			<?php endif;?>
		</td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php echo $contacts->pagination()?>