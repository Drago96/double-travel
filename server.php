<?php

define('ROOT', str_replace("server.php", "", $_SERVER["SCRIPT_FILENAME"]));

require_once(ROOT . 'Core/Entry/Dispatcher.php');

$dispatcher = new Dispatcher();
$dispatcher->dispatch();
