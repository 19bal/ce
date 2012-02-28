<?php

class Page extends F3instance {

	function _page($template, $title, $notice = NULL) {
		F3::set('title', $title);
		F3::set('template', $template);
	}
	function _clear($notices) {
		foreach ($notices as $notice )
			F3::clear('SESSION.' . $notice);
	}
	function home() {
		$this->_clear(array('error'));
		$this->_page('home', 'Ana Sayfa');
	}
	function about() {
		$this->_clear(array('success', 'error'));
		$this->_page('about', 'Hakkında');
	}
	function drug() {
		$this->_clear(array('success', 'error'));
		$this->_page('drug', 'Etkileşim');
	}
	function drugcontent() {
		$this->_clear(array('success', 'error'));
		$this->_page('drugcontent', 'İlaç İçerik');
	}
	function show() {
		$table = new Axon('drugs');
		$drug = $table->afind("id='" . F3::get('PARAMS.id') . "'");
		F3::set('drug', $drug[0]);
		$this->_page('show', 'İnceleme Sonuçları');
	}
	function prescription() {
		$this->_page('prescription', 'Reçete');
	}
	function review() {
		$this->_clear(array('success', 'error'));

		F3::set('drugs', DB::sql('select * from drugs'));
		$this->_page('review', 'İlaçlar');
	}

	function drugs() {
		if(empty($_POST)) {
			echo "Herhangi bir ilaç seçimi yapılmamış";
			return;
		}

		$drug = new Axon("drugs");
		$drug_ids = preg_split('/,/', $_POST['drugs']);
		$selected_drugs = array();

		foreach($drug_ids as $id) {
			$datas = $drug->afind("id='$id'");
			$name  = $datas[0]['name'];
			$content  = $datas[0]['content'];
			$selected_drugs[$id] = array($name, $content);
		}

		F3::set('drugs', $selected_drugs);
		$this->_page('selected_drugs', 'Seçilen İlaçlar');
	}
	function drugscontent() {
		if(empty($_POST)) {
			echo "Herhangi bir ilaç seçimi yapılmamış";
			return;
		}

		$drug = new Axon("drugs");
		$drug_ids = preg_split('/,/', $_POST['drugs']);
		$selected_drugs = array();

		foreach($drug_ids as $id) {
			$datas = $drug->afind("id='$id'");
			$name  = $datas[0]['name'];
			$content  = $datas[0]['content'];
			$selected_drugs[$id] = array($name, content_split($content));
		}

		F3::set('drugs', $selected_drugs);
		$this->_page('selected_drugscontent', 'Seçilen İlaçlar');
	}
	// ilaçların içeriklerinde ilginç işlemler, deneme yeri
	function dr() {
		// $drugs = DB::sql("select * from drugs");
		// foreach ($drugs as $drug) {
		// 	$dr = new Axon("drugs");
		// 	$dr->name = $drug['name'];

		// 	$c = preg_split('/</', $drug['content']);
		// 	$d = implode(' <', $c);
		// 	$e = preg_split("/padding:11px;'>/", $d);
		// 	$f = strip_tags($e[1]);

		// 	$dr->content = $f;
		// 	$dr->dmn = $drug['dmn'];
		// 	$dr->dmx = $drug['dmx'];
		// 	$dr->dval = $drug['dval'];
		// 	$dr->dayol = $drug['dayol'];
		// 	$dr->save();
		// }
	}

	function beforeroute() {
		// pass
	}
	function afterroute() {
		echo Template::serve('layout.htm');
	}
}
