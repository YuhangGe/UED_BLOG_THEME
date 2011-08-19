			<div class="clear"></div>
			<footer id="footer">
			<div class="center w1000">
				<div id="footNav">
					<div class="footItem footSearch">
						<ul>
							<li class="footTitle">
								Search something
							</li>
							<li class="footSep"></li>
							<li>
								<form action="<?php bloginfo('url');?>" method="get" >
									<label for="s2" class="textHidden">请输入搜索关键字</label>
									<div class="footSearchForm">
										<input type="text" id="s2" name="s2"/>
										<span id="btnSearch2"></span>
									</div>
								</form>
							</li>
							<li id="searchHint">
								输入关键字，总共有 <em><?php echo wp_count_posts()->publish;?></em> 篇文章、<em><?php echo wp_count_terms('post_tag'); ?></em> 个标签可搜索。
							</li>
						</ul>
					</div>
					<div class="footItem footState">
						<ul>
							<li class="footTitle">
								Blog States
							</li>
							<li class="footSep"></li>
							<li>
								<ul id="stateList" class="footList">
									<?php ued_month_archives(6);?>
									<li>
										<a href="">more...</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="footItem footLink">
						<ul>
							<li class="footTitle">
								Blog Links
							</li>
							<li class="footSep"></li>
							<li>
								<ul class="footList">
									<?php wp_list_bookmarks(array(
										'title_li'=>null,
										'limit'=>6,
										'categorize'=>false
									));?>
									<li>
										<a href="">more...</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="footItem footShare">
					<ul>
					<li class="footTitle">UED Share<span id="footShareMore"><a href="">more</a></span></li>
					<li class="footSep"></li>
					<li><a href=""><img src="<?php bloginfo('template_directory');?>/assets/share1.png" alt="碳酸饮料会" /></a></li>
					<li><a href=""><img src="<?php bloginfo('template_directory');?>/assets/share2.png" alt="淘宝推荐" /></a></li>
					</ul>
					</div>
					<div class="footItem footUp">
						<a href="javascript:scrollTop();" id="btnUp"></a>
					</div>  
				</div>
			</div>
			<div id="copyright">
				Copyright &copy; 2011TaoBao UED. All rights reserved.
			</div>
		</footer>
		
		<?php wp_footer(); ?>
		
	</body>
</html>