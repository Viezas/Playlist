<?php
//Appel des modèles utile au controlleur
require('models/Artist.php');
require('models/Song.php');
require('models/Album.php');

//Switch en fonction des actions reçu en url
if(isset($_GET['action'])){
    switch ($_GET['action']){
        //Si on envoie dans l'url : controller=songs&action=list, on redirige vers la view songList qui va afficher tout les morceau
        case 'list' :
            $songs = getAllSongs();
            require('views/songList.php');
            break;

        //Si on envoie dans l'url : controller=songs&action=new, on redirige vers le controller dédié aux songs
        case 'new' :
            $artists = getAllArtists();
            $albums = getAllAlbums();
            require('views/songForm.php');
            break;

        //Suite au controller=songs&action=new, si on envoie un add dans l'url, on traite les informations
        case 'add' :
            //Vérification des champs obligatoire
            //Si il $_POST['title'] ou $_POST['artist'] est vide, on envoie un message et on retourne au formulaire
            if(empty($_POST['title']) || empty($_POST['artist'])){
                if(empty($_POST['title'])){
                    $_SESSION['messages'][] = 'Le champ titre est obligatoire !';
                }
                if(empty($_POST['artist'])){
                    $_SESSION['messages'][] = 'Le champ artiste est obligatoire !';
                }

                $_SESSION['old_inputs'] = $_POST;
                header('Location:index.php?controller=songs&action=new');
                exit;
            }

            //Si $_GET['title'] ou $_GET['artist'] ne sont pas vide, on ajoute à la db après vérification
            else{
                $resultAdd = addSong($_POST);

                $_SESSION['messages'][] = $resultAdd ? 'Morceau enregistré !' : "Erreur lors de l'enregistreent du morceau... :(";

                header('Location:index.php?controller=songs&action=list');
                exit;
            }

            break;

        //Si on envoie en url : controller=songs&action=edit&id=[nb], on edite le morceau concerné
        case 'edit' :
            //Vérification des champs obligatoire
            if(!empty($_POST)){
                //Si il $_GET['title'] ou $_GET['artist'] est vide, on envoie un message et on retourne au formulaire
                if(empty($_POST['title']) || empty($_POST['artist'])){
                    if(empty($_POST['title'])){
                        $_SESSION['messages'][] = 'Le champ titre est obligatoire !';
                    }
                    if(empty($_POST['artist'])){
                        $_SESSION['messages'][] = 'Le champ artiste est obligatoire !';
                    }

                    $_SESSION['old_inputs'] = $_POST;
                    header('Location:index.php?controller=songs&action=edit&id='.$_GET['id']);
                    exit;
                }
                //Si $_GET['title'] ou $_GET['artist'] ne sont pas vide, on ajoute à la db après vérification, on fait l'update en db
                else {
                    $result = updateSong($_GET['id'], $_POST);
                    $_SESSION['messages'][] = $result ? 'Morceau mis à jour !' : 'Erreur lors de la mise à jour... :(';
                    header('Location:index.php?controller=songs&action=list');
                    exit;
                }
            }
            //???
            else{
                if (!isset($_SESSION['old_inputs'] )){
                    $song = getSong($_GET['id']);
                    if ($song==false){
                        header('Location:index.php?controller=songs&action=list');
                        exit;
                    }
                }
                $artists = getAllArtists();
                $albums = getAllAlbums();
                require('views/songForm.php');
            }

            break;

        //Si on envoie en url : controller=songs&action=delete&id=[nb], on efface le morceau concerné
        case 'delete' :
            if (isset($_GET['id'])){
                $result = deleteSong($_GET['id']);
                if($result){
                    $_SESSION['messages'][] = 'Morceau supprimé !';
                }
            }
            else{
                $_SESSION['messages'][] = 'Erreur lors de la suppression... :(';
            }
            header('Location:index.php?controller=songs&action=list');
            exit;

            break;

        //Si on envoie dans l'url une mauvaise information, on redirige vers l'index de la partie admin
        default :
            require 'controllers/indexController.php';
    }
}
//Si on ne envoie rien dans l'url
else{
    require 'controllers/indexController.php';
}