# API Endpoints

#### Album Object
```javascript
{
  AlbumID: 10,
  URL: "http://www.dhingana.com/hindi/aadmi-songs-dilip-kumar-waheeda-rehman-oldies-30f4bd1",
  AlbumArt: "http://ecs3cdn.dhstatic.net/images/small_148/aadmi-25390767151fa064f78edb2.49249312.Jpg",
  Category: "oldies",
  Name: "Aadmi",
  Cast: "["Dilip Kumar","Waheeda Rehman","Manoj Kumar","Simi Garewal","Pran","Sulochana","Agha","Ulhas"]",
  MusicDirector: "["Naushad"]",
  Year: 1968,
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
  DhinganaID: 543424,
  Name: "Tera Mujhse - Kishore",
  Singers: "["Kishore Kumar"]",
  Size: 2715968,
  Duration: 339383,
  Mp3: "http://echpmd.dhstatic.net/media/54dc8a61/hindi-oldies/aa_gale_lag_ja/tera_mujhse___kishore.mp3",
  Likes: 36,
  Dislikes: 0,
  Favorites: 0,
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



#### GET /albums/{id}
  Album object


#### GET /albums/{id}/songs
  Album object with songs


#### GET /songs/{id}
  Song object

#### GET /songs/{id}/album
  Song object with album


#### GET /playlist
  Array of song objects with album

#### POST /playlist
###### Required Body
```javascript
[
  123,
  1234,
  12234,
  453
]
```
Numbers are SongIDs

#### GET /user/create
###### Response
 ```javascript
{
  "UserID": 14,
  "Password": "UnsecurePassword"
}
```

#### POST /user/login
###### Required Body
```javascript
 {"userid":14,"password":"UnsecurePassword"}
```
###### Response
```javascript
{"message":"success"}
```

#### GET /activity
###### Response
 ```javascript
[
  {
    "ActivityID": 1,
    "SongID": 1,
    "Type": "listen",
    "Timestamp": 1385127344
  },
  ...
  {
    "ActivityID": 3,
    "SongID": 20,
    "Type": "skip",
    "Timestamp": 1385127314
  }
]
 ```

#### POST /activity
###### Required Body
 ```javascript
 [
    {
        "SongID": 2,
        "Type": "listen",
        "Timestamp": 1385127352
    },
    ...
    {
        "SongID": 20,
        "Type": "skip",
        "Timestamp": 1385127314
    }
]
```