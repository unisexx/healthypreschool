<table class="table">
    <tr>
        <th>ลำดับ</th>
        <th>ชื่อ - นามสกุล</th>
        <th>ประเภทผู้ทดสอบ</th>
        <th>หน่วยงาน</th>
        <th>จังหวัด</th>
        <th>อำเภอ</th>
        <th>ตำบล</th>
        <th>สถานะ</th>
        <th>วันที่ทดสอบ</th>
    </tr>
    <?php
        $no=0; 
        foreach($result as $item):
        $no++;
    ?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo $item->name;?></td>
        <td><?php echo $item->user_type_name;?></td>
        <td><?php echo $item->nursery_name;?></td>
        <td><?php echo $item->province_name;?></td>
        <td><?php echo $item->amphur_name;?></td>
        <td><?php echo $item->district_name;?></td>
        <td>
            <?php echo $status = $item->n_user_score >= $item->pass ? '<span class="label label-success">ผ่าน</span>' : '<span class="label label-important">ไม่ผ่าน</span>';?>
        </td>
        <th><?php echo mysql_to_th($item->update_date,'s',TRUE);?></th>
    </tr>
    <?php endforeach;?>
</table>

