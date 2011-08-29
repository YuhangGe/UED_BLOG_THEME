<?php
if(!defined("UED_SLIDE_TYPE")){
	die();
}
$type=UED_SLIDE_TYPE;
if($type=='head')
	$option_name="ued_head_slide";
elseif($type=='right')
	$option_name="ued_right_slide";
else {
	die();
}
$slides = get_option($option_name);

if ($slides == null) {
	$slides = array();
	add_option($option_name, json_encode($slides));
} else {
	$slides = json_decode($slides);
}

?>

<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/admin/admin.css" type="text/css"/>
<div style="padding:10px;">
	<script type="text/javascript">
		window.UED_SLIDES=<?php echo json_encode($slides);?>;
		window.UED_SLIDE_TYPE = '<?php echo $type;?>';
	</script>
	<form method="post">
		<div class="grid grid-zebra">
			<p style="font-size: 23px;font-weight: bold;margin-bottom: 10px;">
				<?php echo $type=='head'?'顶头':'右边栏';?>幻灯片列表：
			</p>
			<table id="table-slide" class="table" >
				<colgroup>
					<col width="35">
					<col width="30">
					<col width="10%">
					<col width="17%">
					<col width="4%">
					<col width="4%">
				</colgroup>
				<thead>
					<tr class="row">
						<th>图片地址</th>
						<th>跳转路径</th>
						<th>图片标题</th>
						<th>图片说明</th>
						<th class="cell-extra" colspan="2">操作</th>
					</tr>
				</thead>
				<tbody id="table-body">
					<tr id="row-add" class="row">
						<td>
						<div>
							Alice
							<input id="edit-add-url" class="edit row-edit" style="display: block;" />
						</div></td>
						<td>
						<div>
							GeYuhang.pt
							<input id="edit-add-link" class="edit row-edit" style="display: block;" />
						</div></td>
						<td>
						<div>
							Daisy
							<input id="edit-add-alt" class="edit row-edit" style="display: block;" />
						</div></td>
						<td>
						<div>
							Yini
							<input id="edit-add-desc" class="edit row-edit" style="display: block;" />
						</div></td>
						<td class="cell-extra" colspan="2"><a href="javascript:addRow();">添加图片</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
</div>
