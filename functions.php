<?php 
/**
 * 淘宝UED博客主题文件 
 * 辅助函数集合
 * 所有ued_开头的函数是用于辅助输出html内容的。
 * 基于函数基本只用于逻辑。
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
			$content=mb_substr($c->comment_content,1,18,'utf-8').'...';
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

?>

<?php

/**
 * 渲染$id的单篇文章的所有评论，用在single.php中
 */
function ued_post_comments($pid){
	
	$comments=get_comments(array('post_id'=>$pid,'order'=>'ASC'));
	foreach($comments as $comment):
	?>
	<article id="comment-<?php echo $comment -> comment_ID;?>" class="commentEntry">
		<div class="commentTitle">
			<?php echo get_avatar($comment, 32);?>
			<div class="commentAuthor">
				<span><?php echo $comment -> comment_author_url == '' ? $comment -> comment_author : '<a href="' . $comment -> comment_author_url . '">' . $comment -> comment_author . '</a>';?></span>
				<span class="commentDate">（<?php echo mysql2date("n月j日",$comment->comment_date);?>）</span>
			</div>
		</div>
		<span class="commentArrow"></span>
		<div class="commentBody">
			<?php echo $comment -> comment_content;?>
		</div>
	</article>
<?php 
	endforeach ;
}

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

ued_ding_ajax();


function ued_menu(){
	static $menu_names=array('交互设计','视觉设计','网页前端','用户研究','杂七杂八');
	foreach($menu_names as $m){
		$c_id = get_cat_ID( $m );
    	$link= get_category_link( $c_id );
		echo "<li><a href='".get_bloginfo('url')."/?cat=$c_id' title='$m'>$m</a></li>";
		
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
			echo "<div class='pagers'>";
		
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong>$i</strong>";
					} else {
						echo '<a href="'.get_pagenum_link($i).'">'.$i.'</a>';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			//if (($paged+$half_pages_to_show) < ($max_page)) {
			//echo '<a href="'.get_pagenum_link($max_page).'"> &raquo;</a>';
			//}
			echo "</div>";
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


add_action('admin_menu', 'ued_announce');

function ued_announce() {
	add_dashboard_page('My Plugin Dashboard', '团队公告', 'read', 'my-unique-identifier', 'ued_announce_set');
}

function ued_announce_set(){
	include_once dirname ( __FILE__ ) . "/admin/announce.php";
}
?>
