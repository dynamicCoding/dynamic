<?php

define('ILLUM_PATH', dirname(__DIR__));

session_start();

$vendor = ILLUM_PATH . '/vendor/autoload.php';

if(file_exists($vendor)){
	include $vendor;
}else{
	include ILLUM_PATH . '/app/boostrap.php';
}