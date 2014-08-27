--TEST--
XHProf: Function Argument Profiling
--FILE--
<?php

include_once dirname(__FILE__).'/common.php';

function foo($str) {
    return strlen($str);
}

xhprof_enable(0, array('argument_functions' => array('strlen')));

foo("bar");
foo("baz");
foo("baz");

print_canonical(xhprof_disable());
--EXPECT--
foo==>strlen#bar                        : ct=       1; wt=*;
foo==>strlen#baz                        : ct=       2; wt=*;
main()                                  : ct=       1; wt=*;
main()==>foo                            : ct=       3; wt=*;
main()==>xhprof_disable                 : ct=       1; wt=*;
