<?php

echo phpversion('xhprof') . "\n";
xhprof_enable(0, array('argument_functions' => array('PDOStatement::execute', 'PDO::query')));

$pdo = new PDO('sqlite:memory:', 'root', '');

$stmt = $pdo->prepare("SELECT 1");
$stmt->execute();

$stmt = $pdo->query("SELECT 1");
$stmt->execute();

var_dump(xhprof_disable());
