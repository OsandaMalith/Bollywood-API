# API Endpoints

#### GET /search/albums/{album name}
```javascript
 [
  {
    "AlbumID": 22249,
    "Name": "Rockstar",
    "Type": "latest",
    "Genre": "hindi",
    "Likes": 219,
    "Favorites": 154,
    "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"}}",
    "MusicDirector": null,
    "Cast": null,
    "Year": null,
    "URL": "http:\/\/www.dhingana.com\/hindi\/rockstar-songs-ranbir-kapoor-nargis-fakhri-latest-39bd3d1",
    "Songs": [
      
    ]
  }
]
```


#### GET /search/songs/{song name}
```javascript
[
  {
    "AlbumID": 22249,
    "Name": "Rockstar",
    "Type": "latest",
    "Genre": "hindi",
    "Likes": 219,
    "Favorites": 154,
    "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/rockstar-latestmovies-6909942214e869d3b9bfee4.56044267.jpg\"}}",
    "MusicDirector": null,
    "Cast": null,
    "Year": null,
    "URL": "http:\/\/www.dhingana.com\/hindi\/rockstar-songs-ranbir-kapoor-nargis-fakhri-latest-39bd3d1",
    "Songs": [
      
    ]
  }
]
```



#### GET /albums/{id}
```javascript
{
  "AlbumID": 123,
  "Name": "Mujhse Shaadi Karogi",
  "Type": "latest",
  "Genre": "hindi",
  "Likes": 11,
  "Favorites": 6,
  "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/mujhse-shaadi-karogi-15628326695177b6549cae32.70416968.jpg\"}}",
  "MusicDirector": null,
  "Cast": null,
  "Year": null,
  "URL": "http:\/\/www.dhingana.com\/hindi\/mujhse-shaadi-karogi-songs-salman-khan-akshay-kumar-latest-34505d1"
}
```


#### GET /albums/{id}/songs
```javascript
 {
  "AlbumID": 45432,
  "Name": "Pathri Aali Bigdi Banade",
  "Type": "album",
  "Genre": "haryanvi",
  "Likes": 0,
  "Favorites": 0,
  "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/pathri-aali-bigdi-banade-haryanvi-album-32744591550a4e84b47c8d4.62127290.jpg\"}}",
  "MusicDirector": null,
  "Cast": null,
  "Year": null,
  "URL": "http:\/\/www.dhingana.com\/haryanvi\/pathri-aali-bigdi-banade-songs-2849fd1",
  "Songs": [
    {
      "SongID": 309917,
      "AlbumID": 45432,
      "Name": "Main Aai Tere Dar",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/main_aai_tere_dar.mp3"
    },
    {
      "SongID": 309918,
      "AlbumID": 45432,
      "Name": "Chalo Bebe Chalange",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/chalo_bebe_chalange.mp3"
    },
    {
      "SongID": 309919,
      "AlbumID": 45432,
      "Name": "Main Dukhiya Dar Te",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/main_dukhiya_dar_te.mp3"
    },
    {
      "SongID": 309920,
      "AlbumID": 45432,
      "Name": "Main Mata Dhokan Jaun",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/main_mata_dhokan_jaun.mp3"
    },
    {
      "SongID": 309921,
      "AlbumID": 45432,
      "Name": "Mera Kariye Beda Paar",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/mera_kariye_beda_paar.mp3"
    },
    {
      "SongID": 309922,
      "AlbumID": 45432,
      "Name": "Meri Bigdi Baat Banaiye",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/meri_bigdi_baat_banaiye.mp3"
    },
    {
      "SongID": 309923,
      "AlbumID": 45432,
      "Name": "Sasu Sun Baat Meri",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/sasu_sun_baat_meri.mp3"
    },
    {
      "SongID": 309924,
      "AlbumID": 45432,
      "Name": "Pathri Aali Maa",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/pathri_aali_maa.mp3"
    },
    {
      "SongID": 309925,
      "AlbumID": 45432,
      "Name": "Tu Hi Ambe Tu Hi Kali",
      "Singers": "[\"\"]",
      "Likes": 0,
      "Dislikes": 0,
      "Favorites": 0,
      "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/haryanvi-album\/pathri_aali_bigdi_banade\/tu_hi_ambe_tu_hi_kali.mp3"
    }
  ]
}
```


#### GET /songs/{id}
```javascript
{
  "SongID": 1233,
  "AlbumID": 95,
  "Name": "Love Love Tum Karo",
  "Singers": "[\"Sonu Nigam\",\"Priya\",\"Prachi\"]",
  "Likes": 15,
  "Dislikes": 3,
  "Favorites": 6,
  "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/latestmovies\/ishq_vishk\/love_love_tum_karo_s.mp3"
}
```

