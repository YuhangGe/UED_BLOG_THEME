<?php get_header(); ?>
	<div id="container" class="center w1000">
		<?php the_post(); ?>
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
				<div class="postFunction" id="postFunc-<?php the_ID();?>" >
						<div class="tagBox">
							<?php ued_tag_box() ?>
						</div>
						<?php ued_ding();?>
						<div id="shareBtn-<?php the_ID();?>" class="postShare postLabel LabelDark">
							<span>分享到</span>
							<div class="shareDialog" id="shareDlg-<?php the_ID();?>" style="display: none;">
								<a href="http://share.xiaonei.com/share/buttonshare.do?link=<?php the_permalink() ?>&title=<?php the_title(); ?>" title="分享到人人网" target="_blank" rel="nofollow" ><img src="http://s.xnimg.cn/favicon-rr.ico" alt="分享到人人网"  /></a>
								<a href="http://v.t.sina.com.cn/share/share.php?url=<?php the_permalink() ?>&title=<?php the_title(); ?>" title="分享到新浪微博" target="_blank" rel="nofollow"><img src="http://t.sina.com.cn/favicon.ico" alt="分享到新浪微博" /></a>
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
				<!--在单张文档页面，左边功能栏默认打开 -->
				<div calss="postAsideBottom">
						<div id="postBtn-<?php the_ID();?>" onclick="showHideFunc(<?php the_ID();?>);" class="postBtn"><b class="down-narrow up-narrow"></b></div>
				</div>
			
		</div>
		<div class="postContentMain">
			<div class="postTitle fontHei postTitleMain">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</div>
			<div class="postText">
				<?php the_content(); ?>
			</div>
			<div class="postTail"></div>
		</div>
		<div class="postComment">
			<?php ued_post_comments(get_the_ID()); ?>
		</div>
		<form method="post" action="<?php  echo get_option( 'siteurl' ); ?>/wp-comments-post.php" class="newComment">
			<p><label for="author" class="textHidden">名字</label><input class="inputBox" id="author" name="author" type="text" /></p>
			<p><label for="email" class="textHidden">邮箱</label><input class="inputBox" id="email" name="email" type="text" /></p>
			<p><label for="url" class="textHidden">主页</label><input class="inputBox" id="url" name="url" type="text" /></p>
			<p>
			  <textarea class="inputBox" id="comment" name="comment" rows="10" cols="30"></textarea>
			</p>
			<p>
			  <input type="submit" id="submit" value="发表" class="pointer" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>
		</form>
		<div class="clear"></div>
	</div>
<?php get_footer(); ?>
