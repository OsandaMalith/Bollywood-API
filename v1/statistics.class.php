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
	const ACTIVE_USERS = "ActiveUsers";
	const SIGNUPS = "Signups";
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
		$this->currentTime = time() /*- (24*3600)*/;
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
		
		$cumCount = $this->initialCumCount();
		for ($i=0;$i<$this->periodCount;$i++)
		{
			if ($this->action == Action::SIGNUPS)
			{
				$data = $link->prepare("select count(*) as count from users where CreatedOn>=? and CreatedOn<?");
				$data->bind_param("ii", $this->dataPeriodRange["from"], $this->dataPeriodRange["to"]);
			}
			else if($this->action == Action::ACTIVE_USERS)
			{
				$data = $link->prepare("select count(distinct UserID) from activity where Timestamp>=? and Timestamp<?");
				$data->bind_param("ii", $this->dataPeriodRange["from"], $this->dataPeriodRange["to"]);
			}
			else
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
			}
			$data->execute();
			$data->bind_result($count);
			$data->fetch();
			$data->close();	
			
			$cumCount = $cumCount + $count;
			array_push($this->data, ($this->isCumulative) ? $cumCount : $count);
			$this->setNextPeriodRange();
		}
	}

	private function initialCumCount()
	{
		global $link;

		if ($this->action == Action::SIGNUPS)
		{
			$data = $link->prepare("select count(*) as count from users where CreatedOn<? or CreatedOn is null");
			$data->bind_param("i", $this->dataPeriodRange["from"]);
		}
		else if($this->action == Action::ACTIVE_USERS)
		{
			$data = $link->prepare("select count(distinct UserID) from activity where Timestamp<?");
			$data->bind_param("i", $this->dataPeriodRange["from"]);
		}
		else
		{
			$data = $link->prepare("select count(*) as count from activity where Action=? and 
												Timestamp<? and
												Extra like ? and
												Provider like ?");
			$data->bind_param("siss", $this->action, 
							$this->dataPeriodRange["from"], 
							$this->songOriginFilter, 
							$this->providerFilter);
		}
		$data->execute();
		$data->bind_result($count);
		$data->fetch();
		$data->close();
		
		return $count;	
	}

	private function createLabels()
	{
		for ($i=0;$i<$this->periodCount;$i++)
		{
			array_push($this->labels, "$i");
		}
	}
	
	private function setNextPeriodRange()
	{
		$this->dataPeriodRange["from"] = $this->dataPeriodRange["from"] + $this->period;
		$this->dataPeriodRange["to"] = $this->dataPeriodRange["to"] + $this->period;
	}
	
}

?>
