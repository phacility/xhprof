--TEST--
xhprof + auto_append_file
--INI--
auto_append_file=./xhprof_append_test_artefact.php
--FILE--
<?php

file_put_contents("./xhprof_append_test_artefact.php", "<?php var_dump('append'); ?>");

xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);

echo "END\n";
?>
--EXPECTF--
END
string(6) "append"
