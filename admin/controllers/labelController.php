<?php

//Appel des modèles utile au controlleur
require('models/Label.php');

//Switch en fonction des actions reçu en url
if(isset($_GET['action'])){
    switch ($_GET['action']){

        //Si on envoie dans l'url : controller=labels&action=list, on redirige vers la view songList qui va afficher tout les labels
        case 'list' :
            $labels = getAllLabels();
            require('views/labelList.php');
            break;

        //Si on envoie dans l'url : controller=labels&action=new, on redirige vers le controller dédié aux labels
        case 'new' :
            require('views/labelForm.php');
            break;

        //Suite au controller=labels&action=new, si on envoie un add dans l'url, on traite les informations
        case 'add' :
            //Vérification des champs obligatoire
            //Si il $_POST['name'] est vide, on envoie un message et on retourne au formulaire
            if(empty($_POST['name'])){
                $_SESSION['messages'][] = 'Le champ Nom est obligatoire !';

                $_SESSION['old_inputs'] = $_POST;
                header('Location:index.php?controller=labels&action=new');
                exit;
            }

            //Si $_POST['name'] ne sont pas vide, on ajoute à la db après vérification
            else{
                $resultAdd = addLabel($_POST);

                $_SESSION['messages'][] = $resultAdd ? 'Label enregistré !' : "Erreur lors de l'enregistreent du label... :(";

                header('Location:index.php?controller=labels&action=list');
                exit;
            }

            break;

        //Si on envoie en url : controller=labels&action=edit&id=[nb], on edite le label concerné
        case 'edit' :
            //Vérification des champs obligatoire
            if(!empty($_POST)){
                //Si il $_POST['name'] est vide, on envoie un message et on retourne au formulaire
                if(empty($_POST['name'])){
                    $_SESSION['messages'][] = 'Le champ Nom est obligatoire !';

                    $_SESSION['old_inputs'] = $_POST;
                    header('Location:index.php?controller=labels&action=new');
                    exit;
                }
                //Si $_POST['title'] ou $_POST['artist'] ne sont pas vide, on ajoute à la db après vérification, on fait l'update en db
                elseif (!empty($_POST['name'])) {
                    $result = updateLabel($_GET['id'], $_POST);
                    $_SESSION['messages'][] = $result ? 'Label mis à jour !' : 'Erreur lors de la mise à jour... :(';
                    header('Location:index.php?controller=labels&action=list');
                    exit;
                }
            }
            //???
            else{
                if (!isset($_SESSION['old_inputs'] )){
                    $label = getLabel($_GET['id']);
                    if ($label==false){
                        header('Location:index.php?controller=labels&action=list');
                        exit;
                    }
                }
                require('views/labelForm.php');
            }
            break;

        //Si on envoie en url : controller=labels&action=delete&id=[nb], on efface le label concerné
        case 'delete' :
            if (isset($_GET['id'])){
                $result = deleteLabel($_GET['id']);
                if($result){
                    $_SESSION['messages'][] = 'Label supprimé !';
                }
            }
            else{
                $_SESSION['messages'][] = 'Erreur lors de la suppression... :(';
            }
            header('Location:index.php?controller=labels&action=list');
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