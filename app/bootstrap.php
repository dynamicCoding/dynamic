<?php

spl_autoload_register('loader');

function loader($classes){
	$file = [];
	$load = [
		'prefix' => '\\', 
		'path' => '', 
		'psr4' => [
			'App\\' => ILLUM_PATH . '/app/',
			'Illustrator\\' => ILLUM_PATH . '/library/'
		],
		'script' => ILLUM_PATH . '/library/helper/app.php'
	];
	
	if(!empty($load['script'])){
		$script = is_array($load['script']) ? $load['script'] : [$load['script']];
		foreach($script as $script_file){
			$file[] = $script_file;
		}
	};
	
	foreach($load['psr4'] as $psr => $path){
		if(strpos($classes, $psr) !== false){
			$_ = substr($classes, strlen($psr));
			$classes = str_replace($load['prefix'], '/', $_);
			$file[] = $path.$classes.'.php';
		}
	}
	
	foreach($file as $file){
		if(file_exists($file)){
			includeFile($file);
		}
	}
} 

function includeFile($file){
	include $file;
}