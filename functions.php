<?php 
/**
 * 淘宝UED博客主题functions.php文件 
 * 辅助函数集合
 * 所有ued_开头的函数是用于辅助输出html内容的。
 * 其它函数基本只用于逻辑。
 * Copyright Taobao.com 2011
 * Author:geyuhang.pt
 * 
 */

/**
 * 获取$num个热门标签，按标签数量排名
 */
function get_hot_tags($num){
	$tags = get_terms( 'post_tag', array( 'orderby' => 'count', 'order' => 'DESC' ) ); 
	return $tags;
}

//输出10个热门标签
function ued_hot_tags(){
	$tags=get_hot_tags(10);

	foreach($tags as $tag){

		echo '<a href="'.get_term_link($tag,'post_tag').'" title="相关文章'.$tag->count.'篇">'.$tag->name.'</a>';

	}
}




//得到最近评论
function get_recent_comments($num){
	$rtn=get_comments("number=$num");
	return $rtn;
}

/**
 * 展示最近评论，截取16个字符。这里使用了mbstring扩展库来支持utf-8
 * $num:要显示的条数
 * $total:总共得到的条数。剩下的不显示，由js控制动画展示。
 * 目前$num没有作用，因为前端使用overflow:hidden实现了控制
 * */
function ued_recent_comments($num,$total){
	$cmts=get_recent_comments($total);

	foreach($cmts as $c){
		$link=get_comment_link($c->comment_ID);
		if(mb_strlen($c->comment_content,'utf-8')>18)
			$content=mb_substr($c->comment_content,0,18,'utf-8').'...';
		else
			$content=$c->comment_content;
		echo "<li><a href='{$link}'>{$content}</a></li>";
	}
}

//输出日志的评论
function ued_tag_box(){
	$tags=get_the_tags();
	//var_dump($tags);	
	echo '<!-- 这个div中不能 有内容, 此处是为了别针的特殊处理 -->
		  <div class="tagTop"></div>
	      <div class="tagMiddle">';
	$t_c=count($tags);
	$t_i=1;
	if($t_c>0){
		foreach($tags as $t){
			if($t_i<$t_c){
				$link=get_tag_link($t->term_id);
				echo "<a href='{$link}'>{$t->name}</a>";
			}else
				$last=$t;
			$t_i++;
		}
	}else{
		$last=null;
	}

	echo '</div>
	<!-- 这个div中最多只能有一个a，此处是为了别针的特殊处理 -->
	<div class="tagBottom">';
	if($last){
		$link=get_tag_link($last->term_id);
		echo "<a href='{$link}'>{$t->name}</a>";
	}
	echo '</div>';
}


/**
 * 渲染月份的存档链接
 */
function ued_month_archives($num){
	$arcresults=get_month_archives($num);
	if ( $arcresults ) {
		foreach ( (array) $arcresults as $a ) {
			$url = get_month_link( $a->year, $a->month );
			$text=get_archive_text($a->year,$a->month);
			echo "<li><a href='{$url}' title='共{$a->posts}篇文章'>$text</a></li>";	
			//$output .= get_archives_link($url, $text);
		}
	}
}


//得到年月的中文表达
function get_archive_text($y,$m){
	static  $MONTH_NAME=array(	'一','二','三','四','五','六','七','八','九','十','十一','十二');
	return $y.'年'.$MONTH_NAME[$m-1].'月';
}
//获取按月份的存档连接数据，参考wp-include//general-template.php中的wp_get_archives函数的实现
function get_month_archives($limit){
	global $wpdb;
	if(!$limit)
		$limit=6;
	
	$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC LIMIT $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		return $arcresults;
}

function ued_jia_this(){
	echo '<!-- JiaThis Button BEGIN -->
		  <div id="ckepop">
		<a class="jiathis_button_tsina"></a>
		<a class="jiathis_button_renren"></a>
		<a class="jiathis_button_qzone"></a>
		<a class="jiathis_button_tqq"></a>
		<a class="jiathis_button_twitter"></a>
		<a class="jiathis_button_fb"></a>
		<a class="jiathis_button_tianya"></a>
		<a class="jiathis_button_douban"></a>
		<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank">更多</a>	
		</div>
		<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
		<!-- JiaThis Button END -->';
}


