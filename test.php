#!/usr/local/bin/php
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style>
	table,table tr,table tr td{border:1px solid #000;}
	table tr{display:block !important;}
	table tr td:first-child{width: 50px !important;}
	table tr td:nth-child(2){width: 150px !important;}
	table tr td:nth-child(3){width: 300px !important;}
	table tr td:nth-child(4){width: 90px !important;}
	table tr td:nth-child(5){width: 100px !important;}
	table tr td:nth-child(6){width: 100px !important;}
	table tr td:nth-child(7){width: 100px !important;}
</style>

<form method="get" style="margin-bottom: 30px;">
<select name="province">
	<option value="" select="selected">-เลือกจังหวัด-</option>
	<option value="810000">กระบี่</option>
	<option value="100000">กรุงเทพมหานคร</option>
	<option value="710000">กาญจนบุรี</option>
	<option value="460000">กาฬสินธุ์</option>
	<option value="620000">กำแพงเพชร</option>
	<option value="400000">ขอนแก่น</option>
	<option value="220000">จันทบุรี</option>
	<option value="240000">ฉะเชิงเทรา</option>
	<option value="200000">ชลบุรี</option>
	<option value="180000">ชัยนาท</option>
	<option value="360000">ชัยภูมิ</option>
	<option value="860000">ชุมพร</option>
	<option value="570000">เชียงราย</option>
	<option value="500000">เชียงใหม่</option>
	<option value="920000">ตรัง</option>
	<option value="230000">ตราด</option>
	<option value="630000">ตาก</option>
	<option value="260000">นครนายก</option>
	<option value="730000">นครปฐม</option>
	<option value="480000">นครพนม</option>
	<option value="300000">นครราชสีมา</option>
	<option value="800000">นครศรีธรรมราช</option>
	<option value="600000">นครสวรรค์</option>
	<option value="120000">นนทบุรี</option>
	<option value="960000">นราธิวาส</option>
	<option value="550000">น่าน</option>
	<option value="380000">บึงกาฬ</option>
	<option value="310000">บุรีรัมย์</option>
	<option value="130000">ปทุมธานี</option>														
	<option value="770000">ประจวบคีรีขันธ์</option>														
	<option value="250000">ปราจีนบุรี</option>														
	<option value="940000">ปัตตานี</option>													
	<option value="140000">พระนครศรีอยุธยา</option>														
	<option value="560000">พะเยา</option>														
	<option value="820000">พังงา</option>														
	<option value="930000">พัทลุง</option>														
	<option value="660000">พิจิตร</option>														
	<option value="650000">พิษณุโลก</option>														
	<option value="760000">เพชรบุรี</option>														
	<option value="670000">เพชรบูรณ์</option>														
	<option value="540000">แพร่</option>														
	<option value="830000">ภูเก็ต</option>														
	<option value="440000">มหาสารคาม</option>														
	<option value="490000">มุกดาหาร</option>														
	<option value="580000">แม่ฮ่องสอน</option>														
	<option value="350000">ยโสธร</option>														
	<option value="950000">ยะลา</option>														
	<option value="450000">ร้อยเอ็ด</option>														
	<option value="850000">ระนอง</option>														
	<option value="210000">ระยอง</option>														
	<option value="700000">ราชบุรี</option>														
	<option value="160000">ลพบุรี</option>														
	<option value="520000">ลำปาง</option>														
	<option value="510000">ลำพูน</option>														
	<option value="420000">เลย</option>														
	<option value="330000">ศรีสะเกษ</option>														
	<option value="470000">สกลนคร</option>														
	<option value="900000">สงขลา</option>														
	<option value="910000">สตูล</option>														
	<option value="110000">สมุทรปราการ</option>														
	<option value="750000">สมุทรสงคราม</option>														
	<option value="740000">สมุทรสาคร</option>														
	<option value="270000">สระแก้ว</option>														
	<option value="190000">สระบุรี</option>														
	<option value="170000">สิงห์บุรี</option>														
	<option value="640000">สุโขทัย</option>														
	<option value="720000">สุพรรณบุรี</option>														
	<option value="840000">สุราษฎร์ธานี</option>														
	<option value="320000">สุรินทร์</option>														
	<option value="430000">หนองคาย</option>														
	<option value="390000">หนองบัวลำภู</option>														
	<option value="150000">อ่างทอง</option>														
	<option value="370000">อำนาจเจริญ</option>														
	<option value="410000">อุดรธานี</option>														
	<option value="530000">อุตรดิตถ์</option>														
	<option value="610000">อุทัยธานี</option>
	<option value="340000">อุบลราชธานี</option>
</select>
<input type="submit" value="ค้นหา">
</form>
						    
<?
	if(@$_GET['beginrec'] == ""){
		$_GET['beginrec'] = 1;
		$nextBeginRec = 51;
	}else{
		$nextBeginRec = $_GET['beginrec'] + 50;
		$prevBeginRec = $_GET['beginrec'] - 50;
	}
	
	if(@$_GET['endrec'] == ""){
		$_GET['endrec'] = 50;
		$nextEndRec = 100;
	}else{
		$nextEndRec = $_GET['endrec'] + 50;
		$prevEndRec = $_GET['endrec'] - 50;
	}
	
	if(@$_GET['grouppage'] == ""){
		$nextGroupPage = 2;
	}else{
		$nextGroupPage = $_GET['grouppage'] + 1;
		$prevGroupPage = $_GET['grouppage'] - 1;
	}
	
?>
<a href="test.php?province=<?=@$_GET['province']?>&beginrec=<?=@$prevBeginRec?>&endrec=<?=@$prevEndRec?>&grouppage=<?=@$prevGroupPage?>">ก่อนหน้า</a> | 
<a href="test.php?province=<?=@$_GET['province']?>&beginrec=<?=@$nextBeginRec?>&endrec=<?=@$nextEndRec?>&grouppage=<?=@$nextGroupPage?>">ถัดไป</a>
                      
<?php
ini_set('memory_limit', '-1');
include('application/helpers/MY_url_helper.php');
include('application/helpers/MY_language_helper.php');
include('media/simpledom/simple_html_dom.php');
include('adodb/adodb.inc.php');
include('autopost/config.php');
$db = ADONewConnection($_config['dbdriver']);
$db->Connect($_config['server'],$_config['username'],$_config['password'],$_config['database']);
$db->Execute('SET character_set_results=utf8');
$db->Execute('SET collation_connection=utf8_unicode_ci');
$db->Execute('SET NAMES utf8');
// $db->debug = true;

	
global $db;

$request = array(
	'http' => array(
	    'method' => 'POST',
	    'content' => http_build_query(array(
	        'announceType' => '15', // ประเภทประกาศ (ประกาศราคากลาง)
	        'moiId' => @$_GET['province'],  // รหัสจังหวัด
	        'beginrec' => @$_GET['beginrec'], // เรคคอร์ดเริ่มต้น
	        'endrec' => @$_GET['endrec'], // เรคคอร์ดสุดท้าย
	        'grouppage' => @$_GET['grouppage'], // pagination goup
	        'servlet' => 'FPRO9965Servlet',
	        'proc_id' => 'FPRO9965',
	        'processFlows' => 'Procure',
	        'proc_name' => 'Procure',
	        'homeflag' => 'S',
			'deptSubId' => '',
			'retmenu' => ''
	    )),
	)
);
	
	$context = stream_context_create($request);

    $html = file_get_html('http://process3.gprocurement.go.th/egp2procmainWeb/jsp/procsearch.sch', false, $context);
    
	// แสดงผลลัพธ์ทางหน้าจอ
	echo iconv("tis-620", "utf-8",$html->find('table', 7)->outertext);


	// วนทีละ record เพื่อ บันทึกลง database
	foreach($html->find('table', 7)->find('tr') as $key => $data){
		if($key > 0){ //ข้ามหัวตาราง
		
			// ตัวแปรสำหรับบันทึกลง database
			$rs['no'] = iconv("tis-620", "utf-8",trim($data->find('td',0)->plaintext)); // ลำดับ
			$rs['department'] = iconv("tis-620", "utf-8",trim($data->find('td',1)->plaintext)); // หน่วยงาน
			$rs['title'] = iconv("tis-620", "utf-8",trim($data->find('td',2)->innertext)); // เรื่อง
			$rs['date'] = iconv("tis-620", "utf-8",trim($data->find('td',3)->plaintext)); // วันที่ประกาศ
			$rs['price'] = iconv("tis-620", "utf-8",trim($data->find('td',4)->plaintext)); // ราคากลาง(บาท)
			$rs['status'] = iconv("tis-620", "utf-8",trim($data->find('td',5)->plaintext)); // สถานะโครงการ
			$rs['related'] = iconv("tis-620", "utf-8",trim($data->find('td',6)->innertext)); // ประกาศที่เกี่ยวข้อง
			
		}	
	}
?>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	if(<?=@$_GET['province']?> != ""){
		$( "select" ).val('<?=@$_GET['province']?>');
	}
});
</script>