--TEST--
XHProf: Crash with auto_append_file
--INI--
include_path={PWD}
auto_append_file=xhprof_010_append.php
--FILE--
<?php

xhprof_enable();
echo "MAIN\n";

?>
--EXPECTF--
MAIN
APPENDED
