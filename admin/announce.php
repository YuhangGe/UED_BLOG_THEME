<div style="padding:10px;">
	<h2>设置团队公告</h2>
	<?php
	if (empty($_REQUEST['ued_ann_content']) || empty($_REQUEST['ued_ann_link'])) {
		$ann_content = get_option("ued_announce_content");
		$ann_link = get_option("ued_announce_link");

		if ($ann_content == null) {
			$ann_content = "欢迎访问淘宝UED的博客";
			$ann_link = "#";
			add_option("ued_announce_content", $ann_content);
			add_option("ued_announce_link", $ann_link);
		}
	} else {
		$ann_content = trim($_REQUEST['ued_ann_content']);
		$ann_link = $_REQUEST['ued_ann_link'];
		if (empty($ann_content)) {
			echo "<p style='color:red;'>内容不能为空!</p>";
		} else {
			if (empty($ann_link))
				$ann_link = '#';
			update_option("ued_announce_content", $ann_content);
			update_option("ued_announce_link", $ann_link);
			echo "<p style='color:green;'>修改成功！</p>";
		}

	}
?>
<form method="post">
	<div>
		<label for="">内容：</label>
		<input style="width:200px;" name="ued_ann_content" value="<?php echo $ann_content;?>" />
	</div>
	<div>
		<label>链接：</label>
		<input style="width:200px;" name="ued_ann_link" value="<?php echo $ann_link;?>"/>
	</div>
	<div style="margin-top: 5px;padding-left: 150px;">
		<input type="submit" value="提交" />
	</div>
	
</form>
	
</div>
