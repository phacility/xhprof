--TEST--
XHProf: xhprof_frame_* mixed procedural and object, XHPROF_FLAGS_NO_BUILTINS
Author: bd808
--FILE--
<?php

include_once dirname(__FILE__).'/common.php';

function inner() {
  return;
}

function mixed() {
  $frame1 = new XhprofFrame('frame1');
  inner();
  xhprof_frame_begin('frame2');
  inner();
  $frame3 = new XhprofFrame('frame3');
  inner();
  unset($frame3);
  xhprof_frame_end();
}

xhprof_enable(XHPROF_FLAGS_NO_BUILTINS);
mixed();
$output = xhprof_disable();
print_canonical($output);
echo "\n";
?>
--EXPECT--
frame1==>frame2                         : ct=       1; wt=*;
frame1==>inner                          : ct=       1; wt=*;
frame2==>frame3                         : ct=       1; wt=*;
frame2==>inner                          : ct=       1; wt=*;
frame3==>inner                          : ct=       1; wt=*;
main()                                  : ct=       1; wt=*;
main()==>mixed                          : ct=       1; wt=*;
mixed==>frame1                          : ct=       1; wt=*;
