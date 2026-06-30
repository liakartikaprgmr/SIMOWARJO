<?php

echo "<pre>";

$path = dirname(__DIR__, 2); 

chdir($path);

echo shell_exec("git fetch 2>&1");
echo shell_exec("git status 2>&1");

echo "</pre>";