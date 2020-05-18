<?php

//Récupération de toutes les musiques
function getAllSongs(){
    $db = dbConnect();
    $query = $db->query('SELECT * FROM songs ORDER BY title');
    $songs =  $query->fetchAll();

    return $songs;
}

//Ajout d'un morceau en db
function addSong($informations)
{
    $db = dbConnect();

    $query = $db->prepare("INSERT INTO songs (title, artist_id, album_id) VALUES( :title, :artist_id, :album_id)");
    $result = $query->execute([
        'title' => $informations['title'],
        'artist_id' => $informations['artist'],
        'album_id' => $informations['album'],
    ]);

    return $result;
}

//Récupération des informations d'un morceau
function getSong($id)
{
    $db = dbConnect();

    $query = $db->prepare("SELECT * FROM songs WHERE id = ?");
    $query->execute([
        $id
    ]);

    $result = $query->fetch();

    return $result;
}

//Mise à jour des données en db
function updateSong($id, $informations)
{
    $db = dbConnect();

    $query = $db->prepare('UPDATE songs SET title = ?, artist_id = ?, album_id = ? WHERE id = ?');

    $result = $query->execute(
        [
            $informations['title'],
            $informations['artist'],
            $informations['album'],
            $id,
        ]
    );

    return $result;
}

//Supprimer un morceau en db
function deleteSong($id)
{
    $db = dbConnect();

    $query = $db->prepare('DELETE FROM songs WHERE id = ?');
    $result = $query->execute([$id]);

    return $result;
}