/*
 * 输出头部幻灯片
 */
function ued_head_slide(){
	$head_slides = get_option("ued_head_slide");
	if ($head_slides==null) {
		$head_slides = array();
		add_option('ued_head_slide',json_encode($head_slides));
	} else {
		$head_slides = json_decode($head_slides);
	}
	$nav_html="";
	$slide_html="";
	foreach($head_slides as $slide){
		$nav_html.="<li></li>";
		$slide_html.="<li><img src='{$slide->url}' alt='{$slide->alt}' title='{$slide->describe}' /></li>";
	}
	echo "<ul class='ks-switchable-content'>$slide_html</ul><ul class='ks-switchable-nav'>$nav_html</ul>";
}
function ued_right_slide(){
	$right_slides = get_option("ued_right_slide");
	if ($right_slides==null) {
		$right_slides = array();
		add_option('ued_head_slide',json_encode($right_slides));
	} else {
		$right_slides = json_decode($right_slides);
	}
	$nav_name=array();
	$slide_html="";

	foreach($right_slides as $slide){
		$nav_name[]=$slide->alt;
		$slide_html.="<li><img src='{$slide->url}' alt='{$slide->alt}' title='{$slide->describe}' /></li>";
	}
	$nav_html=json_encode($nav_name);
	echo "<ul class='ks-switchable-content'>$slide_html</ul><script>ued_right_slide.items=$nav_html;</script>";
}
/**
 * 渲染$id的单篇文章的所有评论，用在single.php中
 */
function ued_post_comments($pid){
	
	$comments=get_comments(array('post_id'=>$pid,'order'=>'ASC'));
	foreach($comments as $comment):
	?>
	<div id="comment-<?php echo $comment -> comment_ID;?>" class="commentEntry">
		<div class="commentTitle">
			
			<?php if($comment->user_id!=0):?>
				<img src="<?php bloginfo('template_directory');?>/assets/head/<?php the_author_meta('user_login');?>.png" width="32" height="32" alt="<?php the_author_meta('nickname')?>"/>
			<?php else:
				echo get_avatar($comment, 32);
			endif;?>
			<div class="commentAuthor">
			<?php if($comment->user_id==0):?>
				<span><?php echo $comment -> comment_author_url == '' ? $comment -> comment_author : '<a href="' . $comment -> comment_author_url . '">' . $comment -> comment_author . '</a>';?></span>
			<?php else:?>
				<span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ));?>"><?php the_author_meta('nickname');?></a></span>
			<?php endif;?>
				<span class="commentDate">（<?php echo mysql2date("n月j日",$comment->comment_date);?>）</span>
			</div>
		</div>
		<span class="commentArrow"></span>
		<div class="commentBody">
			<?php echo $comment -> comment_content;?>
		</div>
	</div>
<?php 
	endforeach ;
}

/**
 * “顶”的相关功能实现，这些功能可以考虑做成插件形式，但目前直接写入主题之中
 */
function ued_ding(){
		echo "<div class='postUp postLabel LabelDark' onclick='ding(\"".get_bloginfo('wpurl')."/\",".get_the_ID().");'>";
		echo "顶（<span class='dingNum' id='ding-num-".get_the_ID()."'>".get_ding(get_the_ID())."</span>）</div>";
}
function get_ding($pid){
	$num = get_post_meta($pid, 'ued-ding-num',true);
	if ($num == null)
	{
		save_ding($pid,0);
		return 0;
	}
	return intval($num);
}
function save_ding($pid,$num){
	add_post_meta($pid,'ued-ding-num',$num,true);
}
function update_ding($pid,$num){
	update_post_meta($pid,'ued-ding-num',$num);
}
function increase_ding($pid){
	$d_num=get_ding($pid);
	$d_num++;
	update_ding($pid,$d_num);
	return get_ding($pid);	
}
function ued_ding_ajax(){
	
	if(!empty($_REQUEST['ued-ding-id'])){
		$output=array();
		$pid=intval($_REQUEST['ued-ding-id']);
		$output['id']=$pid;
		$output['new_num']=increase_ding($pid);
		$output['state']='success';
		echo json_encode($output);
		exit();
	}
	
}
//所有到根目录的http请求到wordpress后框架都会include 主题的functions.php文件，所以可以把ajax请求放在这里处理
//注意函数中使用了exit()函数用来终止worpress框架的后续处理。
//考虑过使用单独的页面接收ajax请求，但那样update_post_meta函数不能正常执行，不知道为什么。网上的wordpress的"顶"
//插件也是在根目录中接收的的ajax请求
ued_ding_ajax();


