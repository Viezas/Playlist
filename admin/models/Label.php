<?php

//Récupération de toutes les labels
function getAllLabels(){
    $db = dbConnect();
    $query = $db->query('SELECT * FROM labels ORDER BY name');
    $labels =  $query->fetchAll();

    return $labels;
}

//Ajout d'un morceau en db
function addLabel($information)
{
    $db = dbConnect();

    $query = $db->prepare("INSERT INTO labels (name) VALUES (:name)");
    $result = $query->execute([
        'name' => $information['name'],
    ]);

    return $result;
}

function getLabel($id)
{
    $db = dbConnect();

    $query = $db->prepare("SELECT * FROM labels WHERE id = ?");
    $query->execute([
        $id
    ]);

    $result = $query->fetch();

    return $result;
}

//Mise à jour des données en db
function updateLabel($id, $information)
{
    $db = dbConnect();

    $query = $db->prepare('UPDATE labels SET name = ? WHERE id = ?');

    $result = $query->execute(
        [
            $information['name'],
            $id,
        ]
    );

    return $result;
}

//Supprimer un label en db
function deleteLabel($id)
{
    $db = dbConnect();

    $query = $db->prepare('DELETE FROM labels WHERE id = ?');
    $result = $query->execute([$id]);

    return $result;
}