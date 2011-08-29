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
							<?php
								//输出分享的链接内容，此处使用在线分享平台jia this的代码 
								ued_jia_this();
							?>
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
		</div>
					<div class="postTail"></div>
		<div class="postComment">
			<?php ued_post_comments(get_the_ID()); ?>
		</div>
		<form method="post" action="<?php  echo get_option( 'siteurl' ); ?>/wp-comments-post.php" class="newComment">
			<p><label for="author" class="textHidden">名字</label><input class="inputBox" id="author" name="author" type="text" /><span>您的名字（必填）</span></p>
			<p><label for="email" class="textHidden">邮箱</label><input class="inputBox" id="email" name="email" type="text" /><span>您的邮箱（我们为您保密）</span></p>
			<p><label for="url" class="textHidden">主页</label><input class="inputBox" id="url" name="url" type="text" /><span>您的网站（可选）</span></p>
			<p>
			  <textarea class="inputBox" id="comment" name="comment" rows="10" cols="30"></textarea>
			</p>
			<p>
			  <input type="submit" id="submit" value="我要留言" class="pointer" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>
		</form>
		<div class="clear"></div>
	</div>
<?php get_footer(); ?>
