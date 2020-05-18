<?php
//Récupération de tout les albums
function getAllAlbums(){
    $db = dbConnect();
    $query = $db->query('SELECT * FROM albums ORDER BY name');
    $albums =  $query->fetchAll();

    return $albums;
}


//Ajout d'un morceau en db
function addAlbum($informations)
{
    $db = dbConnect();

    $query = $db->prepare("INSERT INTO albums (name, artist_id, year) VALUES( :name, :artist_id, :year)");
    $result = $query->execute([
        'name' => $informations['title'],
        'artist_id' => $informations['artist'],
        'year' => $informations['year'],
    ]);

    return $result;
}

//Récupération des informations d'un morceau
function getAlbum($id)
{
    $db = dbConnect();

    $query = $db->prepare("SELECT * FROM albums WHERE id = ?");
    $query->execute([
        $id
    ]);

    $result = $query->fetch();

    return $result;
}

//Mise à jour des données en db
function updateAlbum($id, $informations)
{
    $db = dbConnect();

    $query = $db->prepare('UPDATE albums SET name = ?, artist_id = ?, year = ? WHERE id = ?');

    $result = $query->execute(
        [
            $informations['title'],
            $informations['artist'],
            $informations['year'],
            $id,
        ]
    );

    return $result;
}

//Supprimer un morceau en db
function deleteAlbum($id)
{
    $db = dbConnect();

    $query = $db->prepare('DELETE FROM albums WHERE id = ?');
    $result = $query->execute([$id]);

    return $result;
}