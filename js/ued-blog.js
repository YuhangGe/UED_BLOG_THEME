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
function scrollComments() {
	var cmts = $('#newComContent li');
	if(cmts.length <= R_CMTS_SHOW) {
		return;
	}

	doScrollComments(cmts[0].offsetHeight);
}

function doScrollComments(height) {
	var comments = $('#newComContent li');
	var last_one = comments[comments.length - 1];
	$('#newComContent').animate({
		top : height + 'px'
	}, 1, undefined, function() {
		$(last_one).remove().css('display', 'none').prependTo($('#newComContent').css('top', '0px')).fadeIn(1, function() {
			setTimeout(function() {
				doScrollComments(height)
			}, 2000);
		});
	})
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
	$('#shareDlg-' + id).fadeIn(0.3);
}

function hideShare(id) {

	$('#shareDlg-' + id).fadeOut(0.3);
}

/**
 * “顶”功能的实现
 */
function ding(path, pid) {
	KISSY.io.post(path, {
		'ued-ding-id' : pid
	}, function(rtn) {
		if(rtn.state == "success") {
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
 * 头部幻灯片
 */
ued_head_slide = {
	init : function() {
		var me = this;
		this.l_s = false;
		this.r_s = false;
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
			me.showLeft();
			me.showRight();
		}).on('mouseleave', function() {
			me.hideLeft();
			me.hideRight();
		});

		this.l_ctrl.on('click', function() {
			if(me.slide.activeIndex == 1) {
				me.hideLeft();
			}
			if(me.slide.activeIndex != 0) {
				me.slide.prev();
				me.showRight();
			}
		});

		this.r_ctrl.on('click', function() {
			if(me.slide.activeIndex == me.slide.length - 2) {
				me.hideRight();
			}
			if(me.slide.activeIndex != me.slide.length - 1) {
				me.slide.next();
				me.showLeft();
			}

		});
	},
	showLeft : function() {
		if(this.slide.activeIndex != 0 && this.l_s == false) {
			this.l_ctrl.fadeIn(0.3);
			this.l_s = true;
		}

	},
	showRight : function() {
		if(this.slide.activeIndex != this.slide.length - 1 && this.r_s == false) {
			this.r_ctrl.fadeIn(0.3);
			this.r_s = true;
		}

	},
	hideLeft : function() {
		if(this.l_s == true)
			this.l_ctrl.fadeOut(0.3);
		this.l_s = false;
	},
	hideRight : function() {
		if(this.r_s == true)
			this.r_ctrl.fadeOut(0.3);
		this.r_s = false;
	}
}
ued_right_slide = {
	init : function() {
		var me = this;
		this.l_ctrl = $('#photoLeft');
		this.r_ctrl = $('#photoRight');
		KISSY.use("switchable", function(S, Switchable) {
			me.slide = new Switchable.Slide('#J_RightSlide', {
				effect : 'scrollx',
				easing : 'easeOutStrong',
				nativeAnim : false,
				hasTriggers : false,
				circular : false
			});
		});
		this.l_ctrl.on('click', function() {
			me.slide.prev();
		});

		this.r_ctrl.on('click', function() {
			me.slide.next();
		});
	}
}