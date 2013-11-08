
var songs = [];
var albums = [];

var fromID = 0;
var count = 300;

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
				$("body").html(data);
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
	{
		console.log("Couldn't find any songs in this batch.");
		startNewBatch();
		return;
	}

	//Loop over songs
	for (var i=0;i<qForSongs.length;i++)
	{
		var id = qForSongs[i];
		var song = data.songs[id];

		try
		{
			if (song.IsDuplicate == 0)
			{
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
			if (album.IsDuplicate == 0)
			{
				albums.push(album);
			}
		}
		catch(err)
		{
			console.log("Error 3: " + err);
		}
	}

	console.log("Albums: " + albums.length + " -- Songs: " + songs.length + " -- Started From: " + fromID);

	if (startAnotherBatch)
	{
		saveSongs();
		saveAlbums();
		startNewBatch();
	}
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
	$.ajax({
		url: "functions.php",
		type: "POST",
		data: {
			fName: "saveAlbums",
			albums: albums
		},
		success: function(data)
		{
			$("body").html(data);
		}
	})
}

function saveSongs()
{
	$.ajax({
		url: "functions.php",
		type: "POST",
		data: {
			fName: "saveSongs",
			songs: songs
		},
		success: function(data)
		{
			$("body").html(data);
		}
	})
}
