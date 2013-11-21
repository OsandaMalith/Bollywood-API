var dUrl = "http://www.dhingana.com";
var browseUrl = "http://www.dhingana.com/hindi/latest/songs-albums-browse";

var albums = [];

/* POPULATING ALBUMS WITH URL */
function getAlbumsHtml()
{
	$.ajax({
		url: "functions.php",
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
			songs: []
		};
		
		if (uniqueAlbum(album))
		{
			//console.log("Adding " + album.name);
			albums.push(album);
		}
	});
	
	getSingleHtml();
}

function uniqueAlbum(album)
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
				parseAlbumData(i, data);
			}
		});
	}
}

function parseAlbumData(index, html)
{
	var album = albums[index];
	
	//console.log("Parsing data for " + album.name);

	album.albumArt = $(html).find(".artwork-image").attr("data-imgsrc");

	var counter = 0;
	$(html).find(".detail-metadata-actions-wrapper .meta-list.content-viewport-line").each(function() {

		if (counter==0) //CAST
		{
			$(this).find("a").each(function() {
				album.cast.push($(this).attr("data-search-keyword"));
			});
		}
		else if(counter==1) //Music Director
		{
			$(this).find("a").each(function() {
				album.musicDirector.push($(this).attr("data-search-keyword"));
			});
		}
		else if(counter==2) //Year
		{
			album.year = $(this).find("a").attr("data-search-keyword");
		}

		counter++;
	});

	$(html).find(".listing-row.work.song").each(function()
	{
		album.songs.push($(this).attr("data-id"));
	});

	albums[index] = album;

	saveAlbum(album);
}

function saveAlbum(album)
{
	$.ajax({
		url: "functions.php",
		type: "POST",
		async: false,
		data: {
			fName: "saveAlbum",
			album: album
		},
		success: function(data)
		{
			console.log(data);
		}
	});

}
/* END */