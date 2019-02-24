<?php
class Index 
{
	
	protected $wynik = array('<tr><td colspan="4" class="empty">Brak projektów!</td></tr>'); // Informacja zwrotna
	//protected $ile; // Wszystkie rekordy
	//protected $strona; // $_GET['page']
	//protected $stron; // Liczba wszystkich stron
	//protected $limit; // Liczba rekordów na stronie
	protected $od; // od jakiego rekordu
	protected $do; // do jakiego rekordu
	
	
	public function __construct($limit)
	{
		$img = '<img src="img/folder.png" width="22" height=22" alt="=>" />'; // Link do grafiki
		$znaki = array("-","_"); // Znaki które zostana zamienione na spacje, w nazwie
		$i = 0;

		foreach(glob('projects/*', GLOB_ONLYDIR) as $folder)
		{
			if($folder != 'img' && $folder != 'kursy' && $folder != '0-Archiwum')
			{
				$info = (file_exists("$folder".'/info.txt') && filesize("$folder".'/info.txt') != 0) ? file_get_contents("$folder".'/info.txt') : '';		
				$nazwa = str_replace($znaki," ",$folder);

				$this->wynik[$i] = '<tr><td><a href="'.$folder.'" title="Otwórz projekt" target="_blank">'.$img.' <span>'.$nazwa.'</span></a></td><td class="info">'.$info.'</td></tr>';
				$i++;
			}	
		}
		clearstatcache();
		$this->setLimit($limit);
		//$this->setIle($this->wynik);
		$this->setStron($this->ile/$this->limit);
		$strona = isset($_GET['page']) ? intval($_GET['page']-1) : 0;
		$this->setGET($strona);
		$this->setOd($this->strona*$this->limit);
		$this->setDo($this->od+$this->limit);
	}
	
	
	public function lista()
	{
		$od = $this->od;
		$do = $this->do;
		for($i=$od; $i<$do; $i++)
		{
			echo $this->wynik[$i];
		}
	}
	
	public function paginacja()
	{
		$strona = $this->strona;
		$stron = $this->stron;
		
		if($strona > 10) echo '<span><a href="?page=1"> &larr; </a></span>';
		
		for($i=1; $i<=$stron; $i++)
		{
			$bold = ($i == ($strona+1)) ? 'class="selectActive"' : '';
			if( $this->granice($i, $strona-9, $strona+11) ) echo '<span><a href="?page='.$i.'" '.$bold.' >'.$i.'</a></span>';	
		}
		
		if($strona < $stron-11) echo '<span><a href="?page='.$stron.'"> &rarr; </a></span>';
	}
	
	protected function granice($val, $min, $max)
	{
		return ($val >= $min && $val <= $max);
	}
	
	
	//Settery
	protected function setLimit($limit)
	{
		//walidacja
		$this->limit = $limit;
	}	
	
	protected function setIle($wszystkich)
	{
		//walidacja
		$this->ile = count($wszystkich);
	}
	
	protected function setGET($get)
	{
		//walidacja
		$this->strona = $get;
	}
	
	protected function setStron($stron) 
	{
		$this->stron = ceil($stron);
	}
	
	protected function setOd($od)
	{
		$this->od = $od;
	}
	
	protected function setDo($do)
	{	
		if($do > $this->ile) $this->do = $this->ile;
		else $this->do = $do;
	}
	
	public function getIle()
	{
		return $this->ile;
	}
	
	
	//METODY DO TESTÓW
	
	public function paginShow()
	{
		echo 'Rekordy: '.$this->tabShow($this->wynik).'<br>';
		echo '$_GET: '.$this->strona.'<br>';
		echo 'Wszystkich: '.$this->ile.'<br>';
		echo 'Na strone: '.$this->limit.'<br>';
		echo 'Od: '.$this->od.'<br>';
		echo 'Do: '.$this->do.'<br>';
		echo 'Ile stron: '.$this->stron.'<br>';	
	}
	
	protected function tabShow($tab)
	{	
		$tab = var_dump($tab);
		return '<pre>'.$tab.'</pre>';
	}
}

$f = new Index(7);
//$f->show();

?>

