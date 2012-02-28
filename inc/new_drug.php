<?php
function space_clear($str) {
	$state = 0;
	$clear_str = "";
	for ($i = 0; $i < strlen($str); $i++) {
		$char = $str[$i];
		if ($char == ' ' && $state == 0) {
			$clear_str .= $char;
			$state = 1;
		} else if ($char != ' ') {
			$clear_str .= $char;
			$state = 0;
		}
	}
	return $clear_str;
}
function content_clear($content) {
	$s1 = preg_split('/</', $content);
	$s2 = implode(' <', $s1);

	$s3 = preg_split('/>/', $s2);
	$s4 = implode('> ', $s3);

	$s5 = preg_split("/padding:11px;'>/", $s4);
	$s6 = strip_tags($s5[1]);

	return space_clear($s6);
}
function newdrugs() {
	$drugs = DB::sql('select * from drugs');
	foreach ($drugs as $drug) {
		echo $drug['name'];
		$d = new Axon('drugs');
		$d->name = $drug["name"];
		$d->content = content_clear($drug["content"]);
		$d->dmn = $drug["dmn"];
		$d->dmx = $drug["dmx"];
		$d->dval = $drug["dval"];
		$d->dayol = $drug["dayol"];
		$d->save();
	}
}
?>
