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
$db->debug = true;

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
				
				$handle = curl_init($link);
				curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
				
				/* Get the HTML or whatever is linked in $url. */
				$response = curl_exec($handle);
				
				/* Check for 500 (file not found). */
				$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
				if($httpCode != 500) {
				    
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
					$data['price'] = $sticker_code > 999999 ? 30 : 60 ;
					$data['url'] = $link;
		    		
					$data['url'];
		            $db->AutoExecute('stickers',$data,'INSERT');
		            print "<br>".++$url." $link insert";
		            unset($html);
		            unset($data);
				
				}
				
				curl_close($handle);
	    }
	}
	else
	{
	    print('<br>no data updated');
	}
}


/*------------------------function--------------------------*/
function get_link()
{
    global $db;
	
	if($_GET['type'] == ""){ $_GET['type'] = "Creation"; }
	if($_GET['p'] == ""){ $_GET['p'] = "0"; }
	
	$request = array(
	'http' => array(
	    'method' => 'POST',
	    'content' => http_build_query(array(
	        'type' => $_GET['type'],
	        'p' => $_GET['p']
	    )),
	)
	);
	
	$context = stream_context_create($request);

    $html = file_get_html('http://wish.cat2.me/stklist.php', false, $context);

    $result = json_decode($html);
	
	// echo "<pre>";
	// echo print_r($result->Data);
	// echo "</pre>";
	
	
	// echo "ffffffff  ".$result->Data[0]->Pkg[0];
	
    foreach($result->Data as $key => $data)
    {
    	// echo $data;
        
		$sticker_code = $data->Pkg;
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