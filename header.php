<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;

		wp_title('|', true, 'right');

		// Add the blog name.
		bloginfo('name');

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && (is_home() || is_front_page()))
			echo " | $site_description";

		// Add a page number if necessary:
		if ($paged >= 2 || $page >= 2)
			echo ' | ' . sprintf(__('Page %s', 'twentyeleven'), max($paged, $page));
			?></title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type');?>; charset=<?php bloginfo('charset');?>" />
		<meta name="generator" content="WordPress <?php bloginfo('version');?>" />
		<!-- leave this for stats please -->
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url');?>" type="text/css" media="screen" />


		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url');?>" />
		<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url');?>" />
		<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url');?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
		<!-- KISSY -->
		<script type="text/javascript" src="http://a.tbcdn.cn/s/kissy/1.2.0/kissy-min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/ued-blog.js"></script>
		
		<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/ie.css"></link>
		<![endif]-->
		<!--[if lte IE 7]>
		<style>
			.pagers li{
				display:inline;
			}
			.postBtn .down-narrow{
				left:0px;
			}
			.commentArrow{
				top:41px;
			}
			.commentBody{
					display: inline;
				zoom:1;
			}
		</style>
		<![endif]-->
		
		<?php
		
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
		?>
	</head>
	<body <?php body_class();?>>
		<div id="header">
			<div id="topBar">
				<div class="center w1000">
					<span id="logo"><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_directory');?>/assets/logo.png" alt="TaoBao UED" /></a></span>
					<ul id="navigation" class="fontHei">
						<?php ued_menu();?>
					</ul>
				</div>
			</div>
			<div id="headSlide" class="center w1000">
				<div id="J_HeadSlide">
					<?php ued_head_slide();?>
				
					<b id="leftSlideCtrl" style="display: none;"></b>
					<b id="rightSlideCtrl" style="display: none;"></b>
				</div>
			</div>
			<div id="topNotice" class="w1000 center fontHei">
				<span id="msgNotice">
					<span id="textNotice">团队公告</span>
					<?php ued_announcement();?>
				</span>
				<div id="topSearch">
					<form action="<?php bloginfo('url');?>/" method="get">
					<label for="s" class="textHidden">请输入搜索关键字</label>
					<input type="text" id="s" name="s"/>
					<span id="btnSearch"></span>
					</form>
				</div>
			</div>
		</div>
