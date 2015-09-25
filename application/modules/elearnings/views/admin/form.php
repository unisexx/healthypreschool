<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){
	var menu = 202;
	$( "#sortable" ).sortable({
			placeholder: "placeholder",
			axis: "y",
			start: function (event, ui) {
    ui.placeholder.height(ui.helper.height()+33);
}

		});
	 $("#form-body").css('height',$(window).height()-menu);
    $(window).resize(function(){
        var h = $(window).height();
        var w = $(window).width();
        $("#form-body").css('height',h-menu);
    });
	
	$(".command .left input[type=button]").click(function(){
		$('.dummy .box.' + $(this).attr('name')).clone().appendTo('#form-body .form-inner ul');
	})
	
	$(".command .right input[type=button]").toggle(function(){
		$(this).val('Disable Full Screen');
		$('#menu').hide();
		menu = 50;
		 $("#form-body").css('height',$(window).height()-menu);
	},function(){
		$(this).val('Full Screen');
		$('#menu').show();
		menu = 202;
		 $("#form-body").css('height',$(window).height()-menu);
	})
	
	$(".option a").live('click',function(){
		if($(this).attr('rel')=="bin")
		{
			if ($(this).parent().parent().find('input[name=question_id[]]').val()) 
			{
				if (confirm('คุณต้องการลบคำถามข้อนี้ ?')) 
				{
					var parent = $(this).parent().parent();
					$.post('docs/delete_question',{'id':$(this).parent().parent().find('input[name=question_id[]]').val()},function(data){
						$.jnotify('ลบคำถาม	เรียบร้อยแล้วค่ะ',{
							type: 'success',
							delay: 2000
						});
						parent.remove();
					})
				}
			}
			else 
			{
				$(this).parent().parent().remove();
			}
		}
		else if($(this).attr('rel')=="copy")
		{
			var clone = $(this).parent().parent().clone();
			clone.find('input[name=question_id[]]').val('');
			clone.find('input[name=choice_id]').val('');
			clone.find('a[rel=del_choice]').attr('rel','remove_choice');
			clone.find('select').val($(this).parent().parent().find('select').val());
			clone.find('select[name=min]').val($(this).parent().parent().find('select[name=min]').val());
			clone.find('select[name=max]').val($(this).parent().parent().find('select[name=max]').val());
			clone.css('backgroundColor','#b0ffb0').animate({backgroundColor: "#FFFFFF"},3000);
			clone.insertAfter($(this).parent().parent());
		}
		return false;
	})
	
	$(".radio input[name=add]").live('click',function(){
		
	$(this).parent().parent().parent().append('<tr><th></th><td><input type="radio" name="radio[]" /> <input type="text" class="half" name="choice" value="" /> <input type="number" class="half4x" name="score" value="" /> <a rel="remove_choice" href=#"><i class="fa fa-times"></i></a><input type="hidden" name="choice_id" value="" /></td></tr>');
	});
	
	$(".checkbox input[name=add]").live('click',function(){
	$(this).parent().parent().parent().append('<tr><th></th><td><input type="checkbox" name="checkbox" /> <input type="text" class="half" name="choice" value="" /> <a rel="remove_choice" href="#"><span class="icon icon-delete"></span></a><input type="hidden" name="choice_id" value="" /></td></tr>');
	});
	
	//-- submit form --
	$("input[type=submit]").click(function(){
		$("#form-body .form-inner input[name=choice]").each(function(){
			$(this).attr('name','choice['+ $('#form-body .form-inner .box').index($(this).closest('.box')) +'][]');
		})
		
		$("#form-body .form-inner input[name=score]").each(function(){
			$(this).attr('name','score['+ $('#form-body .form-inner .box').index($(this).closest('.box')) +'][]');
		})
		
		$("#form-body .form-inner input[name=other]").each(function(){
			$(this).attr('name','other['+ $('#form-body .form-inner .box').index($(this).closest('.box')) +']');
		})
		
		$("#form-body .form-inner input[name=choice_id]").each(function(){
			$(this).attr('name','choice_id['+ $('#form-body .form-inner .box').index($(this).closest('.box')) +'][]');
		})
		$("#form-body .form-inner select[name=min],#form-body .form-inner select[name=max],#form-body .form-inner select[name=range]").each(function(){
			$(this).attr('name',$(this).attr('name') + '[' + $('#form-body .form-inner .box').index($(this).closest('.box')) +']');
		})
		
		$("#form-body .form-inner input[name=optional]").each(function(){
			$(this).attr('name',$(this).attr('name') + '[' + $('#form-body .form-inner .box').index($(this).closest('.box')) +'][]');
		})
		
		// return false;
	})
	
	$(".scale select[name=min]").live('change',function(){
		$(this).parent().parent().next().find('span').text($(this).val());
	});
	
	$(".scale select[name=max]").live('change',function(){
		$(this).parent().parent().next().next().find('span').text($(this).val());
	});
	
	$(".grid select[name=range]").live('change',function(){
		//var current = $(this).closest('.box').find('td[rel=range] input').size()+1;
		$(this).closest('.box').find('td[rel=range]').html('');
		$(this).find('option[value=' + $(this).val() + ']').attr('selected','selected').siblings().attr('selected','');
		var value = parseInt($(this).val());
		var i = 0;
		var radio ='';
		for(i=value;i>=1;i--)
		{
			$(this).closest('.box').find('td[rel=range]').append('<input type="text" class="num" name="optional" value="' + i +'" /> ');
			radio += '<input type="radio" class="num" />';
		}
		$(this).closest('.box').find('td[rel=range]').parent().siblings().find('td').html(radio);
	});
	
	$(".grid input[name=add]").live('click',function(){
		var value = parseInt($(this).closest('.box').find('select[name=range]').val());
		var radio ='';
		for(i=1;i<=value;i++)
		{
			radio += '<input type="radio" class="num" />';
		}
		
	$(this).closest('.box').find('td[rel=range]').parent().parent().append('<tr>' +
							'<th><input type="text" name="choice" class="full" value="" /><input type="hidden" name="choice_id" value="" /> <a rel="remove_choice" href="#"><span class="icon icon-delete"></span></a></th>' +
							'<td>' +
							radio +
							'</td>' +
						'</tr></td></tr>');
	});
	
	$(".form-inner a[rel=remove_choice]").live('click',function(){
		$(this).parent().parent().remove();
		return false;
	});
	
	$(".form-inner a[rel=del_choice]").live('click',function(){
		if (confirm('คุณต้องการลบคำตอบข้อนี้ ?')) {
			var url = $(this).attr('href');
			var parent = $(this).parent().parent();
			$.post(url, function(){
				parent.remove();
				$.jnotify('ลบคำตอบเรียบร้อยแล้วค่ะ',{
					type: 'success',
					delay: 2000
				});
			})
		}
		return false;
	});
	
});

