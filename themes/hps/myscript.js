$(document).ready(function(){
	var pathname = $(location).attr('href');
    var substr = pathname.split('/');
    //alert(substr[4]);
    if(substr[4] == "home"){
    	$('.main_content_blk').css("padding","0px");
    }
    
    $('[rel=tooltip]').tooltip();
});
