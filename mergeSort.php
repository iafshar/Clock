<?php
function merge_sort($my_array, $sub_array){
	if(count($my_array) == 1 ) return $my_array;
	$mid = count($my_array) / 2;
  $left = array_slice($my_array, 0, $mid);
  $right = array_slice($my_array, $mid);
	$left = merge_sort($left, $sub_array);
	$right = merge_sort($right, $sub_array);
	return merge($left, $right, $sub_array);
}
function merge($left, $right, $sub_array){
	$res = array();
	while (count($left) > 0 && count($right) > 0){
		if($left[0]["$sub_array"] > $right[0]["$sub_array"]){
			$res[] = $right[0];
			$right = array_slice($right , 1);
		}else{
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