</script>
<form action="elearnings/admin/elearnings/save/<?php echo $topic->id ?>" method="post">
<div class="command">
	<div class="left">
		<!-- <input type="button" value="Text" name="text" />
		<input type="button" value="Paragraph Text" name="textarea" />
		<input type="button" value="Multiple choice" name="radio" />
		<input type="button" value="Checkboxes" name="checkbox" />
		<input type="button" value="Scale" name="scale" />
		<input type="button" value="Grid" name="grid" /> -->
		<input type="button" value="เพิ่มหัวข้อคำถาม" name="radio" />
		<select name="status">
			<option value="draft" <?php echo ($topic->status=='draft')?'selected="selected"':'' ?>>ปิด</option>
			<option value="approve" <?php echo ($topic->status=='approve')?'selected="selected"':'' ?>>เปิด</option>
		</select>
	</div>
	<div class="right">
		<!-- <input type="button" value="Full Screen" name="fullscreen" /> -->
		<input type="submit" value="บันทึก" />
	</div>
	<div class="clear"></div>
</div>
<div id="form-body" style="overflow:auto;" >
	<div class="form-inner">
		<p><label><strong>หัวข้อแบบทดสอบ</strong></label><br /><input type="text" name="title" class="full" value="<?php echo $topic->title ?>" /></p>
		<p><label><strong>คำชี้แจง</strong></label><br /><textarea name="detail" class="full"><?php echo $topic->detail ?></textarea></p>
		<p><label><strong>คะแนนที่ผ่านการทดสอบ</strong></label><input type="number" name="pass" value="<?=$topic->pass?>"> คะแนน</p>
		<p><label><strong>สุ่มหัวข้อแบบทดสอบ</strong></label><input type="number" name="random" value="<?=$topic->random?>"> หัวข้อ</p>
		<hr>
		<ul id="sortable">
			<?php foreach($topic->questionaire->order_by('sequence')->get() as $question): ?>
			<?php question_form($question) ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
