<div class="aside">
			<div id="hotTag">
					<div id="hotTagTitle">
						热门标签
					</div>
					<div id="hotTagContent">
						<?php ued_hot_tags();?>  
					</div>
				</div>
			<div id="newComments">
				<div id="newComTitle">最新留言</div>
				<ul id="newComContent">
					<?php 
						//渲染最近评论，总共8条，显示4条，通过javascript动画滚动
						//当前参数直接固定，如果需要扩展，可以做成插件形式。
						//请注意如果改了这里的参数，请一并更改 ued-blog.js 中的全局参数 R_CMTS_TOTAL和R_CMTS_SHOW
						ued_recent_comments(4,8); 
					?>
				</ul>
				<div id="newComTail"></div>
			</div>
			<div id="rightSlide">
				<div id="J_RightSlide">
						<?php ued_right_slide();?>
				</div>
				
				<div id="rightSlideNav">
					<span id="photoLeft"></span>
					<span id="photoRight"></span>
					<a id="photoTitle" href="javascript:;">占位标题</a>
				</div>	
			</div>
			<div id="contact">
				<span ><a id="twitter" href=""></a></span>
				<span ><a id="sina" href=""></a></span>
				<span ><a id="rss" href=""></a></span>
			</div>
			<div id="taoBoy"><a href=""></a></div>
			<div id="designLink">
				<a href=""><img src="<?php bloginfo('template_directory'); ?>/assets/design.jpg" alt="潮流设计平台" /></a>
				<div id="designTitle" class="fontHei">潮流设计平台</div>
			</div>
		</div>
		<div class="clear"></div>
	</div><!--container -->
