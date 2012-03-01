<?php
include 'init.php';
include 'new_drug.php';
include 'content_split.php';

function array_in($item, $fields) {
	foreach ($fields as $field => $type) {
		if ($type) {
			if (preg_match('/'.$field.'/',$item)) return true;
		} else {
			if ($field == $item) return true;
		}
	}
	return false;
}
function array_key($item, $array) {
	return $array[$item];
}
function strtolower_turkish($string) {
	$lower = array(
		'İ' => 'i', 'I' => 'ı', 'Ğ' => 'ğ', 'Ü' => 'ü',
		'Ş' => 'ş', 'Ö' => 'ö', 'Ç' => 'ç',
	);
	return strtolower(strtr($string, $lower));
}
?>
