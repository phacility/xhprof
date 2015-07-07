--TEST--
XHProf: Crash with array_pop
Author: cxfksword
--FILE--
<?php

xhprof_enable();
$arr = array('OK');
$ok = array_pop($arr);
echo "$ok\n";

?>
--EXPECTF--
OK
