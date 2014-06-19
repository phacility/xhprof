--TEST--
XHPRrof: Test excluding call_user_func and similar functions
Author: mpal
--FILE--
<?php

include_once dirname(__FILE__).'/common.php';

function test_stringlength($string)
{
    return strlen($string);
}

xhprof_enable(XHPROF_FLAGS_MEMORY, array('functions' => array('strlen')));
test_stringlength('foo_array');
$output = xhprof_disable();

if (count($output) == 2 && isset($output['main()']) && isset($output['main()==>strlen'])) {
    echo "Test passed";
} else {
    var_dump($output);
}
?>
--EXPECT--
Test passed
