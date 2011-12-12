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
	$dizi = array();

	if (preg_match("/Doz Önerisi/", $s ,$match1, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi,$match1[0][1]);		
	}
	if (preg_match("/İlaç Etkileşimleri/", $s, $match2, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi, $match2[0][1]);
	}
	if (preg_match("/Yan Etkileri/", $s, $match3, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi,$match3[0][1]);	
	}
	if (preg_match("/Uyarılar/", $s, $match4, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi,$match4[0][1]);	
	}
	if (preg_match("/Kontra Endikasyon/", $s, $match5, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi,$match5[0][1]);	
	}
	if (preg_match("/Endikasyon/", $s , $match6, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi,$match6[0][1]);
	}
	if (preg_match("/Ambalaj/", $s , $match7, PREG_OFFSET_CAPTURE))
	{
		array_push($dizi,$match7[0][1]);
	}
	sort($dizi);
	
	for( $i = 0; $i < count($dizi) - 1; $i += 1)
		$dict[$wanted[$i]]= substr($s, $dizi[$i],$dizi[$i +1] - $dizi[$i]);
	
	$dict[$wanted[count($dizi) - 1]]= substr($s, $dizi[count($dizi) - 1]);

	
	return $dict;
}
?>
