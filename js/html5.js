document.createElement('header');
document.createElement('footer');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('nav');
var jQ=jQuery;
jQ(function(){
	jQ('.postBtn').click(function(ev){
		var $pF=jQ(this).siblings('.postFunction');
		if($pF.css('display')=="none"){
			$pF.slideDown('fast');
			jQ(this).children('.postBtnArrow').css({'transform':'rotate(180deg)','-ms-transform':'rotate(180deg)','-moz-transform':'rotate(180deg)','-webkit-transform':'rotate(180deg)','-o-transform':'rotate(180deg)'});
		}else{
			$pF.slideUp('fast');
			jQ(this).children('.postBtnArrow').css({'transform':'rotate(0deg)','-ms-transform':'rotate(0deg)','-moz-transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)','-o-transform':'rotate(0deg)'});
		}
	});
	jQ('#btnSearch').click(function(){
		if(jQ.trim(jQ('#s').val())!="")
			jQ('#topSearch').submit();
	});
	jQ('#btnSearch2').click(function(){
		if(jQ.trim(jQ('#s2').val())!="")
			location.search="?s="+jQ('#s2').val();
	});
})
