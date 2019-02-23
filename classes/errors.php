<?php

class Errors
{
	public function error404()
	{
		header("HTTP/1.0 404 Not Found");
		echo 'Klasa Errors -> index <br>';
	}
}

?>