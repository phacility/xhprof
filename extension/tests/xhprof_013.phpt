--TEST--
XHProf: PHP 5.6 crash in hp_execute_internal
Author: msonnabaum
--FILE--
<?php
xhprof_enable();
$test = array('test', 'test2');

array_pop($test);
echo "OK\n";
?>
--EXPECT--
OK
