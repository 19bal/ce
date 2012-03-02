<?php

require_once  'lib/base.php';  // for fat-free
require_once  'inc/lib.php';   // for plug-in
require_once  'cfg/init.php';  // for db connect

F3::route("GET  /*",           'Page->home');
F3::route("GET  /about",       'Page->about');

F3::route("GET  /prescription",'Page->prescription'); // drug prescription
F3::route("POST /prescription_result",'Page->prescription_result');

F3::route("GET  /drug",        'Page->drug');         // only drug
F3::route("POST /drugs",       'Page->drugs');

F3::route("GET  /drugcontent", 'Page->drugcontent');  // drug subhead
F3::route("POST /drugscontent",'Page->drugscontent');

F3::route("GET  /review",      'Page->review');
F3::route("GET  /show/@id",    'Page->show');

// F3::route("GET  /newdrugs",    'newdrugs');       // new drugs table create
F3::run();

?>
