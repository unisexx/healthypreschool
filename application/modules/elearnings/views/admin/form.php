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
    
    // $(".command .left input[type=button]").click(function(){
		// $('.dummy .box.' + $(this).attr('name')).clone().appendTo('#form-body .form-inner ul');
	// })
	
	$(".command input[type=button]").click(function(){
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
<h1>E-learning</h1>
<form action="elearnings/admin/elearnings/save/<?php echo $topic->id ?>" method="post">
<!-- <div class="command">
	<div class="left">
		<input type="button" value="Text" name="text" />
		<input type="button" value="Paragraph Text" name="textarea" />
		<input type="button" value="Multiple choice" name="radio" />
		<input type="button" value="Checkboxes" name="checkbox" />
		<input type="button" value="Scale" name="scale" />
		<input type="button" value="Grid" name="grid" />
		<input type="button" value="เพิ่มหัวข้อคำถาม" name="radio" />
		<select name="status">
			<option value="draft" <?php echo ($topic->status=='draft')?'selected="selected"':'' ?>>ปิด</option>
			<option value="approve" <?php echo ($topic->status=='approve')?'selected="selected"':'' ?>>เปิด</option>
		</select>
	</div>
	<div class="right">
		<input type="button" value="Full Screen" name="fullscreen" />
		<input type="submit" value="บันทึก" />
	</div>
	<div class="clear"></div>
</div> -->
<div id="form-body" style="overflow:auto;" >
	<div class="form-inner">
		<p><label><strong>หัวข้อแบบทดสอบ</strong></label><br /><input type="text" name="title" class="full" value="<?php echo $topic->title ?>" /></p>
		<p><label><strong>คำชี้แจง</strong></label><br /><textarea name="detail" class="full"><?php echo $topic->detail ?></textarea></p>
		
		<?if($topic->set_final == 1):?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('button[name=CategoryAdd]').click(function(){
					alert('add');
				});
			});
		</script>
		<div style="border:1px solid #aaa; padding:10px;">
		  <h1>หมวดข้อสอบ</h1>
		  <div class="input-append">
			  <input class="span4" id="appendedInputButton" type="text" name="topic_category">
			  <button class="btn" type="button" value="เพิ่มหมวด" name="CategoryAdd">เพิ่มหมวด</button>
		  </div>
		  <table class="table table-bordered">
		  	<tr>
		  		<th>ชื่อหมวด</th>
		  		<th>สุ่มจำนวน (ข้อ)</th>
		  		<th>มีอยู่ในระบบ (ข้อ)</th>
		  	</tr>
		  </table>
		</div>
		<?endif;?>
		  
		<hr>
		<p><label><strong>คะแนนที่ผ่านการทดสอบ</strong></label><input type="number" name="pass" value="<?=$topic->pass?>"> คะแนน</p>
		<p><label><strong>สุ่มหัวข้อแบบทดสอบ</strong></label><input type="number" name="random" value="<?=$topic->random?>"> หัวข้อ</p>
		<hr>
		
		<div class="command">
			<input type="button" value="เพิ่มหัวข้อคำถาม" name="radio" />
		</div>
		
		<ul id="sortable">
			<?php foreach($topic->questionaire->order_by('sequence')->get() as $question): ?>
			<?php question_form($question) ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<div class="right" style="margin-top: 10px;">
	<input class="btn btn-primary" type="submit" value="บันทึก" />
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
				<tr><th>หัวข้อคำถาม</th><td><input type="text" name="question[]" class="full" value="" /><input type="button" value="เพิ่มคำตอบ" name="add" /> <!-- <input type="checkbox" name="other" value="1" /> อื่นๆ โปรดระบุ --></td></tr>
				<tr>
					<th></th>
					<td>
						<input type="radio" name="radio[]" /> 
						<input type="text" class="half" name="choice" value="" />
						<input type="number" class="half4x" name="score" value="">
						 <a rel="remove_choice" href="#"><i class="fa fa-times"></i></a>
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

<!-- <style>
.command{background-color: #0080c0; color: #ffffff;}
</style> -->