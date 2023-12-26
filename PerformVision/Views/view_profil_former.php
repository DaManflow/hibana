<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

?>





<a href="?controller=logout&action=logout"><button>deconnexion</button></a>





<?php require_once "view_end.php"; ?>