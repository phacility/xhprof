--TEST--
XHProf: xhprof_frame_* procedural interface
Author: bd808
--FILE--
<?php

include_once dirname(__FILE__).'/common.php';

function inner() {
  return;
}

function prodedural() {
  xhprof_frame_begin('frame1');
  inner();
  xhprof_frame_begin('frame2');
  inner();
  xhprof_frame_begin('frame3');
  inner();
  xhprof_frame_end();
  xhprof_frame_end();
  xhprof_frame_end();
}

xhprof_enable();
prodedural();
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
main()==>prodedural                     : ct=       1; wt=*;
main()==>xhprof_disable                 : ct=       1; wt=*;
prodedural==>frame1                     : ct=       1; wt=*;
