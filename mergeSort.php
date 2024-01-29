<?php
function merge_sort($my_array, $sub_array, $double_check){
	if(count($my_array) == 1 ) return $my_array;
	$mid = count($my_array) / 2;
  	$left = array_slice($my_array, 0, $mid);
  	$right = array_slice($my_array, $mid);
	$left = merge_sort($left, $sub_array, $double_check);
	$right = merge_sort($right, $sub_array, $double_check);
	return merge($left, $right, $sub_array, $double_check);
}
function merge($left, $right, $sub_array, $double_check){
	$res = array();
	while (count($left) > 0 && count($right) > 0){
		if($left[0]["$sub_array"] > $right[0]["$sub_array"]){
			$res[] = $right[0];
			$right = array_slice($right , 1);
		}
		else if ($left[0]["$sub_array"] == $right[0]["$sub_array"]) {
			if ($right[0]["$double_check"] > $left[0]["$double_check"]) {
				$res[] = $left[0];
				$res[] = $right[0];
			}
			else {
				$res[] = $right[0];
				$res[] = $left[0];
			}
			$right = array_slice($right , 1);
			$left = array_slice($left, 1);
		}
		else{
			$res[] = $left[0];
			$left = array_slice($left, 1);
		}
	}
	while (count($left) > 0){
		$res[] = $left[0];
		$left = array_slice($left, 1);
	}
	while (count($right) > 0){
		$res[] = $right[0];
		$right = array_slice($right, 1);
	}
	return $res;
}
?>
