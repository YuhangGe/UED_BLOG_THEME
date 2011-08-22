<?php get_header();?>
<div id="container" class="center w1000">

	<div class="section">
		<?php
		/*
		 * 这个部分用来判断是否是存档页面，依次是：
		 * 是否是搜索后的结果，是否是包含某个标签的文章集合，
		 * 是否是某天、某月、某年的文章集合
		 * 是否是某个作者的文章集合
		 * 注意是否是某个作者的文章集合，为了得到作者名字，需要延后处理，因为wp不提供相关函数。
		 * */
			if(is_search()){
				echo "<h3><em>".get_search_query()."</em>的搜索结果</h3>";
			}elseif(is_tag()){
				echo "<h3>标签包括<em>".single_tag_title('',false)."</em>的文章</h3>";
			}elseif(is_day()||is_month()||is_year()){
				echo "<h3>".get_the_date('n月j日')."</h3>";
			}elseif(is_author()){
				$is_author=true;
			}
		?>
		
		<?php if(have_posts()):	?>
		<?php //进入模板循环 ?>
		<?php $post_count=1;while(have_posts()): the_post();?>
		
		
		<?php 
		/*
		 *  这里是某个作者的文章集合的延后处理，通过第一篇文章得到作者信息展示标题。
		 */
		?>
		<?php if($post_count==1 && $is_author==true):?>
			 <h3><em><?php the_author_meta('nickname');?></em>的所有文章</h3>
		<?php endif;?>
		
		<div class="post<?php
			if ($post_count == count($posts))
				echo ' postLast';
 			?>" id="post-<?php the_ID();?>">
			<div class="postAside">
				<div class="postAuthorImage">
					<img src="<?php bloginfo('template_directory');?>/assets/head/<?php the_author_meta('user_login');?>.png" width="100" height="100" alt="<?php the_author_meta('nickname')?>"/>
				</div>
				<div class="postAuthor postLabel">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ));?>"><?php the_author_meta('nickname');?></a>
				</div>
				<div class="postDate postLabel" title="<?php the_time('Y年n月j日 G:i:s');?>">
					<?php the_time('n月j日');?>
				</div>
				<div class="postFunction" id="postFunc-<?php the_ID();?>" style="display:none;">
						<div class="tagBox">
							<?php ued_tag_box() ?>
						</div>
						<?php ued_ding();?>
						<div id="shareBtn-<?php the_ID();?>" class="postShare postLabel LabelDark">
							<span>分享到</span>
							<div class="shareDialog" id="shareDlg-<?php the_ID();?>" style="display: none;">
								<a href="http://share.xiaonei.com/share/buttonshare.do?link=<?php the_permalink() ?>&title=<?php the_title(); ?>" title="分享到人人网" target="_blank" rel="nofollow" ><img src="http://s.xnimg.cn/favicon-rr.ico" alt="分享到人人网"  /></a>
								<a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?url=<?php the_permalink() ?>&title=<?php the_title(); ?>');})()" title="分享到新浪微博" target="_blank" rel="nofollow"><img src="http://t.sina.com.cn/favicon.ico" alt="分享到新浪微博" /></a>
								<a href="javascript:(function(){window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+ encodeURIComponent(location.href)+ '&title='+encodeURIComponent(document.title));})()" title="分享到QQ空间" target="_blank" rel="nofollow"><img src="http://qzone.qq.com/favicon.ico" alt="分享到QQ空间"  /></a>
								<a href="http://share.xiaonei.com/share/buttonshare.do?link=<?php the_permalink() ?>&title=<?php the_title(); ?>" title="分享到人人网" target="_blank" rel="nofollow" ><img src="http://s.xnimg.cn/favicon-rr.ico" alt="分享到人人网"  /></a>
								<a href="http://v.t.sina.com.cn/share/share.php?url=<?php the_permalink() ?>&title=<?php the_title(); ?>" title="分享到新浪微博" target="_blank" rel="nofollow"><img src="http://t.sina.com.cn/favicon.ico" alt="分享到新浪微博" /></a>
								<a href="javascript:(function(){window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+ encodeURIComponent(location.href)+ '&title='+encodeURIComponent(document.title));})()" title="分享到QQ空间" target="_blank" rel="nofollow"><img src="http://qzone.qq.com/favicon.ico" alt="分享到QQ空间"  /></a>
								
							</div>
						</div>
						<script>
							KISSY.all('#shareBtn-<?php the_ID();?>').on('mouseenter',function(){
								showShare(<?php the_ID();?>);
							}).on('mouseleave',function(){
								hideShare(<?php the_ID();?>);
							});
						</script>
				</div>
				<div calss="postAsideBottom">
						<div id="postBtn-<?php the_ID();?>" onclick="showHideFunc(<?php the_ID();?>);" class="postBtn"><b class="down-narrow"></b></div>
				</div>
			
			</div>
			<div class="postContent">
				<div class="postTitle fontHei">
					<a href="<?php the_permalink();?>"><?php the_title();?></a>
				</div>
			
			<?php 
				/*
				 * 此处放置文章顶头图片，这个图片只在文章列表的页面(index.php)展示，在文章详细内容（single.php）中
				 * 不展示。注意跟直接插入文章中的图片是不一样的。
				 * 
				 * 在发布日志的时候，需要在自定义区域处手动增加名为 head-image 的自定义内容。
				 *  这个内容可以是外部图片，如果想上传图片，请在发布日志前通过wordpress的媒体中心上传
				 */
			?>
			<?php $head_img_url=get_post_meta(get_the_ID(),"head-image");	if($head_img_url!=null && !empty($head_img_url[0])) :?>
				<div class="postImage">
					<img src="<?php echo $head_img_url[0];?>"/>
				</div>
			<?php endif;?>
				
				<div class="postText">
					<?php the_excerpt();?>
				</div>
				<div class="postRead">
					<a href="<?php the_permalink();?>">查看全文</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php $post_count++;
			endwhile;
		?>
		<?php else:?>
			<h2>没有找到相关文章</h2>
			<p>TODO：这张页面可能需要设计师设计</p>
		<?php endif;?>
		<?php ued_pagenavi();?>
	</div>
	<?php get_sidebar();?>
	<?php get_footer();?>
	
