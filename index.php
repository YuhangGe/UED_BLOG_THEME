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
					<img src="<?php ?>" />
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
						<div class="postUp postLabel LabelDark">
							顶(XXX)
						</div>
						<div class="postShare postLabel LabelDark">
							分享到
						</div>
					
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
							<img src="<?php bloginfo('template_directory');?>/assets/love.jpg"/>
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
			
		<?php endif;?>
		<?php wp_pagenavi();?>
	</section>
	<?php get_sidebar();?>
	<?php get_footer();?>
