<?php get_header();?>
<div id="container" class="center w1000">
	<section>
		<?php if(have_posts()):	?>
		<?php $post_count=1;while(have_posts()): the_post();?>
		<article class="post<?php
			if ($post_count == count($posts))
				echo ' postLast';
 			?>" id="post-<?php the_ID();?>">
			<div class="postAside">
				<div class="postAuthorImage">
					<img src="<?php bloginfo('template_directory');?>/assets/head/<?php the_author_meta('user_login');?>.png" width="100" height="100" alt="<?php the_author_meta('display_name')?>"/>
				</div>
				<div class="postAuthor postLabel">
					<?php the_author();?>
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
			
				<div class="postImage">
							<img src="<?php bloginfo('template_directory');?>/assets/slide/slide1.jpg"/>
				</div>
				
				<div class="postText">
					<?php the_excerpt();?>
				</div>
				<div class="postRead">
					<a href="<?php the_permalink();?>">查看全文</a>
				</div>
			</div>
			<div class="clear"></div>
		</article>
		<?php $post_count++;
			endwhile;
		?>
		<?php else:?>
			<h2>没有找到文章</h2>
			<p>这张页面需要设计师设计</p>
		<?php endif;?>
		<?php ued_pagenavi();?>
	</section>
	<?php get_sidebar();?>
	<?php get_footer();?>
	
