# API Endpoints

#### Album Object
```javascript
{
  AlbumID: 10,
  Name: "Dhoom",
  AlbumArtBig: "http://c.saavncdn.com/YRM-CD-90002-150x150.jpg",
  AlbumArtSmall: "http://c.saavncdn.com/YRM-CD-90002-500x500.jpg",
  Cast: ["Abhishek Bachchan","John Abraham","Uday Chopra","Esha Deol","Rimi Sen"],
  MusicDirector: "["Pritam"]",
  Year: 2004,
  Provider: "saavn",
  *Songs: [
    Array of Song objects
  ]
}
```
*Songs - May or may not be there depending on the api endpoint

#### Song Object
```javascript
{
  SongID: 10,
  AlbumID: 1,
  Name: "Tera Mujhse - Kishore",
  Singers: "["Kishore Kumar"]",
  Mp3: "http://echpmd.dhstatic.net/media/54dc8a61/hindi-oldies/aa_gale_lag_ja/tera_mujhse___kishore.mp3",
  Provider: "dhingana",
  *Album: {
    Album object
  }
}
```
*Album - May or may not be there depending on the api endpoint

#### GET /search/albums/{album name}
  Array of album objects with songs


#### GET /search/songs/{song name}
  Array of song objects with album


#### GET /search/like/albums/{album name}
  Array of album objects with name starting from. Has song array


#### GET /search/like/songs/{song name}
  Array of song objects with name starting from. Has album object


#### GET /albums/{id}
  Album object


#### GET /albums/{id}/songs
  Album object with songs


#### GET /songs/{id}
  Song object


#### GET /songs/{id}/album
  Song object with album

#### GET /user/create
###### Response
 ```javascript
{
  "UserID": 14
}
```

#### GET /user/{userid}/activity
###### Response
 ```javascript
[
  {
    "ActivityID": 1,
    "SongID": 1,
    "Action": "AddedToPlaylist",
    "Extra": "Search, songspk",
    "Timestamp": 1385127344
  },
  ...
]
 ```

#### POST /user/{userid}/activity
###### Required Body
 ```javascript
 [
    {
        "SongID": 2,
        "Action": "AddedToPlaylist",
        "Timestamp": 1385127352,
        "Extra": "Explore, dhingana"
    },
    ...
]
```
