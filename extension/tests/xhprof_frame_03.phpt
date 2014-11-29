--TEST--
XHProf: xhprof_frame_* object interface
Author: bd808
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
  die('skip this test for PHP <5.5; __destruct order incompatible');
}
?>
--FILE--
<?php

include_once dirname(__FILE__).'/common.php';

function inner() {
  return;
}

function objects() {
  $frame1 = new XhprofFrame('frame1');
  inner();
  $frame2 = new XhprofFrame('frame2');
  inner();
  $frame3 = new XhprofFrame('frame3');
  inner();
}

xhprof_enable();
objects();
$output = xhprof_disable();
print_canonical($output);
echo "\n";
?>
--EXPECT--
frame1==>XhprofFrame::__construct       : ct=       1; wt=*;
frame1==>XhprofFrame::__destruct        : ct=       1; wt=*;
frame1==>frame2                         : ct=       1; wt=*;
frame1==>inner                          : ct=       1; wt=*;
frame2==>XhprofFrame::__construct       : ct=       1; wt=*;
frame2==>XhprofFrame::__destruct        : ct=       1; wt=*;
frame2==>frame3                         : ct=       1; wt=*;
frame2==>inner                          : ct=       1; wt=*;
frame3==>XhprofFrame::__construct       : ct=       1; wt=*;
frame3==>XhprofFrame::__destruct        : ct=       1; wt=*;
frame3==>inner                          : ct=       1; wt=*;
main()                                  : ct=       1; wt=*;
main()==>objects                        : ct=       1; wt=*;
main()==>xhprof_disable                 : ct=       1; wt=*;
objects==>frame1                        : ct=       1; wt=*;
