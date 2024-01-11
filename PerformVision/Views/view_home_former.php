<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: /hibana-main/PerformVision/?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
}


$authtxt="Se connecter";

require 'view_accueil.php' ?>