<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: /hibana-main/PerformVision/?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
}

$authtxt="Mon profil";

require "view_accueil.php"

?>
