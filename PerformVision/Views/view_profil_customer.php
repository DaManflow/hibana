<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: ?controller=home_former&action=home_former");
}

?>

<?php $infos=$_SESSION ; ?>
<div class="profil">
<h1> Mon profil </h1>
<ul>
<li> Nom : <?=$infos['nom'] ?> </li>
<li> Prénom : <?=$infos['prenom'] ?> </li>
<li> Adresse mail : <?=$infos['mail'] ?> </li>
<li> Téléphone : <?=$infos['telephone'] ?> </li>
<li> Société : <?=$infos['societe'] ?> </li>
</ul>

<a href="?controller=logout&action=logout"><button class="button">Deconnexion</button></a>

</div>



<?php require_once "view_end.php"; ?>