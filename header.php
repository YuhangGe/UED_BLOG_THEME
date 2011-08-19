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
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/ued-blog.js"></script>
		
		<?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
		?>
	</head>
	<body <?php body_class(); ?>>
		<header id="header">
			<div id="topBar">
				<div class="center w1000">
					<span id="logo"><a href="."><img src="<?php bloginfo('template_directory');?>/assets/logo.png" alt="TaoBao UED" /></a></span>
					<ul id="navigation" class="fontHei">
						<li>
							<a href="">交互设计</a>
						</li>
						<li>
							<a href="">视觉设计</a>
						</li>
						<li>
							<a href="">网页前端</a>
						</li>
						<li>
							<a href="">用户研究</a>
						</li>
						<li>
							<a href="">杂七杂八</a>
						</li>
						<li>
							<a href="">加入我们!</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="imgShow" class="center w1000">
				<div id="J_ADSlide">
					<ul class="ks-switchable-nav">
						<li class="ks-active"></li>
						<li></li>
						<li></li>
					</ul>
					<div class="ks-switchable-content">
						<div><img src="<?php bloginfo('template_directory');?>/assets/slide/slide1.png" alt="Ads" />
						</div>
						<div style="display: none"></div>
						<div style="display: none"></div>
					</div>
					<b id="leftCtrl" ></b>
					<b id="rightCtrl"></b>
				</div>
			</div>
			<div id="topNotice" class="w1000 center fontHei">
				<span id="msgNotice"><span id="textNotice">团队公告</span><a href="#">UED搜索团队招聘xxxxxx</a></span>
				<form action="<?php bloginfo('url');?>/" method="get" id="topSearch">
					<label for="s" class="textHidden">请输入搜索关键字</label>
					<input type="text" id="s" name="s"/>
					<span id="btnSearch"></span>
				</form>
			</div>
		</header>
