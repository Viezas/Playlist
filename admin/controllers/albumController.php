<?php
//Appel des modèles utile au controlleur
require('models/Album.php');
require('models/Artist.php');

//Switch en fonction des actions reçu en url
if(isset($_GET['action'])){
    switch ($_GET['action']){
        //Si on envoie dans l'url : controller=albums&action=list, on redirige vers la view songList qui va afficher tout les albums
        case 'list' :
            $albums = getAllAlbums();
            require('views/albumList.php');
            break;

        //Si on envoie dans l'url : controller=albums&action=new, on redirige vers le controller dédié aux albums
        case 'new' :
            $artists = getAllArtists();
            $albums = getAllAlbums();
            require('views/albumForm.php');
            break;

        //Suite au controller=albums&action=new, si on envoie un add dans l'url, on traite les informations
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
                header('Location:index.php?controller=albums&action=new');
                exit;
            }

            //Si $_POST['title'] ou $_POST['artist'] ne sont pas vide, on ajoute à la db après vérification
            else{
                $resultAdd = addAlbum($_POST);

                $_SESSION['messages'][] = $resultAdd ? 'Album enregistré !' : "Erreur lors de l'enregistreent de l'album... :(";

                header('Location:index.php?controller=albums&action=list');
                exit;
            }

            break;

        //Si on envoie en url : controller=albums&action=edit&id=[nb], on edite le morceau concerné
        case 'edit' :
            //Vérification des champs obligatoire
            if(!empty($_POST)){
                //Si il $_POST['title'] ou $_POST['artist'] est vide, on envoie un message et on retourne au formulaire
                if(empty($_POST['title']) || empty($_POST['artist'])){
                    if(empty($_POST['title'])){
                        $_SESSION['messages'][] = 'Le champ titre est obligatoire !';
                    }
                    if(empty($_POST['artist'])){
                        $_SESSION['messages'][] = 'Le champ artiste est obligatoire !';
                    }

                    $_SESSION['old_inputs'] = $_POST;
                    header('Location:index.php?controller=albums&action=edit&id='.$_GET['id']);
                    exit;
                }
                //Si $_POST['title'] ou $_POST['artist'] ne sont pas vide, on ajoute à la db après vérification, on fait l'update en db
                else {
                    $result = updateAlbum($_GET['id'], $_POST);
                    $_SESSION['messages'][] = $result ? 'Morceau mis à jour !' : 'Erreur lors de la mise à jour... :(';
                    header('Location:index.php?controller=albums&action=list');
                    exit;
                }
            }
            //???
            else{
                if (!isset($_SESSION['old_inputs'] )){
                    $album = getAlbum($_GET['id']);
                    if ($album==false){
                        header('Location:index.php?controller=albums&action=list');
                        exit;
                    }
                }
                $artists = getAllArtists();
                $albums = getAllAlbums();
                require('views/albumForm.php');
            }

            break;

        //Si on envoie en url : controller=songs&action=delete&id=[nb], on efface le morceau concerné
        case 'delete' :
            if (isset($_GET['id'])){
                $result = deleteAlbum($_GET['id']);
                if($result){
                    $_SESSION['messages'][] = 'Album supprimé !';
                }
            }
            else{
                $_SESSION['messages'][] = 'Erreur lors de la suppression... :(';
            }
            header('Location:index.php?controller=albums&action=list');
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
