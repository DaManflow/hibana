<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: ?controller=home_former&action=home_former");
}

?>

<?php $infos=$_SESSION ; ?>
<h1> Mon profil </h1>
<p> Nom : <?=$infos['nom'] ?> </p>
<p> Prénom : <?=$infos['prenom'] ?> </p>
<p> Adresse mail : <?=$infos['mail'] ?> </p>
<p> Téléphone : <?=$infos['telephone'] ?> </p>
<p> Société : <?=$infos['societe'] ?> </p>
    

<a href="?controller=logout&action=logout"><button>Deconnexion</button></a>





<?php require_once "view_end.php"; ?>