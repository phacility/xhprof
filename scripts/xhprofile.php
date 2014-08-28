#!/usr/bin/env php
<?php

// Profile a CLI script.

if ($argc < 2) {
  throw new Exception('usage: xhprofile <script>');
}

$__xhprof_target__ = $argv[1];

$argv = array_slice($argv, 1);
$argc = count($argv);

xhprof_enable();
require_once $__xhprof_target__;
$xhprof_data = xhprof_disable();

var_dump($xhprof_data);