</form>

<ul class="dummy" style="display:none;">
	<li class="box text">
		<div class="option">
			<a rel="bin" href="#"><span class="icon icon-bin"></span> <a rel="copy" href="#"><span class="icon icon-page-copy"></span></a>
		</div>
		<table width="100%">
			<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /></td></tr>
			<tr><th></th><td><input type="text" class="disable" value="คำตอบ" disabled="disabled" /></td></tr>
		</table>
		<input type="hidden" name="type[]" value="text" />
		<input type="hidden" name="question_id[]" value="" />
	</li>
	
	<li class="box textarea">
		<div class="option">
			<a rel="bin" href="#"><span class="icon icon-bin"></span> <a rel="copy" href="#"><span class="icon icon-page-copy"></span></a>
		</div>
		<table width="100%">
			<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /></td></tr>
			<tr><th></th><td><textarea class="disable" disabled="disabled" >คำตอบ</textarea></td></tr>
		</table>
		<input type="hidden" name="type[]" value="textarea" />
		<input type="hidden" name="question_id[]" value="" />
	</li>
	
	<li class="box radio">
			<div class="option">
				<a rel="bin" href="#"><span class="icon icon-bin"></span> <a rel="copy" href="#"><span class="icon icon-page-copy"></span></a>
			</div>
			<table width="100%">
				<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /><input type="button" value="เพิ่มคำตอบ" name="add" /> <input type="checkbox" name="other" value="1" /> อื่นๆ โปรดระบุ </td></tr>
				<tr>
					<th></th>
					<td>
						<input type="radio" name="radio[]" /> 
						<input type="text" class="half" name="choice" value="" />
						 <a rel="remove_choice" href="#"><span class="icon icon-delete"></span></a>
						<input type="hidden" name="choice_id" value="" />
					</td>
				</tr>
				
					
			</table>
			<input type="hidden" name="type[]" value="radio" />
			<input type="hidden" name="question_id[]" value="" />
		</li>
		
		<li class="box checkbox">
			<div class="option">
				<a rel="bin" href="#"><span class="icon icon-bin"></span> <a rel="copy" href="#"><span class="icon icon-page-copy"></span></a>
			</div>
			<table width="100%">
				<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /><input type="button" value="เพิ่มคำตอบ" name="add" /> <input type="checkbox" name="other" value="1" /> อื่นๆ โปรดระบุ </td></tr>
				<tr>
					<th></th>
					<td>
						<input type="checkbox" name="checkbox[]" /> 
						<input type="text" class="half" name="choice" value="" />
						 <a rel="remove_choice" href="#"><span class="icon icon-delete"></span></a>
						<input type="hidden" name="choice_id" value="" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="type[]" value="checkbox" />
			<input type="hidden" name="question_id[]" value="" />
		</li>
		
		<li class="box scale">
			<div class="option">
				<a rel="bin" href="#"><span class="icon icon-bin"></span> <a rel="copy" href="#"><span class="icon icon-page-copy"></span></a>
			</div>
			<table width="100%">
				<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /></td></tr>
				<tr>
					<th>ระดับ</th>
					<td>
						<select name="min">
    						<option value="0" >0</option>
    						<option value="1" >1</option>
  						</select>
						ถึง
						<select name="max">
    						<option value="3" >3</option>
							<option value="4" >4</option>
    						<option value="5" >5</option>
							<option value="6" >6</option>
							<option value="7" >7</option>
							<option value="8" >8</option>
							<option value="9" >9</option>
							<option value="10" >10</option>
  						</select>
					</td>
				</tr>
				<tr><th></th><td><span>0</span> : <input type="text" class="half" name="optional" value="" /></td></tr>
				<tr><th></th><td><span>3</span> : <input type="text" class="half" name="optional" value="" /></td></tr>
			</table>
			<input type="hidden" name="type[]" value="scale" />
			<input type="hidden" name="question_id[]" value="" />
		</li>
		
		<li class="box grid">
			<div class="option">
				<a rel="bin" href="#"><span class="icon icon-bin"></span> <a rel="copy" href="#"><span class="icon icon-page-copy"></span></a>
			</div>
			<table width="100%">
				<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /><input type="button" value="เพิ่มแถว" name="add" /></td></tr>
				<tr>
					<th>จำนวนคอลัมน์</th>
					<td>
						<select name="range">
    						<option value="1" >1</option>
							<option value="2" >2</option>
    						<option value="3" selected="selected">3</option>
							<option value="4" >4</option>
							<option value="5" >5</option>
  						</select>
					</td>
				</tr>
					<th></th>
					<td>
						<table width="100%">
						<tr>
							<th>แถว\คอลัมน์</th>
							<td rel="range">
								<input type="text" class="num" name="optional" value="3" />
								<input type="text" class="num" name="optional" value="2" />
								<input type="text" class="num" name="optional" value="1" />
							</td>
						</tr>
						<tr>
							<th><input type="text" name="choice" class="full" value="" /><input type="hidden" name="choice_id" value="" /> <a rel="remove_choice" href="#"><span class="icon icon-delete"></span></a></th>
							<td>
								<input type="radio" class="num" /><input type="radio" class="num" /><input type="radio" class="num" />
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
			<input type="hidden" name="type[]" value="grid" />
			<input type="hidden" name="question_id[]" value="" />
		</li>
