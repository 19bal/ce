<?php

// heryerde kullanilmayi dusundugumuz fonksiyonlari barindirdigimiz dosya
function strtolower_turkish($string) {
        $lower = array(
                'İ' => 'i', 'I' => 'ı', 'Ğ' => 'ğ', 'Ü' => 'ü',
                'Ş' => 'ş', 'Ö' => 'ö', 'Ç' => 'ç',
        );
        return strtolower(strtr($string, $lower));
}

function streq_turkish($string1, $string2) {
        return strtolower_turkish($string1) == strtolower_turkish($string2);
}
function is_tc($tc) {
	// Kaynak: is_tc(): http://www.kodaman.org/yazi/t-c-kimlik-no-algoritmasi
	preg_replace(
		'/([1-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1}).*$/e',
		"eval('
			\$on=((((\\1+\\3+\\5+\\7+\\9)*7)-(\\2+\\4+\\6+\\8))%10);
			\$onbir=(\\1+\\2+\\3+\\4+\\5+\\6+\\7+\\8+\\9+\$on)%10;
		')",
		$tc
	);
	// ilk üç hane için bir ek kontrol daha
	if (!(isset($on) && isset($onbir))) return false;

	// son iki haneyi (on ve onbirinci) kontrol et
	return substr($tc, -2) == ($on < 0 ? 10 + $on : $on) . $onbir;
}
// FIXME: bunu bir işlev tablosuna dönüştür
function denetle($verilen, $tarif) {
	foreach ($tarif as $ne => $bilgi) {
		$kosul = array_shift($bilgi);
		switch ($ne) {
		case 'dolu':
			$hata = $kosul && empty($verilen);
			break;
		case 'esit':
			$hata = $kosul != strlen($verilen);
			break;
		case 'enfazla':
			$hata = strlen($verilen) > $kosul;
			break;
		case 'enaz':
			$hata = strlen($verilen) < $kosul;
			break;
		case 'degeri':
			$hata = $kosul != $verilen;
			break;
		case 'tamsayi':
			$hata = $kosul && ! ctype_digit($verilen);
			break;
		case 'ozel':
			$hata = $kosul && $kosul($verilen);
			break;
		}
		if ($hata) {
			return array_shift($bilgi);
		}
	}
}


// ana pdf şsablonu
function pdf($TABLE, $table) {
	// TODO daha bitmedi bu!!! /düzenlenecek
	require("/opt/tcpdf/tcpdf.php");

	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetTitle('OMU UZEM 2010-2011 ÖN KAYIT FORMU');
	$pdf->SetAuthor('Anonim');
	$pdf->SetFont('dejavusans', '', 12);
	$pdf->SetMargins(20, 60, 20);
	$pdf->SetHeaderMargin(10);
	$pdf->SetFooterMargin(10);
//	$pdf->SetHeaderData('uzem-head.jpg', 170, '', '');

	$pdf->AddPage();

	$pdf->SetFont('dejavusans', 'B', 18);
	$pdf->Cell(0, 5, "2010-2011 Ebelik Lisans Tamamlama", 0, 1, 'C');
	$pdf->Cell(0, 5, "Ön Kayıt Başvurusu", 0, 1, 'C');
	$pdf->Ln(5);

	foreach ($F3::get('DB->result') as $index => $kisi) {
		$pdf->SetFont('dejavusans', 'B', 14);
		$pdf->Cell(0, 5, $kesim, 0, 1, 'L');

		$pdf->SetFont('dejavusans', '', 10);
		foreach ($kisi as $alan => $deger) {
			$pdf->MultiCell(30, 1, $alan . ':', 0, 'L', 0, 0, '25', '', true);
			$pdf->MultiCell(180, 1, $deger,       0, 'L', 0, 0, '',   '', true);
			$pdf->Ln(5);
		}

		$pdf->Ln(5);
	}
/*
	$pdf->Ln(15);

	$pdf->Cell(0, 5, "Yukarıda vermiş olduğum bilgilerin doğruluğunu kabul ediyorum.", 0, 1,'T');
	$pdf->Ln(5);
	$pdf->MultiCell(50, 1, 'Tarih:', 0, 'L', 0, 1, '120', '', true);
	$pdf->MultiCell(50, 1, 'Ad Soyad:', 0, 'L', 0, 1, '120', '', true);
	$pdf->MultiCell(50, 1, 'İmza:', 0, 'L', 0, 1, '120', '', true);
*/
	$pdf->Output();
}

?>
