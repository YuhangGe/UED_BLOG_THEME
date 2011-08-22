<div style="padding:10px;">
	<h2>设置右侧幻灯片</h2>
	<?php
	$right_slides = get_option("ued_right_slide");

	if ($right_slides==null) {
		$right_slides = array();
		add_option('ued_right_slide',json_encode($right_slides));
	} else {
		$right_slides = json_decode($right_slides);
	}
	if (!empty($_REQUEST['ued_slide_url'])) {
		$slide_url = trim($_REQUEST['ued_slide_url']);
		$slide_alt = $_REQUEST['ued_slide_alt'];
		$slide_describe = $_REQUEST['ued_slide_describe'];
		if (empty($slide_url)) {
			echo "<p style='color:red;'>Url不能为空!</p>";
		} else {
			$right_slides[]=array(
				'url'=>utf8_uri_encode($slide_url),
				'alt'=>$slide_alt,
				'describe'=>$slide_describe
			);
			update_option("ued_right_slide",json_encode($right_slides));
			echo "<p style='color:green;'>修改成功！</p>";
		}

	}
	var_dump($right_slides);
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
				<?php foreach($right_slides as $slide):?>
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
