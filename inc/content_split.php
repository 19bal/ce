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
	$siralanacak = array();

	if (preg_match("/Doz Önerisi/", $s ,$match1, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak,$match1[0][1]);		
	}
	if (preg_match("/İlaç Etkileşimleri/", $s, $match2, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak, $match2[0][1]);
	}
	if (preg_match("/Yan Etkileri/", $s, $match3, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak,$match3[0][1]);	
	}
	if (preg_match("/Uyarılar/", $s, $match4, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak,$match4[0][1]);	
	}
	if (preg_match("/Kontra Endikasyon/", $s, $match5, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak,$match5[0][1]);	
	}
	if (preg_match("/Endikasyon/", $s , $match6, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak,$match6[0][1]);
	}
	if (preg_match("/Ambalaj/", $s , $match7, PREG_OFFSET_CAPTURE))
	{
		array_push($siralanacak,$match7[0][1]);
	}
	$sirali = sort($siralanacak);
	
	$dict[$wanted[0]] = substr($s, $sirali[0],$sirali[1] - $sirali[0]);
	for ( $i = 0; $i < count($sirali); $i += 1){
		if( $i != count($sirali) - 1)
			$dict[$wanted[$i]]= substr($s, $sirali[$i],$sirali[$i + 1] - $sirali[$i]);
		else
			$dict[$wanted[$i]]= substr($s, $sirali[$i]);
		}
	
	return $dict[$wanted[0]];
}
?>