</ul>




<style>
a{color: #0080ff; text-decoration:none;}


.left {float:left;}
.right {float:right;}


.clear { clear:both; }

#headtxt {border-bottom:1px solid #CCC; padding:5px;}
#headtxt p {text-align:center; font-size:16px; font-weight:700; margin-bottom:5px;}

#food { border-bottom:1px solid #CCC; padding:5px;}
#remark { border-bottom:1px solid #CCC; padding:5px 10px; font-size:13px; font-weight:700; color:#C00; background-color:#FFF}
#remark p {margin-bottom:5px;}
.toggle{display:block; width:16px; height:16px; background:url(../images/toggle.png) bottom left no-repeat;}
.active .toggle{display:block; width:16px; height:16px; background:url(../images/toggle.png) top left no-repeat;}
.report h2{position:relative;}
.report h2 .toggle{position:absolute; right:5px; top:5px;}

/* ^^^^^^^^ BELOW IS THE CODE FOR THE MENU ^^^^^^^^^^ */
ul#saturday{margin:0;padding:0;list-style-type:none;width:auto;position:relative;display:block;height:36px;text-transform:uppercase;font-size:14px;font-weight:bold;background:transparent url("../images/bgOFF.gif") repeat-x top left;font-family:Helvetica,Arial,Verdana,sans-serif;border-bottom:4px solid #233979;border-top:1px solid #b3d6ee;}
ul#saturday li{display:block;float:left;margin:0;padding:0;}
ul#saturday li a{display:block;float:left;color:#466887;text-decoration:none;padding:12px 20px 0 20px;height:36px;background:transparent url("../images/bgDIVIDER.gif") no-repeat top right;}
ul#saturday li a:hover,ul#saturday li.active a{background:transparent url("../images/bgHOVER.gif") no-repeat top right;}
ul#saturday li a.current,ul#saturday li a.current:hover{color:#fff;background:transparent url("../images/bgON.gif") no-repeat top right;}
/* ^^^^^^^^ ABOVE IS THE CODE FOR THE MENU ^^^^^^^^^^ */

/*#container{
	padding:5px 10px 0;
}
#content{
	padding:10px;
	border:1px solid #cacaca;
	border-top:none;
	background:#fff;
}
#content h3{line-height:22px;}*/

.search{
	text-align:center;
	border-top:1px solid #CCC;
	border-bottom:1px solid #CCC;
	background:#EFEFEF;
	padding:5px 0;
	margin:0 0 15px;
}
.search label{font-weight:bold;}
ol, ul {
    list-style: none;
}
ol{ list-style-position:inside; list-style-type:decimal;}
ol li{padding:0 0 5px;}
ul li{padding:0 0 5px;}
.list{line-height:16px;}
.list label,.form label{font-weight:bold;}
.full{width:99%;}
#form-body {
    background-color: #FFFFFF;
    border: 1px solid #AAAAAA;
}
#form-body p{padding:0 0 10px;}
.form-inner{padding:10px;}
.form-inner h2{font-size:14px; text-decoration:underline;}
.form-inner .detail{text-indent:15px; line-height:20px;}
.command{background:#AAA; padding:3px;}
.command h1{font-size:16px; margin:5px; padding:0;}
#form-body .box .full{width:70%;}
#form-body .box {padding:20px 10px 20px; border-bottom:1px solid #CCC;}
#form-body .box table th{width:120px; font-weight:bold; text-align:left; color:#000;}
#form-body .box{position:relative;}
#form-body .box:hover{background:#E8F3F9;}
#form-body .box .option{position:absolute; top:10px; right:10px; display:none;}
#form-body .box:hover .option{position:absolute; top:10px; right:10px; display:block;}
#form-body .box .disable {
    border: 1px dashed #999999;
    color: #000000;
	width:200px;
	padding:5px;
}
#form-body .box .half{width:60%;}
#form-body .box .half4x{width:7%;}
#form-body .box.scale .num{width:50px; text-align:center;}
#form-body .box.grid .num{width:50px; text-align:center;}
#form-body .box.grid table table th{width:400px;}
#form-body .box.grid table table th .full{width:85%;}
#form-body .box table th,#form-body .box table td,#form-body .q table th,#form-body .q table td {
    padding: 0.3em 12px 0.3em 0;
    text-align: left;
    vertical-align: middle;
}
#form-body .q {padding:20px 0;border-bottom:1px solid #CCC;}
#form-body .q table th{width:50px; font-weight:bold; text-align:left; color:#000;}
#form-body .q.scale .num{width:50px; text-align:center;}
#form-body .q.scale table table td{border:1px solid #CCC; border-left:none; border-right:none; text-align:center; padding:5px;}
#form-body .q.grid table table tr.odd td{background:#FAFAFA;}
#form-body .q.grid table table td{border:1px solid #CCC; text-align:center; padding:5px;}
.placeholder{border:1px dashed #00ff00; background:#dfffdf; margin:5px 0;}
.box h2{
	padding:5px 10px;
	font-size:16px;
	color: #233979;
	border: 1px solid #C1DAD7;
	text-align: left;
	background: #E2F1FA;
	margin:0 0 1px 0;
	cursor:pointer;
}
.child {padding:0 0 10px;}
.box.grid .child table {width:800px;}
.child table{width:500px; margin:0 auto;}
.child table td,.child table th{border:1px solid #CCC; text-align:center; padding:5px;}
.child table th{background:#EEE;}
.child table tr.odd td{background:#FAFAFA;}
.child table tfoot td{background:#ceffce;}
.child table .num{width:60px; text-align:center;}

.thankyou{
	padding:50px 10px;
	font-size:16px;
	color: #233979;
	border: 1px solid #C1DAD7;
	text-align: center;
	background: #E2F1FA;
	margin:10px;
	cursor:pointer;
}

.group_ddl{width:150px;}

select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{
	margin-bottom:0px !important;
}

.fa-times{color:#d14;}

</style>