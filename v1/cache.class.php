<?php

class Cache
{
	private $cacheDir = "/dev/shm/";
	private $fileName;
	public  $uniqueid;
	public  $obj;

	function __construct($uniqueid, $obj = NULL)
	{
		$this->uniqueid = $uniqueid;
		$this->fileName = $this->cacheDir.$this->uniqueid.".tmp";
		$this->obj = json_decode(json_encode($obj));
		
		if ($obj == NULL)
			$this->read();
	}

	private function read()
	{
		$contents = @file_get_contents($this->fileName);
		$this->obj = ($contents === False) ? NULL : json_decode($contents);
	}

	public function write()
	{
		if ($this->obj == NULL)
			return;
		file_put_contents($this->fileName, json_encode($this->obj));
		
		$this->read();
	}
}
?>
