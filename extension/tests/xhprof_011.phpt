--TEST--
XHProf: Crash with auto_prepend_file
Author: epriestley
--INI--
include_path={PWD}
auto_prepend_file=xhprof_011_prepend.php
--FILE--
<?php

echo "MAIN\n";

?>
--EXPECTF--
PREPENDED
MAIN
