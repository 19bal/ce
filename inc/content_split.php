<?php
function content_split($s) {
	$wanted = array('Ambalaj:',
			'Endikasyon:',
			'Kontra Endikasyon:',
			'Uyarılar:',
			'Yan Etkileri:',
			'İlaç Etkileşimleri:',
			'Doz Önerisi:');

	$dict = array();

	if (preg_match("/Doz Önerisi/", $s))
	{
		$k = explode($wanted[6], $s);
		$dict[$wanted[6]] = $k[1];
		$s = $k[0];
	}
	if (preg_match("/İlaç Etkileşimleri/", $s))
	{
		$m = explode($wanted[5], $s);
		$dict[$wanted[5]] = $m[1];
		$s = $m[0];
	}
	if (preg_match("/Yan Etkileri/", $s))
	{
		$n = explode($wanted[4], $s);
		$dict[$wanted[4]] = $n[1];
		$s = $n[0];
	}
	if (preg_match("/Uyarılar/", $s))
	{
		$p = explode($wanted[3], $s);
		$dict[$wanted[3]] = $p[1];
		$s = $p[0];
	}
	if (preg_match("/Kontra Endikasyon/", $s))
	{
		$r = explode($wanted[2], $s);
		$dict[$wanted[2]] = $r[1];
		$s = $r[0];
	}
	if (preg_match("/Ambalaj/", $s))
	{
		$j = explode($wanted[1], $s);
		$dict[$wanted[1]] = $j[1];
		$s = $j[0];
	}
	return $dict;
}

?>