/**
 * 渲染顶头menu
 */
function ued_menu(){
	static $menu_names=array('交互设计','视觉设计','网页前端','用户研究','杂七杂八');
	foreach($menu_names as $m){
		$c_id = get_cat_ID( $m );
    	$link= get_category_link( $c_id );
		echo "<li".(is_category($m)==true?" class='activeMenu'":"")."><a href='".get_bloginfo('url')."/?cat=$c_id' title='$m'>$m</a></li>";
		
	}
	echo "<li><a href='http://ued.taobao.com/job' title='加入我们'>加入我们!</a></li>";
}

/**
 * 渲染分页代码
 * $pages_to_show指定一次最多显示的页数
 */
function ued_pagenavi($pages_to_show = 9) {
	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {
		$prelabel = '上一页';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '下一页';
	}
	$half_pages_to_show = round($pages_to_show/2);
	

	if (!is_single()) {
		//var_dump(is_category());
		if(!is_category() && !is_tag()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
		}
		$fromwhere = $matches[1];
		$my_query="SELECT COUNT(DISTINCT ID) FROM $fromwhere";
		//var_dump($request);
		$numposts = $wpdb->get_var($my_query);
		//var_dump($numposts);
		$max_page = ceil($numposts /$posts_per_page);
		//var_dump($request);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1) {
			echo "<ul class='pagers'>";
		
			$p_link=get_previous_posts_link($prelabel,$max_page);
			if($p_link!=null) echo "<li class='nextPage'>$p_link</li>";
			for($i = $paged - $half_pages_to_show; $i <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<li class='curPage'>$i</li>";
					} else {
				
						echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
					}
				}
			}
			$n_link=get_next_posts_link($nxtlabel, $max_page);
			if($n_link!=null) echo "<li class='nextPage'>$n_link</li>";
			//if (($paged+$half_pages_to_show) < ($max_page)) {
			//echo '<a href="'.get_pagenum_link($max_page).'"> &raquo;</a>';
			//}
			echo "</ul>";
		}
	}
}

function ued_announcement(){
	$ann_c=get_option('ued_announce_content');
	$ann_l=get_option('ued_announce_link');
	if(empty($ann_c))
		$ann_c="欢迎访问淘宝UED博客";
	if(empty($ann_l))
		$ann_l='#';
	echo "<a href='$ann_l'>$ann_c</a>";
}


/**
 * 以下内容是为后台管理增加管理页面。
 * 请参考wordpress开发文档
 * TODO: 目前后台管理每个小模块都是一张页面，可以考虑合并成一个UED博客管理页面。同时，下个版本可以考虑ajax实现。
 * */

/*
 * 增加团队公告设置页面
 */
add_action('admin_menu', 'ued_set_announce');

function ued_set_announce() {
	add_dashboard_page('UED Announcement', '团队公告', 'manage_options', 'ued-announce-identifier', 'ued_announce_page');
}

function ued_announce_page(){
	include_once dirname ( __FILE__ ) . "/admin/announce.php";
}

/*
 * 头部幻灯片设置页面
 */
add_action('admin_menu','ued_set_headslide');

function ued_set_headslide(){
	add_dashboard_page('UED Head Slide','头部幻灯','manage_options','ued-headslide-identifier','ued_headslide_page');
}
function ued_headslide_page(){
	include_once dirname ( __FILE__ ) . "/admin/head_slide.php";
}

/**
 * 右侧幻灯片设置页面
 * 
 */
add_action('admin_menu','ued_set_rightslide');

function ued_set_rightslide(){
	add_dashboard_page('UED Head Slide','右侧幻灯','manage_options','ued-rightslide-identifier','ued_rightslide_page');
}
function ued_rightslide_page(){
	include_once dirname ( __FILE__ ) . "/admin/right_slide.php";
}
?>
