<?php 

require('models/Artist.php');
require('models/Label.php');

//Switch en fonction des actions reçu en url
if(isset($_GET['action'])){
    switch ($_GET['action']){
        case 'list' :
            $artists = getAllArtists();
            require('views/artistList.php');
            break;

        case 'new' :
            $labels = getAllLabels();
            require('views/artistForm.php');
            break;

        case 'add' :
            if(empty($_POST['name']) || empty($_POST['label_id'])){

                if(empty($_POST['name'])){
                    $_SESSION['messages'][] = 'Le champ nom est obligatoire !';
                }
                if(empty($_POST['label_id'])){
                    $_SESSION['messages'][] = 'Le champ label est obligatoire !';
                }

                $_SESSION['old_inputs'] = $_POST;
                header('Location:index.php?controller=artists&action=new');
                exit;
            }
            else{
                $resultAdd = addArtist($_POST);
                $_SESSION['messages'][] = $resultAdd ? 'Artiste enregistré !' : "Erreur lors de l'enregistreent de l'artiste... :(";

                header('Location:index.php?controller=artists&action=list');
                exit;
            }

            break;

        case 'edit' :
            if(!empty($_POST)){
                if(empty($_POST['name']) || empty($_POST['label_id'])){

                    if(empty($_POST['name'])){
                        $_SESSION['messages'][] = 'Le champ nom est obligatoire !';
                    }
                    if(empty($_POST['label_id'])){
                        $_SESSION['messages'][] = 'Le champ label est obligatoire !';
                    }

                    $_SESSION['old_inputs'] = $_POST;
                    header('Location:index.php?controller=artists&action=edit&id='.$_GET['id']);
                    exit;
                }else {
                    $result = updateArtist($_GET['id'], $_POST);
                    $_SESSION['messages'][] = $result ? 'Artiste mis à jour !' : 'Erreur lors de la mise à jour... :(';
                    header('Location:index.php?controller=artists&action=list');
                    exit;
                }
            }
            else{
                if (!isset($_SESSION['old_inputs'] )){
                    $artist = getArtist($_GET['id']);
                    if ($artist==false){
                        header('Location:index.php?controller=artists&action=list');
                        exit;
                    }
                }
                $labels = getAllLabels();
                require('views/artistForm.php');
            }

            break;

        case 'delete' :
            if (isset($_GET['id'])){
                $result = deleteArtist($_GET['id']);
                if($result){
                    $_SESSION['messages'][] = 'Artiste supprimé !';
                }
            }
            else{
                $_SESSION['messages'][] = 'Erreur lors de la suppression... :(';
            }
            header('Location:index.php?controller=artists&action=list');
            exit;

            break;

        default :
            require 'controllers/indexController.php';
    }
}
else{
    require 'controllers/indexController.php';
}

