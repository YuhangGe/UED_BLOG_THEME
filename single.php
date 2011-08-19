<?php get_header(); ?>
	<div id="container" class="center w1000">
		<?php the_post(); ?>
		<div class="postAside">
			<div class="postAuthorImage"></div>
			<div class="postAuthor postLabel"><?php the_author(); ?></div>
			<div class="postDate postLabel" title="<?php the_time('Y年n月j日 G:i:s'); ?>"><?php the_time('n月j'); ?></div>
			<div class="postFunction">
				<?php if(get_the_tags()): ?>
				<div class="tagBox"><?php get_3tags(); ?></div>
				<?php endif; ?>
				<div class="postUp postLabel LabelDark">顶(XXX)</div>
				<div class="postShare postLabel LabelDark">分享到</div>
			</div>
		</div>
		<div class="postContent postContentMain">
			<div class="postTitle fontHei postTitleMain"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			<div class="postText"><?php the_content(); ?></div>
		</div>
		<div class="postComment">
			<?php get_allComments(get_the_ID()); ?>
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
