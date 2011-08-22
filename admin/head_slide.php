<div style="padding:10px;">
	<h2>设置顶头幻灯片</h2>
	<?php
	$head_slides = get_option("ued_head_slide");

	if ($head_slides==null) {
		$head_slides = array();
		add_option('ued_head_slide',json_encode($head_slides));
	} else {
		$head_slides = json_decode($head_slides);
	}
	if (!empty($_REQUEST['ued_slide_url'])) {
		$slide_url = trim($_REQUEST['ued_slide_url']);
		$slide_alt = $_REQUEST['ued_slide_alt'];
		$slide_describe = $_REQUEST['ued_slide_describe'];
		if (empty($slide_url)) {
			echo "<p style='color:red;'>Url不能为空!</p>";
		} else {
			$head_slides[]=array(
				'url'=>utf8_uri_encode($slide_url),
				'alt'=>$slide_alt,
				'describe'=>$slide_describe
			);
			update_option("ued_head_slide",json_encode($head_slides));
			echo "<p style='color:green;'>修改成功！</p>";
		}

	}

?>
	<form method="post">
		<table>
			<thead>
				<tr>
					<th>Url</th>
					<th>Alt</th>
					<th>Describe</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($head_slides as $slide):?>
				<tr>
					<td><?php echo $slide -> url;?></td>
					<td><?php echo $slide -> alt;?></td>
					<td><?php echo $slide -> describe;?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<div>
			<label for="">Url：</label>
			<input style="width:200px;" name="ued_slide_url" value="" />
		</div>
		<div>
			<label>Alt：</label>
			<input style="width:200px;" name="ued_slide_alt" value=""/>
		</div>
		<div>
			<label for="">Describe：</label>
			<input style="width:200px;" name="ued_slide_describe" value="" />
		</div>
		<div style="margin-top: 5px;padding-left: 150px;">
			<input type="submit" value="提交" />
		</div>
	</form>
</div>
