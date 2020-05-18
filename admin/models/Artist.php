<?php

function getAllArtists()
{
    $db = dbConnect();

    $query = $db->query('SELECT * FROM artists ORDER BY name');
	$artists =  $query->fetchAll();

    return $artists;
}

function getArtist($id)
{
	$db = dbConnect();
	
	$query = $db->prepare("SELECT * FROM artists WHERE id = ?");
	$query->execute([
		$id
	]);
	
	$result = $query->fetch();
	
	return $result;
}

function updateArtist($id, $informations)
{
	$db = dbConnect();
	
	$query = $db->prepare('UPDATE artists SET name = ?, biography = ?, label_id = ? WHERE id = ?');
	
	$result = $query->execute(
		[
			$informations['name'],
			$informations['biography'],
			$informations['label_id'],
			$id,
		]
	);
	
   if($result && isset($_FILES['image']['tmp_name'])){
       //Si on envoie un nouveaux fichier image,
       //On efface la précédente en db histoire d'être sûr avant d'insérer la nouvelle
        unlinkImage($id);

        $allowed_extensions = array( 'jpg' , 'jpeg' , 'gif', 'png' );
        $my_file_extension = pathinfo( $_FILES['image']['name'] , PATHINFO_EXTENSION);
        if (in_array($my_file_extension , $allowed_extensions)){
            $new_file_name = $id . '.' . $my_file_extension ;
            $destination = '../assets/images/artist/' . $new_file_name;
            $result = move_uploaded_file( $_FILES['image']['tmp_name'], $destination);

            $db->query("UPDATE artists SET image = '$new_file_name' WHERE id = $id");
        }
    }
	
	return $result;
}


function addArtist($informations)
{
	$db = dbConnect();
	
	$query = $db->prepare("INSERT INTO artists (name, biography, label_id) VALUES( :name, :biography, :label_id)");
	$result = $query->execute([
		'name' => $informations['name'],
		'biography' => $informations['biography'],
		'label_id' => $informations['label_id'],
	]);

	if($result && isset($_FILES['image']['tmp_name'])){
		$artistId = $db->lastInsertId();

		$allowed_extensions = array( 'jpg' , 'jpeg' , 'gif', 'png' );
		$my_file_extension = pathinfo( $_FILES['image']['name'] , PATHINFO_EXTENSION);
		if (in_array($my_file_extension , $allowed_extensions)){
			$new_file_name = $artistId . '.' . $my_file_extension ;
			$destination = '../assets/images/artist/' . $new_file_name;
			$result = move_uploaded_file( $_FILES['image']['tmp_name'], $destination);

			$db->query("UPDATE artists SET image = '$new_file_name' WHERE id = $artistId");
		}
	}

	return $result;
}

function deleteArtist($id)
{

	$db = dbConnect();
	unlinkImage($id);
	$query = $db->prepare('DELETE FROM artists WHERE id = ?');
	$result = $query->execute([$id]);

	return $result;
}

function unlinkImage($id){
    $db = dbConnect();
    //On commence par récuperer le nom du fichier en db
    $query = $db->prepare("SELECT image FROM artists WHERE id = ?");
    $query->execute([
        $id
    ]);

    $dbImage = $query->fetch();
    foreach ($dbImage as $image)
    //Ici on récupère l'extension du fichier
        $extension = pathinfo($image, PATHINFO_EXTENSION);
    //Là on efface le fichier liée dans le localhost grace au nom du fichier qui correspond à $id
    //Et on concatène l'extension du fichier précédemment récupérer dans la variable $extension
    unlink('../assets/images/artist/'.$id.'.'.$extension);
}