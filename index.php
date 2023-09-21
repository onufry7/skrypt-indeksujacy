<?php

spl_autoload_register(function ($class) {
	$file = strtolower($class);
    if(file_exists('classes/'.$file.'.php'))
    	include('classes/'.$file.'.php');
	else throw new Exception('Nie udało się wczytać klasy '.$class);
});

try
{
	$router = new Router;
}
catch (Exception $e) 
{
	echo 'Wystąpił błąd na stronie: '.$e->getMessage()."\n";
}

?>