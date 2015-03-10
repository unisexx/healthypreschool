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

print_r(get_link());

$links = get_link();
if($links)
{
	$newarray = implode(", ", $links);
	$sticker_code_from_db = $db->Execute("SELECT sticker_code from stickers where sticker_code in (".$newarray.",1000011)");
	foreach($sticker_code_from_db as $row){
		$arrFromDB[] = $row[0];
	}
	$result = array_diff($links, $arrFromDB);
	
	if(!empty($result)){
	    foreach ($result as $key => $sticker_code){
			$url = "https://store.line.me/stickershop/product/".$sticker_code."/th";
			$html = file_get_html($url);
			$data['title'] = trim($html->find('h2.mdMN05Ttl',0)->plaintext);
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
			
			if($data['title'] == ""){
				print "ไม่มีข้อมูล";
			}else{
				$db->AutoExecute('stickers',$data,'INSERT');
				print "<br>".++$url." $link insert";	
			}
			unset($html);
			unset($data);
		}
	}
	else
	{
	    print('<br>no data updated');
	}
}
else
{
    print('<br>no data updated');
}

/*------------------------function--------------------------*/
function get_link()
{
    global $db;
    $html = file_get_html('https://store.line.me/stickershop/showcase/new_creators/th?page='.$_GET['p']);
    foreach($html->find('.mdMN02Li') as $key => $data)
    {
        if($key == 0 )$next = $data->find('a',0)->href;
        if (!preg_match("/^\//", $data->href)) 
        {
            $url = $data->find('a',0)->href;
			$ex = explode("/", $url);
			$sticker_code = intval($ex[3]);
             if(!$check)
             {
                 $feed[] =  $sticker_code;
             }
             else
             {
                 if(isset($feed))
                 {
                     sort($feed);
                     return $feed;
                 }
                 else
                 {
                     return false;
                 }
             }
                
        } 
    }
    if(isset($feed))
    {
        sort($feed);
        return $feed;
    }
    else
    {
        return false;
    }
}
?>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	if(<?=@$_GET['auto']?> == "1"){
		var page = "<?=$_GET['p']-1?>";
		var domain = "http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['SCRIPT_NAME']?>";
		
		if(page != -1){
			setTimeout(function() {
			  window.location.href = domain+"?auto=1&p="+page;
			}, 1000);
		}
	}
});
</script>