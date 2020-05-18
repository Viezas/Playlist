<?php

function getLabel($id){
    $db = dbConnect();
    $query = $db->prepare("SELECT * FROM labels WHERE id= ?");
    $query-> execute([
        $id
    ]);
    $label =  $query->fetch();

    return $label;
}