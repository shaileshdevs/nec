<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'config.php';
require_once 'controller/class-base.php';

$base = Base::get_instance();
$base->render();
