<?php

function quick_sort($arr)
 {
	$left = $right = array();
	if(count($arr) < 2)
	{
		return $arr;
	}
	$ini = key($arr);
	
	$new = array_shift($arr);
	
	foreach($arr as $item)
	{
		if($item <= $new)
		{
			$left[] = $item;
		}elseif ($item > $new)
		{
			$right[] = $item;
		}
	}
	return array_merge(quick_sort($left),array($ini => $new),quick_sort($right));
}



function game01($n,$arr)
{
	$result = [];
	$ini = 0;
	$fin = count($arr)-1;
	
	while($ini != $fin)
	{
		if($arr[$ini] + $arr[$fin] == $n)
		{
			array_push($result,$arr[$ini],$arr[$fin]);
			return $result;
		}
		else if($arr[$ini] + $arr[$fin] < $n){
			$ini++;
			
		}
		else{
			$fin--;
		}
	}
}


$n = 7;

// Este array tiene numeros repetidos y negativos
$arr = [2,8,5,4,11,7,2,5,-11,3,5];

// Primero lo ordeno con quick_sort, en sí la implementación del algoritmo de ordenamiento es algo fuera del Juego 01.
$arr = quick_sort($arr);

var_dump(game01($n,$arr));
 