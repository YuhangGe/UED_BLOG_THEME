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
	//scrollComments();
	ued_comment_scroll.init();
	ued_head_slide.init();
	ued_right_slide.init();
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
			func.css("overflow", "visible");
		});
	}

}

/**
 * 滚动显示最近评论
 */
ued_comment_scroll={
	init:function(){
		me=this;
		var cmts=$('#newComContent li');
		if(cmts.length <= R_CMTS_SHOW) {
			return;
		}
		this.height=cmts[0].offsetHeight;
		this.mouseIn=false;

		$('#newComContent').on('mouseenter',function(){
			me.mouseIn=true;
			if(me.timeDo!=null){
				clearTimeout(me.timeDo);
				me.timeDo=null;
			}
		}).on('mouseleave',function(){
			me.mouseIn=false;
			if(me.timeDo==null){
				me.timeDo=setTimeout(function(){
					me.doScroll(me);
				},2000);
			}
		});
		
		this.timeDo=setTimeout(function(){
			me.doScroll(me);
		},2000);
	},
	doScroll:function(me){
		var comments = $('#newComContent li');
		var last_one = comments[comments.length - 1];
		$('#newComContent').animate({
			top : me.height + 'px'
		}, 1, undefined, function() {
			$(last_one).remove().css('display', 'none').prependTo($('#newComContent').css('top', '0px')).fadeIn(1, function() {
				if(me.mouseIn==true)
					return;
				me.timeDo=setTimeout(function() {
					me.doScroll(me)
				}, 2000);
			});
		})
	}
}



/**
 * 将页面滚动到顶，使用加速度模拟
 */
function scrollTop() {
	var t = document.documentElement.scrollTop;
	scrollTopLoop(t, 0);
}

function scrollTopLoop(top, i) {
	if(top < 10) {
		document.documentElement.scrollTop = 0;
		return;
	}
	document.documentElement.scrollTop = top;
	top -= 50 + 50 * i;
	setTimeout(function() {
		scrollTopLoop(top, i + 1)
	}, 5);
}

/**
 * 控制分享框的显隐
 */
function showShare(id) {
	$('#shareDlg-' + id).show();
}

function hideShare(id) {
	$('#shareDlg-' + id).hide();
}

/**
 * “顶”功能的实现，通过cookie进行控制，ued-ding中保存了该用户顶过的所有文章的id
 */
function ding(path, pid) {
	if(KISSY.Cookie.get('ued-ding')==null){
		KISSY.Cookie.set('ued-ding',"",365);
	}else{
		var id_arr=KISSY.Cookie.get('ued-ding').split(',');
		for(var i=0;i<id_arr.length;i++){
			if(id_arr[i]==pid.toString()){
				alert("你已经顶过这篇文章啦，不要贪心哦^_^~~~~~");
				return;
			}
		}
	}
	KISSY.io.post(path, {
		'ued-ding-id' : pid
	}, function(rtn) {
		if(rtn.state == "success") {
			var id_arr=KISSY.Cookie.get('ued-ding').split(',');
			id_arr.push(rtn.id.toString());
			//设置一年的cookie
			KISSY.Cookie.set('ued-ding',id_arr.join(','),365);
			dingAnim(rtn.id, rtn.new_num);
		}
	}, "json");
}

function dingAnim(id, num) {
	var ele = $('#ding-num-' + id);
	var h = ele[0].offsetHeight;
	ele.animate({
		'bottom' : h + 'px'
	}, 0.2, undefined, function() {
		ele.css('bottom', (0 - h) + 'px').html(num).animate({
			'bottom' : '0px'
		}, 0.2, undefined, null);
	})
}

/*
 * 控制头部幻灯片，此处封装到ued_head_slide对象中，是为了方便代码管理
 */
ued_head_slide = {
	init : function() {
		var me = this;
		this.l_ctrl = $('#leftSlideCtrl');
		this.r_ctrl = $('#rightSlideCtrl');
		KISSY.use("switchable", function(S, Switchable) {
			me.slide = new Switchable.Slide('#J_HeadSlide', {
				effect : 'scrollx',
				easing : 'easeOutStrong',
				nativeAnim : false,
								circular : false
			});
		});
		$('#J_HeadSlide').on('mouseenter', function() {
			me.l_ctrl.show();
			me.r_ctrl.show();
		}).on('mouseleave', function() {
			me.l_ctrl.fadeOut(0.3);
			me.r_ctrl.fadeOut(0.3);
		});
		this.l_ctrl.on('click', function() {
				me.slide.prev();
		});
		this.r_ctrl.on('click', function() {
				me.slide.next();
		});
	}
}
/*
 * 控制右边栏幻灯片，此处封装到ued_right_slide对象中，是为了方便代码管理
 * 右边栏幻灯片在单个文章页面(single.php)中是不需要的，这里为了方便把代码统一写在ued-blog.js中，可以考虑对
 * single.php页面的js单独提取出来
 */
ued_right_slide = {
	items:[],
	init : function() {
		var me = this;
		this.l_ctrl = $('#photoLeft');
		this.r_ctrl = $('#photoRight');
		if($('#J_RightSlide').length==0)
			return;
		KISSY.use("switchable", function(S, Switchable) {
			me.slide = new Switchable.Slide('#J_RightSlide', {
				effect : 'scrollx',
				easing : 'easeOutStrong',
				nativeAnim : false,
				hasTriggers : false,
				circular : false
			});
			
			me.slide.on('beforeSwitch', function(ev) {
				$('#photoTitle').html(
					me.items[ev.toIndex]
				);
			});
			
			me.slide.next();
		});

		this.l_ctrl.on('click', function() {
			me.slide.prev();
		});

		this.r_ctrl.on('click', function() {
			me.slide.next();
		});
		
		
	}
}

/*
 * 处理评论的js代码，在index.php中是不需要的，此处放在ued-blog.js中是为了主题统一使用一个js文件，
 * 可以考虑提取出来。
 */



