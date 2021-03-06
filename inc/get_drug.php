<?php

require_once  'lib.php';

function myserialize($arr) {
	$str = '[';

	foreach($arr as $i=>$a) {
		//$str .= '{"id":"' . $a['id'] . '","name":"' . strtolower_turkish($a['name']) . '"}';
		$str .= '{"id":"' . $a['name'] . '","name":"' . strtolower_turkish($a['name']) . '"}';

		if($i <> (count($arr) - 1)) $str .= ',';
	}

	$str .= ']';

	return $str;
}

$q = empty($_GET['q']) ? "" : $_GET['q'];

$db = ini_config("../.f3.ini");
mysql_connect("localhost", $db['dbuser'], $db['dbpass']) or die("Could not connect");
mysql_select_db($db['dbname']) or die("Could not select database");

//$sql = "select * from drugs where name LIKE '%$q%' limit 0,20";
// $sql = "select name from interactive_drugs where name like '%$q%' limit 0,20 union " .
// 	"select name from drugs where name like '%$q%' limit 0,20";

$sql = "(select name from interactive_drugs where name like '%$q%') union ".
       "(select name from drugs where name like '%$q%')  order by name limit 0, 10;";

$res = mysql_query($sql);

$arr = array();
while($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
	array_push($arr, $r);
}

echo myserialize($arr);

mysql_close();
?>
