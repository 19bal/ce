<?php
class Csv {
	// table ana csv çıktı şeması
	public static function download($_table, $_rows, $_csv_key=",") {
		$title = false;
		$fields = "";
		$rows = "";
		foreach ($_rows as $index => $row) {
			$line = "";
			foreach ($row as $key => $value) {

				if (!$title)
					$fields .= ( $fields ? $_csv_key : '') . $key;
				$line .= ($line ? $_csv_key : '') . $value;
			}
			if (!$title)
				$rows .= $fields . "\n";
			$rows .= $line . "\n";
			$title = true;
		}
		echo $rows;

		header("Content-type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=$_table-". date("Y.m.d") . ".csv");
		exit;
	}

	// table ana csv yükleme şeması
	public static function read($_csv_file, $_csv_key=",") {

		$rows = array();
		if (($handle = fopen($_csv_file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, $_csv_key)) != FALSE) {
				$num = count($data);
				$row = array();
				for ($c = 0; $c < $num; $c++)
					array_push($row, $data[$c]);
				array_push($rows, $row);
			}
			fclose($handle);
		}
		return $rows;
	}
}
?>
