<?php
require_once("common.php");

abstract class Period
{
	const HOUR = 3600;
	const DAY  = 86400;
	const WEEK = 604800;
}

abstract class SongOrigin
{
	const ANY = "";
	const EXPLORE = "Explore";
	const DOWNLOADS = "Downloads";
	const SEARCH = "Search";
}

abstract class Provider
{
	const ANY = "";
	const DHINGANA = "dhingana";
	const PK = "songspk";
}

abstract class Action
{
	const LISTENED = "FinishedListening";
	const DOWNLOADED = "Downloaded";
	const DELETED_DOWNLOADS = "DeletedFromDownloads";
	const ADDED_PLAYLIST = "AddedToPlaylist";
	const REMOVED_PLAYLIST = "DeletedFromPlaylist";
}

class Statistics
{
	private $currentTime;
	private $dataPeriodRange;
	public  $labels = array();
	public  $data = array();
	public  $period;
	public  $periodCount;
	public  $isCumulative;
	public  $action;
	public  $songOriginFilter;
	public  $providerFilter;

	function __construct($period, $periodCount, $action, $songOrigin = SongOrigin::ANY, $provider = Provider::ANY, $isCumulative = false)
	{
		$this->currentTime = time();
		$this->period = $period;
		$this->periodCount = $periodCount;
		$this->isCumulative = $isCumulative;	
		$this->action = $action;
		$this->songOriginFilter = "%".$songOrigin."%";
		$this->providerFilter = "%".$provider."%";

		$this->dataPeriodRange["from"] = $this->currentTime - ($period * $periodCount);
		$this->dataPeriodRange["to"] = $this->dataPeriodRange["from"] + $period;
		
		$this->createLabels();
	}

	public function fetchStats()
	{
		global $link;
		
		$cumCount = 0;
		for ($i=0;$i<$this->periodCount;$i++)
		{
			$data = $link->prepare("select count(*) as count from activity where Action=? and 
												Timestamp>=? and 
												Timestamp<? and
												Extra like ? and
												Provider like ?");
			$data->bind_param("siiss", $this->action, 
							$this->dataPeriodRange["from"], 
							$this->dataPeriodRange["to"], 
							$this->songOriginFilter, 
							$this->providerFilter);
			$data->execute();
			$data->bind_result($count);
			$data->fetch();
			$data->close();	
			
			$cumCount = $cumCount + $count;
			array_push($this->data, ($this->isCumulative) ? $cumCount : $count);
			$this->setNextPeriodRange();
		}
	}

	private function createLabels()
	{
		for ($i=0;$i<$this->periodCount;$i++)
		{
			array_push($this->labels, $i);
		}
	}
	
	private function setNextPeriodRange()
	{
		$this->dataPeriodRange["from"] = $this->dataPeriodRange["from"] + $this->period;
		$this->dataPeriodRange["to"] = $this->dataPeriodRange["to"] + $this->period;
	}
	
}

$stat = new Statistics(Period::HOUR, 48, Action::DOWNLOADED, SongOrigin::ANY, Provider::ANY, true);
$stat->fetchStats();
echo json_encode($stat);

?>
