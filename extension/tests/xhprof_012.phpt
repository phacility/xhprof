--TEST--
XHProf: Memory Leak in Ignored Functions
Author: epriestley
--FILE--
<?php

$old = memory_get_usage();

// This test covers a leak where the ignored function list would not be
// deallocated properly after a new call to xhprof_enable().

$large = str_repeat('x', (1024 * 1024 * 16));
xhprof_enable(0, array('ignored_functions' => array($large)));
xhprof_disable();
unset($large);

xhprof_enable();
xhprof_disable();

$new = memory_get_usage();

$missing = ($new - $old);

if ($missing >= (1024 * 1024 * 16)) {
  echo "LEAKED A LOT OF MEMORY\n";
} else {
  echo "DID NOT LEAK A LOT OF MEMORY\n";
}

?>
--EXPECTF--
DID NOT LEAK A LOT OF MEMORY
