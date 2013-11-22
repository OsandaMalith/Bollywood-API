var category = "oldies";
var dUrl = "http://www.dhingana.com";
var browseBaseUrl = "http://www.dhingana.com/hindi/oldies/songs-albums-browse-";

var albums = [];

function start()
{
	for (var i=0;i<26;i++)
	{
		var browseUrl = browseBaseUrl + String.fromCharCode(i + 97);
		getAlbumsHtml(browseUrl);
	}
}

/* POPULATING ALBUMS WITH URL */
function getAlbumsHtml(browseUrl)
{
	$.ajax({
		url: "functions.php",
		async: false,
		data: {
			fName: "getHtml",
			url: browseUrl
		},
		success: function(data)
		{
			parseAlbums(data);
		}
	});
}

function parseAlbums(html)
{
	$(html).find("#allSongsList li").each(function() {
		album = {
			name: $(this).text(),
			url: dUrl + $(this).find("a").attr("href"),
			albumArt: "",
			cast: [],
			year: 0,
			musicDirector: [],
			songs: [],
			category: category
		};
		
		if (isUniqueAlbum(album))
		{
			//console.log("Adding " + album.name);
			albums.push(album);
		}
	});
	
	getSingleHtml();
}

function isUniqueAlbum(album)
{
	for (var i=0;i<albums.length;i++)
	{
		if (albums[i].url==album.url)
			return false;
	}
	return true;
}
/* END */

/* POPULATING EACH ALBUM WITH DATA AND SAVE */

function getSingleHtml()
{
	for (var i=0;i<albums.length;i++)
	{
		//console.log("Fetching data for " + albums[i].name);

		$.ajax({
			url: "functions.php",
			data: {
				fName: "getHtml",
				url: albums[i].url
			},
			async: false,
			success: function(data)
			{
				parseAlbumData(albums[i], data);
			}
		});
	}
}

function parseAlbumData(album, html)
{
	//console.log("Parsing data for " + album.name);

	album.albumArt = $(html).find(".artwork-image").attr("data-imgsrc");

	$(html).find(".detail-metadata-actions-wrapper .meta-list.content-viewport-line").each(function() {

		if ($(this).find(".title").text()=="Cast:")
		{
			$(this).find("a").each(function() {
				album.cast.push($(this).attr("data-search-keyword"));
			});
		}
		else if($(this).find(".title").text()=="Music Director:")
		{
			$(this).find("a").each(function() {
				album.musicDirector.push($(this).attr("data-search-keyword"));
			});
		}
		else
		{
			album.year = $(this).find("a").attr("data-search-keyword");
		}
	});

	$(html).find(".listing-row.work.song").each(function()
	{
		album.songs.push($(this).attr("data-id"));
	});

	fillSongData(album);
}
/* END */

/* GET SONG DATA */
function fillSongData(album)
{
	var ids = "";
	for (var i=0;i<album.songs.length;i++)
	{
		ids = ids + album.songs[i] + ",";
	}
	
	album.songs = [];

	var url = "http://www.dhingana.com/xhr/getSongDetails?id=" + ids;

	$.ajax({
		url: "functions.php",
		async: false,
		data: {
			fName: "getHtml",
			url: url
		},
		success: function(data)
		{
			data = $.parseJSON(data);
			parseSongs(album, data);
		}
	});
}

function parseSongs(album, data)
{
	var qForSongs = data.queue;

	for (var i=0;i<qForSongs.length;i++)
	{
		var id = qForSongs[i];
		var song = data.songs[id];

		try
		{
			if (song.Singers == undefined)
				song.Singers="";
			else
				song.Singers = JSON.stringify(song.Singers);

			album.songs.push(song);
		}
		catch(err)
		{	
			console.log("Error: " + err);
		}
		
	}

	saveAlbum(album);
}
/* END */

/* SAVE */
function saveAlbum(album)
{
	$.ajax({
		url: "functions.php",
		type: "POST",
		async: false,
		data: {
			fName: "saveData",
			album: album
		},
		success: function(data)
		{
			console.log(data);
		}
	});

}
/* END */
