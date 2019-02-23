<?php

spl_autoload_register(function ($class) {
	$class = strtolower($class);
    if(file_exists('classes/'.$class.'.php'))
    	include('classes/'.$class.'.php');
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