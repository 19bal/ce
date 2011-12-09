<?php
function content_split($s) {
	$wanted = array('Ambalaj:',
			'Endikasyon:',
			'Kontra Endikasyon:',
			'Uyarılar:',
			'Yan Etkileri:',
			'İlaç Etkileşimleri:',
			'Doz Önerisi:');

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
	sort($siralanacak);
	
	yazdir($s,$siralanacak[0],$siralanacak[1]-1);
	yazdir($s,$siralanacak[1],$siralanacak[2]-1);
	yazdir($s,$siralanacak[2],$siralanacak[3]-1);
	yazdir($s,$siralanacak[3],$siralanacak[4]-1);
	yazdir($s,$siralanacak[4],$siralanacak[5]-1);
	yazdir($s,$siralanacak[5],$siralanacak[6]-1);
	yazdir($s,$siralanacak[6],strlen($s)-1);
}
function yazdir($s, $basla, $bitis)
{
	for ($i = $basla; $i <= $bitis; $i += 1)
		print_r( $s[$i]);		
}
?>
