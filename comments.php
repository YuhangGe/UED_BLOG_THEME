<?php if ( have_comments() ) : ?>
<article id="comment-<?php echo $comment -> comment_ID;?>" class="commentEntry">
	<div class="commentTitle">
		<?php echo get_avatar($comment, 32);?>
		<div class="commentAuthor">
			<span><?php echo $comment -> comment_author_url == '' ? $comment -> comment_author : '<a href="' . $comment -> comment_author_url . '">' . $comment -> comment_author . '</a>';?></span>
			<span class="commentDate">（<?php $ds = explode(' ', $comment -> comment_date);
					echo $ds[0];
				?>）</span>
		</div>
	</div>
	<span class="commentArrow"></span>
	<div class="commentBody">
		<?php echo $comment -> comment_content;?>
	</div>
</article>
<?php endif; ?>