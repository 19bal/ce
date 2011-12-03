<?php

$sql = explode(';', file_get_contents('cfg/schema.db'));
foreach ($sql as $raw)
	if ($query = trim($raw))
		DB::sql($query);

$table = new Axon(F3::get('TABLE'));
if (count($table->find()) == 0)
	DB::sql("insert into " . F3::get('TABLE') . 
	" (username, password, status, photo) " .
	" values ('19', 'ondokuz', 1, '" . F3::get('default_image') . "');");

?>
