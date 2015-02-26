--TEST--
XHProf: PHP 5.5 crash in hp_execute_internal
Author: epriestley
--FILE--
<?php

function loader() {
  // <empty>
}

spl_autoload_register('loader', $throw = true);

xhprof_enable();

class_exists('ThisClassDoesNotExist');
echo "OK\n";

--EXPECT--
OK
