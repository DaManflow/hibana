<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: /SAES301/hibana/PerformVision/?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /SAES301/hibana/PerformVision/?controller=home_former&action=home_former");
}

?>

<a href="/SAES301/hibana/PerformVision/?controller=logout&action=logout"><button>deconnexion</button></a>





<?php require_once "view_end.php"; ?>