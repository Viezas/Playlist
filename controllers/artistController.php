<?php

if(!isset($_GET['artist_id']) || !ctype_digit($_GET['artist_id'])){
  header('Location:index.php');
  exit;
}

require_once 'models/album.php';
require_once 'models/artist.php';
require_once 'models/Label.php';

$artist = getArtist($_GET['artist_id']);

if($artist == false){
  header('Location:index.php');
  exit;
}

$albums = getAlbums($artist['id']);
$label = getLabel($artist['id']);
include 'views/artist.php';
