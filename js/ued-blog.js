if(!KISSY) {
	alert('加载KISSY脚本失败，请确定网络链接');
	throw 'not found kissy';
}
$ = KISSY.all;
$.log = function(msg) {
	if(console)
		console.log(msg);
}
/*
* 全局变量区
*/
//最近评论显示个数，当前版本直接固化到代码中，以后可考虑将这个模块做成插件，js参数由php端渲染。
R_CMTS_SHOW = 4;


KISSY.ready(function() {
	scrollComments();
});
/**
 * 控制文章左边栏功能框的下拉收缩动画
 */
function showHideFunc(id) {
	var func = KISSY.all('#postFunc-' + id);
	var btn = KISSY.all('#postBtn-' + id + ' b');
	if(func.css('display') != 'none') {
		func.slideUp(0.5, function() {
			btn.removeClass("up-narrow");
		});
	} else {
		func.slideDown(0.5, function() {
			btn.addClass("up-narrow");
		});
	}

}

/**
 * 滚动显示最近评论
 */
function scrollComments() {
	var cmts = $('#newComContent li');
	if(cmts.length <= R_CMTS_SHOW) {
		return;
	}

	doScrollComments(cmts[0].offsetHeight);
}

function doScrollComments(height) {
	var comments=$('#newComContent li');
	var last_one = comments[comments.length - 1];
	$('#newComContent').animate({
		top : height + 'px'
	}, 1, undefined, function() {
		$(last_one).remove().css('display', 'none').prependTo($('#newComContent').css('top', '0px')).fadeIn(1,function() {
			setTimeout(function() {
				doScrollComments(height)
			}, 2000);
		});
	})
}

/**
 * 将页面滚动到顶，使用加速度模拟
 */
function scrollTop(){
	var t=document.documentElement.scrollTop;
	scrollTopLoop(t,0);
}
function scrollTopLoop(top,i){
	if(top<10){
		document.documentElement.scrollTop=0;
		return ;
	}
	document.documentElement.scrollTop=top;
	top-=50+50*i;
	setTimeout(function(){
		scrollTopLoop(top,i+1)
	},5);
}
