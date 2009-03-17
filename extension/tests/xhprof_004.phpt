--TEST--
XHPRrof: Test Include File (load/run_init operations)
Author: Kannan
--FILE--
<?php

include_once dirname(__FILE__).'/common.php';

xhprof_enable();

// Include File:
//
// Note: the 2nd and 3rd attempts should be no-ops and
// will not show up in the profiler data. Only the first
// one should.

include_once dirname(__FILE__).'/xhprof_004_inc.php';
include_once dirname(__FILE__).'/xhprof_004_inc.php';
include_once dirname(__FILE__).'/xhprof_004_inc.php';

$output = xhprof_disable();

echo "Test for 'include' operation\n";
print_canonical($output);
echo "\n";

?>
--EXPECT--
abc,def,ghi
I am in foo()...
Test for 'include' operation
main()                                  : ct=       1; wt=*;
main()==>dirname                        : ct=       3; wt=*;
main()==>load::tests/xhprof_004_inc.php : ct=       1; wt=*;
main()==>run_init::tests/xhprof_004_inc.php: ct=       1; wt=*;
main()==>xhprof_disable                 : ct=       1; wt=*;
run_init::tests/xhprof_004_inc.php==>explode: ct=       1; wt=*;
run_init::tests/xhprof_004_inc.php==>foo: ct=       1; wt=*;
run_init::tests/xhprof_004_inc.php==>implode: ct=       1; wt=*;
