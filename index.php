<?php

require_once  'lib/base.php';  // for fat-free
require_once  'inc/lib.php';   // for plug-in
require_once  'cfg/init.php';  // for db connect

F3::route("GET  /*",          'Page->home');
F3::route("GET  /info",       'Page->info');
F3::route("GET  /drug",       'Page->drug');
F3::route("POST /drugs",      'Page->drugs');
F3::route("GET  /show/@id",   'Page->show');

F3::route("GET  /review",     'Page->review');


F3::run();

?>
