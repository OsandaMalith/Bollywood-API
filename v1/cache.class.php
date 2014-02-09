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
		$this->obj = $obj;
		
		if ($obj == NULL)
			$this->read();
		else
			$this->write();
	}

	private function read()
	{
		$contents = @file_get_contents($this->fileName);
		$this->obj = ($contents === False) ? NULL : unserialize($contents);
	}

	private function write()
	{
		global $accessLevel;
		if ($this->obj == NULL || $accessLevel == 0)
			return;
		file_put_contents($this->fileName, serialize($this->obj));
		
		$this->read();
	}
}

?>
