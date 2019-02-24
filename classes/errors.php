<?php

class Errors
{
	private $_err = '';

	public function __construct($nr)
	{
		switch ($nr) {
			case 404:
				$this->error404();
				break;
			
			default:
				throw new Exception('Nieoczekiwany błąd skryptu!');
				break;
		}
	}


	private function error404()
	{
		header("HTTP/1.0 404 Not Found");
		$this->_err = 'Brak takiej strony!<br>Błąd 404';
	}


	public function __toString()
	{
		return $this->_err;
	}
}

?>