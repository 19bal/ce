<?php
// İLKLENDİRME
//
// upload ve upload-video gibi isimli dizinler elle
// oluşturulup dizin izinleri ayarlanmalıdır
//
// $ mkdir upload // upload-video
// $ chmod -R 777 upload // upload-video
//
//
// ### EXAMPLE
// # ör: (jpeg, png) dosya yükleme
// $up = new Upload(array('jpeg','png'),'upload', 55000000); //up= new Upload();
//
// $up->load('alt-dizin', 'yeni-kayit', $_FILE['photo']);
//
//
// # ör: (jpeg) dosya silme
// $up = Upload.new();
// $up->erase('alt-dizin', 'yeni-kayit.jpeg');
//
//
// ### EXAMPLE
// # örnek (mp4) dosya yükleme
// $up = Upload.new(array('mp4'), 'upload-video', 100000000);
// $up->load('alt-dizin', 'yeni-kayit', $_FILE['photo']);
//
//
// # örnek (mp4) dosya silme
// $up = Upload.new(array('mp4'), 'upload-video', 100000000);
// $up->erase('alt-dizin', 'yeni-kayit.mp4');
//
class Upload {

	public function __construct($type=array('jpeg'), $dir='upload', $size=5500000) {
		$this->_upload = array(
				'dir' => $dir,
				'path' => 'public/' . $dir,
				'size' => $size,
				'type' => $type,
			);
	}

	// sesli hatalı çıkış için :   return array(false,"bla bla");
	// sesli başarılı çıkış için : return array(true, "bla bla");
	// sessiz hatalı çıkış için :  return false;
	public function load($directory, $savename, $upload, $overwrite=false) {
		$uploaded = $upload['tmp_name'];

		// yüklenen dosya yok ise sessiz çıkış
		if (empty($uploaded)) return false;
		// resim ismi yok ise sessiz çıkış
		if (empty($savename)) return false;

		$extension = false;
		foreach ($this->_upload['type'] as $type)
			if (preg_match('/' . $type . '/', $upload['type'])) {
				$extension = $type;
				break;
			}
		if (!$extension) return array(false, "Dosya " . implode($this->_upload['type'], ',') . " formatında olmalıdır");

		// <ana_dizin> yoksa oluşturalım
		if (! file_exists($this->_upload['path'])) {
			mkdir($this->_upload['path'], 0777, true);
			chmod($this->_upload['path'], 0777);
		}

		$savename = $savename . "." . $extension;                // kayıt ismimiz
		$destination = $this->_upload['path'] . "/" . $directory; // hedef dizinimiz
		$image = $destination. "/" . $savename;                  // kaydın yolu

		// hedef dizin yoksa oluşturalım
		if (! file_exists($destination)) {
			mkdir($destination, 0777, true);
			chmod($destination, 0777);
		}

		// tam yol
		$image_path = getcwd() . '/' . $image; // resmimizin tam yolu
		if (is_uploaded_file($uploaded)) {
			if (filesize($uploaded) > $this->_upload['size'])     {return array(false, 'Yüklenen dosya çok büyük');}
			else if (file_exists($image_path) && !($overwrite))   {return array(false, 'Yüklenen dosya zaten var');}
			else if (!move_uploaded_file($uploaded, $image_path)) {return array(false, 'Dosya yükleme hatası');}
			else {
				chmod($destination, 0777);
				return array(true, $directory . "/" . $savename);
			}
		} else // bu aslında bir atak işareti
			return array(false, 'Dosya geçerli bir yükleme değil');
		return false; // sessiz çıkış
	}
	public function erase($directory, $savename) {
		// resim ismi yok ise sessiz çıkış
		if (empty($savename)) return false;
		$image = $this->_upload['path'] . "/" . $savename;
		if (file_exists($image)) unlink($image);
	}
}
?>
