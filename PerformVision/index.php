<?php

session_start();



// Pour avoir le nombre de résultats par page
//Pour avoir la fonction e()
require_once "Utils/functions.php";
//Inclusion du modèle
require_once "Models/Model.php";
//Inclusion de la classe Controller
require_once "Controllers/Controller.php";

//Liste des contrôleurs
$controllers = ["home", "register_customer","register_former", "member_choice_admin", "member_choice_moderator", "former_list", "list_theme", "discussion_list", "message_list", "former_list_admin", "former_list_moderator", "admin_list", "moderator_list", "customer_list", "est_affranchi_true_list_moderator", "est_affranchi_true_list_admin", "est_affranchi_false_list_admin", "est_affranchi_false_list_moderator", "validem_true", "validem_false", "home_former", "home_customer", "home_admin", "home_moderator", "profil_customer", "profil_former", "login_customer", "login_former", "logout", "list", "message_former","message_customer", "promote", "unpromote", "free", "unfree","proposer_theme","create_theme","list_themes", "list_former_theme", "advices"];

//Nom du contrôleur par défaut
$controller_default = "home";

//On teste si le paramètre controller existe et correspond à un contrôleur de la liste $controllers
if (isset($_GET['controller']) and in_array($_GET['controller'], $controllers)) {
    $nom_controller = $_GET['controller'];
} else {
    $nom_controller = $controller_default;
}

//On détermine le nom de la classe du contrôleur
$nom_classe = 'Controller_' . $nom_controller;

//On détermine le nom du fichier contenant la définition du contrôleur
$nom_fichier = 'Controllers/' . $nom_classe . '.php';



//Si le fichier existe et est accessible en lecture
if (is_readable($nom_fichier)) {
    //On l'inclut et on instancie un objet de cette classe
    include_once $nom_fichier;
    new $nom_classe();
} else {
    die("Error 404: not found!");
}

