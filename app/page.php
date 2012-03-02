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
	function drugs() {
		if(empty($_POST)) {
			echo "Herhangi bir ilaç seçimi yapılmamış";
			return;
		}

		$drug = new Axon("drugs");
		$drug_ids = preg_split('/,/', $_POST['drugs']);
		$selected_drugs = array();

		foreach($drug_ids as $id) {
			$datas = $drug->afind("name='$id'");
			$name  = $datas[0]['name'];
			$content  = $datas[0]['content'];
			$selected_drugs[$id] = array($name, $content);
		}

		F3::set('drugs', $selected_drugs);
		$this->_page('drugs', 'Seçilen İlaçlar');
	}
	function drugcontent() {
		$this->_clear(array('success', 'error'));
		$this->_page('drugcontent', 'İlaç İçerik');
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
			$datas = $drug->afind("name='$id'");
			$name  = strtolower_turkish($datas[0]['name']);
			$content  = $datas[0]['content'];
			$selected_drugs[$id] = array($name, content_split($content));
		}

		F3::set('drugs', $selected_drugs);
		$this->_page('drugscontent', 'Seçilen İlaçlar');
	}
	function review() {
		$this->_clear(array('success', 'error'));

		F3::set('drugs', DB::sql('select * from drugs'));
		$this->_page('review', 'İlaçlar');
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
	function prescription_result() {
		if (empty($_POST)) {
			echo "Herhangi bir ilaç seçimi yapılmamış ya da yaş girilmemiş";
			return;
		}
		$state = (F3::get('REQUEST.age') >= 65) ? true : false;

		$drugs = new Axon("drugs");
		$drug_ids = preg_split('/,/', F3::get('REQUEST.drugs'));
		$selected_drugs = array();

		$interactive_drugs = new Axon("interactive_drugs");
		foreach ($drug_ids as $id) {
			$id = strtolower_turkish($id);

			if ($interactive_drugs->found("name='$id'")) {
				$datas = $interactive_drugs->afind("name='$id'");
				$rate = $datas[0]['rate'];
			} else {
				$datas = $drugs->afind("name='$id'");
				$rate = -1;
			}
			// hastalık için duyarlılık
			if ($state)
				switch ($rate) {
				case 0:
					$rate = "L";break;
				case 1:
					$rate = "H";break;
				case -1:
					$rate = "X";break;
				default:
					$rate = "X";
				}
			else
				$rate = "X";

			$name = strtolower_turkish($datas[0]['name']);
			$content = $datas[0]['content'];

			$selected_drugs[$id] = array($name, $content, $rate);
		}

		F3::set('drugs', $selected_drugs);
		$this->_page('prescription_result', 'Reçete');
	}
	function beforeroute() {
		// pass
	}
	function afterroute() {
		echo Template::serve('layout.htm');
	}
}
