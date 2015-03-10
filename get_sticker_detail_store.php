#!/usr/local/bin/php
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
include('application/helpers/MY_url_helper.php');
include('media/simpledom/simple_html_dom.php');
include('adodb/adodb.inc.php');
include('autopost/config.php');
$db = ADONewConnection($_config['dbdriver']);
$db->Connect($_config['server'],$_config['username'],$_config['password'],$_config['database']);
$db->Execute('SET character_set_results=utf8');
$db->Execute('SET collation_connection=utf8_unicode_ci');
$db->Execute('SET NAMES utf8');
// $db->debug = true;


if($_GET['code'] != ""){
	$sticker_code = $_GET['code'];
}else{
	// หาสติกเกอร์ที่ยังไม่มีรายละเอียดจาก db
	// $sticker_code = $db->GetOne('select sticker_code from stickers where sticker_code <= 2000000 AND category = "creator" AND status = "approve" AND (title_credit IS NULL OR title_credit = "") ORDER by RAND()');
	
	
	$condition = " category = 'creator' and status = 'approve' and (title_credit IS NULL OR title_credit = '') ";

	$max_id = $db->GetOne('select max(id) from stickers where '.$condition);
	$min_id = $db->GetOne('select min(id) from stickers where '.$condition);
	$current_id = $db->GetOne('select id from stickers where chk = 1 and '.$condition);
	$next_id = $db->GetOne('select id from stickers where id = (select min(id) from stickers where id > '.$current_id.' and '.$condition.')');
	
	echo 'max = '.$max_id.'<br>';
	echo 'min = '.$min_id.'<br>';
	echo 'current = '.$current_id.'<br>';
	echo 'next = '.$next_id.'<br>';
	
	$sticker_code = $db->GetOne('select sticker_code from stickers where chk = 1');
	
	if($max_id == $current_id){
		$db->Execute("UPDATE stickers SET chk = 1 WHERE id = ".$min_id);
		$db->Execute("UPDATE stickers SET chk = 0 WHERE id <> ".$min_id);
	}else{
		$db->Execute("UPDATE stickers SET chk = 1 WHERE id = ".$next_id);
		$db->Execute("UPDATE stickers SET chk = 0 WHERE id <> ".$next_id);
	}
	
}

echo "รหัส = ".$sticker_code;

if($sticker_code != ""){

$check = $db->GetOne('select id from stickers where sticker_code = ?',$sticker_code);
	if(!$check){
		$link = "https://store.line.me/stickershop/product/".$sticker_code."/th";
		$html = file_get_html($link);
		
		$data['title'] = trim($html->find('h2.mdMN05Ttl',0)->plaintext);
		
		if($data['title'] != ""){
			$data['title_credit'] = trim($html->find('p.mdMN05Copy',0)->plaintext);
			$data['slug'] = clean_url($data['title'].' by '.$data['title_credit']);
			$data['detail'] = trim($html->find('p.mdMN07Desc',0)->plaintext);
			$data['credit'] = trim($html->find('p.mdMN07Copy',0)->plaintext);
			$data['sticker_code'] = $sticker_code;
			$data['category'] = $data['sticker_code'] > 999999 ? 'creator' : 'global' ;
			
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_URL, 'http://dl.stickershop.line.naver.jp/products/0/0/1/'.$sticker_code.'/LINEStorePC/preview.png');
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// $res = curl_exec($ch);
			// $info = curl_getinfo($ch);
	// 		
			// if($info['http_code']==404){
				// $data['cover'] = "http://dl.stickershop.line.naver.jp/products/0/0/1/".$sticker_code."/android/main.png";
				// $data['preview'] = "http://dl.stickershop.line.naver.jp/products/0/0/1/".$sticker_code."/android/preview.png";
				// $data['chk'] = "1";
			// }else{
				$data['cover'] = "http://dl.stickershop.line.naver.jp/products/0/0/1/".$sticker_code."/LINEStorePC/main.png";
				$data['preview'] = "http://dl.stickershop.line.naver.jp/products/0/0/1/".$sticker_code."/LINEStorePC/preview.png";
				// $data['chk'] = "1";
			// }
				
			$data['created'] = time();
			$data['status'] = $data['category'] == "creator" ? 'approve' : 'draft' ;
			$data['price'] = $data['sticker_code'] > 999999 ? 30 : 60 ;
			$data['url'] = $link;
			
			if($sticker_code == ""){
				print "ไม่มีข้อมูล";
			}else{
				$db->AutoExecute('stickers',$data,'INSERT');
				print "<br>".++$key." $link insert";	
			}
		}
		
		unset($html);
		unset($data);
			
	}else{ // ถ้ามีข้อมูลแล้ว
		$link = "https://store.line.me/stickershop/product/".$sticker_code."/th";
		$html = file_get_html($link);
		
		$data['title'] = trim($html->find('h2.mdMN05Ttl',0)->plaintext);
		if($data['title'] != ""){
		
			if($sticker_code == ""){
				print "ไม่มีข้อมูล";
			}else{
				$record['title'] = trim($html->find('h2.mdMN05Ttl',0)->plaintext);
				$record['detail'] = trim($html->find('p.mdMN07Desc',0)->plaintext);
				$record['credit'] = trim($html->find('p.mdMN07Copy',0)->plaintext);
				$record['title_credit'] = trim($html->find('p.mdMN05Copy',0)->plaintext);
				$record['slug'] = clean_url($data['title'].' by '.$record['title_credit']);
				$data['price'] = $_GET['code'] > 999999 ? 30 : 60 ;
			    $db->AutoExecute('stickers',$record, 'UPDATE', 'id = '.$check); 
				print "<br>".++$key." $link update";	
			}
			
		}
		unset($html);
		unset($data);
		
		// echo "รหัส ".$_GET['code']." มีในระบบแล้ว";
	}
}

?>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	if(<?=@$_GET['auto']?> == "1"){
		var domain = "http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['SCRIPT_NAME']?>";
		
			setTimeout(function() {
			  window.location.href = domain+"?auto=1";
			}, 1000);
	}
});
</script>
