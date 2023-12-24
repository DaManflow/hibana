<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

?>

<a href="?controller=logout&action=logout"><button>deconexion</button></a>





<?php require_once "view_end.php"; ?>