<?php

//Début d'une session qui nous servira à afficher des messages
session_start();

//Appel du helpers afin d'avoir la fonction de connexion à la db
require ('../helpers.php');

if(isset($_GET['controller'])){
	switch ($_GET['controller']){
        //Si on envoie dans l'url : controller=artits, on redirige vers le controller dédié aux artists
		case 'artists' :
            require 'controllers/artistController.php';
            break;

        //Si on envoie dans l'url : controller=songs, on redirige vers le controller dédié aux songs
        case 'songs' :
            require 'controllers/songController.php';
            break;

        //Si on envoie dans l'url : controller=labels, on redirige vers le controller dédié aux labels
        case 'labels' :
            require 'controllers/labelController.php';
            break;

        //Si on envoie dans l'url : controller=labels, on redirige vers le controller dédié aux labels
        case 'albums' :
            require 'controllers/albumController.php';
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

if(isset($_SESSION['messages'])){
	unset($_SESSION['messages']);	
}
if(isset($_SESSION['old_inputs'])){
	unset($_SESSION['old_inputs']);	
}
