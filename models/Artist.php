<?php

function getArtists($label_id = false)
{
    $db = dbConnect();

    if ($label_id ){
        $query = $db->prepare("
        SELECT a.* 
        FROM artists a 
        JOIN artists_labels al ON a.id= al.artist_id
        WHERE al.label_id= ?
        ");
        $query-> execute([
            $label_id
        ]);
    }
    else{
        $query = $db->query('SELECT * FROM artists');
    }

    $result = $query->fetchAll();
    return $result;
}

function getArtist($artistId)
{


    $selectedArtist = false;
    foreach(getArtists() as $artist){
        if($artist['id'] == $artistId){
            $selectedArtist = $artist;
        }
    }
    return $selectedArtist;
}
