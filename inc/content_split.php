<?php
function content_split($s) {
	$wanted = array('Doz Önerisi:',
					'İlaç Etkileşimleri:',
					'Yan Etkileri:',
					'Uyarılar:',	
					'Kontra Endikasyon:',
					'Endikasyon:',
					'Ambalaj:',
					'Kontrendikasyonları:',
					'Etken Madde:',
					'Kullanım Şekli:',
					'Piyasa Şekilleri:');

	$dict = array();
	$sozluk = array();
	$dizi = array();
	$dictters = array();
	$dictnum = array();
	
	$durum = array(0,0,0,0,0,0,0,0,0,0,0,0);
	
	if (preg_match("/Doz Önerisi/", $s ,$match0, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match0[0][1]] = 'Ambalaj:';
		$dictters['Ambalaj:'] = $match0[0][1];
		$dictnum['Ambalaj:'] = 0;
		array_push($dizi, $match0[0][1]);
		$durum[0]=1;
	}
	if (preg_match("/İlaç Etkileşimleri/", $s, $match1, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match1[0][1]] = 'İlaç Etkileşimleri:';
		$dictters['İlaç Etkileşimleri:'] = $match1[0][1];
		$dictnum['İlaç Etkileşimleri:'] = 1;
		array_push($dizi, $match1[0][1]);
		$durum[1]=1;
	}
	if (preg_match("/Yan Etkileri:/", $s, $match2, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match2[0][1]] = 'Yan Etkileri:';
		$dictnum['Yan Etkileri:'] = $match2[0][1];
		$dictters1['Yan Etkileri:'] = 2;
		array_push($dizi, $match2[0][1]);
		$durum[2]=1;
	}
	if (preg_match("/Uyarılar/", $s, $match3, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match3[0][1]] = 'Uyarılar:';
		$dictters['Uyarılar:'] = $match3[0][1];
		$dictnum['Uyarılar:'] = 3;
		array_push($dizi, $match3[0][1]);
		$durum[3]=1;
	}
	if (preg_match("/Kontra Endikasyon/", $s, $match4, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match4[0][1]] = 'Kontra Endikasyon:';
		$dictters['Kontra Endikasyon:'] = $match4[0][1];
		$dictnum['Kontra Endikasyon:'] = 4;
		array_push($dizi, $match4[0][1]);
		$durum[4]=1;
	}
	if (preg_match("/Endikasyon/", $s , $match5, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match5[0][1]] = 'Endikasyon:';
		$dictters['Endikasyon:'] = $match5[0][1];
		$dictnum['Endikasyon:'] = 5;
		array_push($dizi, $match5[0][1]);
		$durum[5]=1;
	}
	if (preg_match("/Ambalaj:/", $s , $match6, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match6[0][1]] = 'Ambalaj:';
		$dictters['Ambalaj:'] = $match6[0][1];
		$dictnum['Ambalaj:'] = 6;
		array_push($dizi, $match6[0][1]);
		$durum[6]=1;
	}
	if (preg_match("/Kontrendikasyonları:/", $s , $match7, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match7[0][1]] = 'Kontrendikasyonları:';
		$dictters['Kontrendikasyonları:'] = $match7[0][1];
		$dictnum['Kontrendikasyonları:'] = 7;
		array_push($dizi, $match7[0][1]);
		$durum[7]=1;
	}
	if (preg_match("/Etken Maddeler:/", $s , $match8, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match8[0][1]] = 'Etken Madde:';
		$dictters['Etken Madde:'] = $match8[0][1];
		$dictnum['Etken Madde:'] = 8;
		array_push($dizi, $match8[0][1]);
		$durum[8]=1;
	}
	if (preg_match("/Kullanım Şekli/", $s , $match9, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match9[0][1]] = 'Kullanım Şekli:';
		$dictters['Kullanım Şekli:'] = $match9[0][1];
		$dictnum['Kullanım Şekli:'] = 9;
		array_push($dizi, $match9[0][1]);
		$durum[9]=1;
	}
	if (preg_match("/Piyasa Şekilleri:/", $s ,$match10, PREG_OFFSET_CAPTURE))
	{
		$sozluk[$match10[0][1]] = 'Piyasa Şekilleri:';
		$dictters['Piyasa Şekilleri:'] = $match10[0][1];
		$dictnum['Piyasa Şekilleri:'] = 10;
		array_push($dizi, $match10[0][1]);
		$durum[10]=1;
	}
	
	sort($dizi);
	$soneleman = $dictnum[array_search($dizi[count($dizi)-1], $dictters)];	
	
	for($i = 0; $i < count($durum); $i += 1){
		if (($i != $soneleman) && ($durum[$i] != 0))
			$dict[$wanted[$i]] = substr($s, array_search($wanted[$i], $sozluk), $dizi[array_search(array_search($wanted[$i], $sozluk), $dizi) + 1] - $dizi[array_search(array_search($wanted[$i], $sozluk),$dizi)]);
	}
	$dict[$wanted[$soneleman]] = substr($s, array_search($wanted[$soneleman], $sozluk));
	

	
	return $dict;
}
?>
