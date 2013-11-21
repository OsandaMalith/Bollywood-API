
var songs = [];
var albums = [];

var fromID = 0;
var count = 10;

var saveData=true;
var startAnotherBatch = true;

function fetchData()
{
	var listOfIds = "";
	for (var i=0;i<count;i++)
	{
		var id = fromID + i;

		listOfIds = listOfIds + id + ",";
	}
	
	if (listOfIds.length==0)
		return;

	listOfIds = listOfIds.substring(0, listOfIds.lastIndexOf(','));

	var url = "http://www.dhingana.com/xhr/getSongDetails?id=" + listOfIds;
	console.log(url);

	$.ajax({
		url: "functions.php",
		data: {
			fName: "getHtml",
			url: url
		},
		success: function(data)
		{
			try
			{
				data = $.parseJSON(data);
				parseData(data);
			}
			catch(err)
			{
				log(data);
				console.log("Error 1: " + err);
			}
		}
	})

}

function parseData(data)
{
	var qForAlbums = [];
	var qForSongs = data.queue;

	if (qForSongs == undefined)
		qForSongs = [];

	//Loop over songs
	for (var i=0;i<qForSongs.length;i++)
	{
		var id = qForSongs[i];
		var song = data.songs[id];

		try
		{
			if (song.IsDuplicate == 0 || 1)
			{	
				if (song.Singers == undefined)
					song.Singers="";
				else
					song.Singers = JSON.stringify(song.Singers);

				songs.push(song);

				if (qForAlbums.indexOf(song.Album.Id) == -1)
					qForAlbums.push(song.Album.Id);
			}

		}
		catch(err)
		{	
			console.log("Error 2: " + err);
		}
		
	}

	//Loop for albums
	for (var i=0;i<qForAlbums.length;i++)
	{
		var id = qForAlbums[i];
		var album = data.albums[id];

		try
		{
			if (album.IsDuplicate == 0 || 1)
			{
				if (album.Images == undefined)
					album.Images="";
				else
					album.Images = JSON.stringify(album.Images);

				albums.push(album);
			}
		}
		catch(err)
		{
			console.log("Error 3: " + err);
		}
	}

	console.log("Albums: " + albums.length + " -- Songs: " + songs.length + " -- Started From: " + fromID);

	if (songs.length>0)
		saveSongs();
	if (albums.length>0)
	saveAlbums();
	
	if (startAnotherBatch)
		startNewBatch();
}

function arrayToLowerCase(array)
{
	for (var i=0;i<array.length;i++)
		array[i] = array[i].toLowerCase();

	return array;
}

function startNewBatch()
{
	albums = [];
	songs = [];
	fromID = fromID + count;
	fetchData();
}

function saveAlbums()
{
	if (!saveData)
		return;
	
	$.ajax({
		url: "functions.php",
		type: "POST",
		async: false,
		data: {
			fName: "saveAlbums",
			albums: albums
		},
		success: function(data)
		{
			log(data);
		}
	})
}

function saveSongs()
{
	if (!saveData)
		return;

	$.ajax({
		url: "functions.php",
		type: "POST",
		async: false,
		data: {
			fName: "saveSongs",
			songs: songs
		},
		success: function(data)
		{
			log(data);
		}
	})
}

function stop()
{
	startAnotherBatch = false;
}

function log(str)
{
	$(".result").append(str);
}