<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="nurseries">ศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li><a href="nurseries/register">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">คำนำหน้า</li>
</ul>
<form id="frmnursery" class="form-inline" method="post" action="nurseries/category_save/<?=$category->id?>">
    <div id="data">
        <fieldset style="border:1px dashed #ccc; padding:10px;">
        <legend style="padding:0 5px; font-size:14px; font-weight:700; color:#666;">ประเภทศูนย์เด็กเล็ก</legend>
			ประเภทศูนย์เด็กเล็ก<span class="TxtRed">*</span>
			<input type="text" name="title" value="<?=$category->title?>"/>
			<input class="btn" type="submit" value=" บันทึก "/>
          </fieldset>
	</div>
</form>

<div id="data">
	<table class="table">
    <tr>
        <th>ประเภทศูนย์เด็กเล็ก</th>
        <th width="100">จัดการ</th>
    </tr>
    <?php foreach($categories as $row):?>
    	<tr>
	        <td><?=$row->title?></td>
	        <td width="100">
	        	<a href="nurseries/category_form/<?=$row->id?>" class="btn btn-mini">แก้ไข</a>
	        	<a href="nurseries/category_delete/<?=$row->id?>" class="btn btn-mini" onclick="return(confirm('ยืนยันการลบข้อมูล'))" >ลบ</a>
	        </td>
        </tr>
    <?php endforeach;?>
    </table>
</div>