#### GET /songs/{id}/album
```javascript
{
  "SongID": 1233,
  "AlbumID": 95,
  "Name": "Love Love Tum Karo",
  "Singers": "[\"Sonu Nigam\",\"Priya\",\"Prachi\"]",
  "Likes": 15,
  "Dislikes": 3,
  "Favorites": 6,
  "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/latestmovies\/ishq_vishk\/love_love_tum_karo_s.mp3",
  "Album": {
    "AlbumID": 95,
    "Name": "Ishq Vishk",
    "Type": "latest",
    "Genre": "hindi",
    "Likes": 33,
    "Favorites": 16,
    "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"}}",
    "MusicDirector": null,
    "Cast": null,
    "Year": null,
    "URL": "http:\/\/www.dhingana.com\/hindi\/ishq-vishk-songs-shahid-kapoor-amrita-rao-latest-32905d1"
  }
}
```


#### GET /playlist
```javascript
 [
  {
    "SongID": 11,
    "AlbumID": 2,
    "Name": "Pyar Hai",
    "Singers": "[\"Adnan Sami\",\"Asha Bhosle\"]",
    "Likes": 122,
    "Dislikes": 12,
    "Favorites": 41,
    "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/pop\/adnan_sami___kabhi_to_nazar_milao\/pyar_hai_duet.mp3",
    "Album": {
      "AlbumID": 2,
      "Name": "Kabhi To Nazar Milao",
      "Type": "pop",
      "Genre": "hindi",
      "Likes": 214,
      "Favorites": 69,
      "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/kabhi-to-nazar-milao-17638296865264f78c8099d4.53721958.jpg\"}}",
      "MusicDirector": null,
      "Cast": null,
      "Year": null,
      "URL": "http:\/\/www.dhingana.com\/hindi\/kabhi-to-nazar-milao-songs-pop-26605d1"
    }
  },
  {
    "SongID": 1231,
    "AlbumID": 95,
    "Name": "Ishq Vishk Pyar Vyar",
    "Singers": "[\"Alka Yagnik\",\"Kumar Sanu\"]",
    "Likes": 102,
    "Dislikes": 19,
    "Favorites": 37,
    "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/latestmovies\/ishq_vishk\/ishq_vishk_pyar_vyar_s.mp3",
    "Album": {
      "AlbumID": 95,
      "Name": "Ishq Vishk",
      "Type": "latest",
      "Genre": "hindi",
      "Likes": 33,
      "Favorites": 16,
      "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/ishq-vishk-156173018050c6c509bc4ba8.92442817.jpg\"}}",
      "MusicDirector": null,
      "Cast": null,
      "Year": null,
      "URL": "http:\/\/www.dhingana.com\/hindi\/ishq-vishk-songs-shahid-kapoor-amrita-rao-latest-32905d1"
    }
  },
  {
    "SongID": 32423,
    "AlbumID": 787,
    "Name": "Shayad Main Zindagi Ki Sahar",
    "Singers": "[\"Jagjit Singh\",\"Chitra Singh\"]",
    "Likes": 33,
    "Dislikes": 3,
    "Favorites": 19,
    "Mp3": "http:\/\/echpmd.dhstatic.net\/media\/54dc8a61\/ghazals\/the_latest___chitra\/shayad_main_zindagi_ki_sahar.mp3",
    "Album": {
      "AlbumID": 787,
      "Name": "The Latest - Chitra",
      "Type": "ghazals",
      "Genre": "hindi",
      "Likes": 16,
      "Favorites": 14,
      "AlbumArt": "{\"32x32\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_32\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"40x40\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_40\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"75x75\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_75\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"100x100\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_100\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"102x102\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_102\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"134x134\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_134\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"148x148\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_148\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"150x150\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_150\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"300x300\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_300\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"},\"640x640\":{\"Url\":\"http:\\\/\\\/ecs3cdn.dhstatic.net\\\/images\\\/small_640\\\/the-latest-chitra-147240555750174b14139890.19822377.jpg\"}}",
      "MusicDirector": null,
      "Cast": null,
      "Year": null,
      "URL": "http:\/\/www.dhingana.com\/hindi\/the-latest-chitra-songs-ghazals-37785d1"
    }
  },
  {
    "Album": null
  }
]
```

#### POST /playlist
```javascript
[
  123,
  1234,
  12234,
  453
]
```

#### GET /user/create
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
