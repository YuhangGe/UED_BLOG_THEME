<?php
	include 'functions.php';
	$output=array();
	if(!empty($_REQUEST['ued-ding-id'])){
		
		$pid=intval($_REQUEST['ued-ding-id']);
		echo $pid;
		$output['new_num']=increase_ding($pid);
		$output['state']='success';
	}
	echo json_encode($output);
	exit();
?>