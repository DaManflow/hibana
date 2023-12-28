<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

?>
<?php $infos=$_SESSION ; ?>
<div class="profil">
<h1> Mon profil </h1>
<ul>
<li> Nom : <?=$infos['name'] ?> </li>
<li> Prénom : <?=$infos['surname'] ?> </li>
<li> Adresse mail : <?=$infos['email'] ?> </li>
<li> Téléphone : <?=$infos['phone'] ?> </li>
<li> Linkedin : <?=$infos['linkedin'] ?> </li>
<li> Date de signature éléctronique : <?=$infos['date_signature'] ?> </li>
<li> Télécharger mon CV : <a href="<?=$infos['cv'] ?>" download><button>Télécharger</button></li>

</ul>


<a href="?controller=logout&action=logout"><button class="button">Deconnexion</button></a>

</div>



<?php require_once "view_end.php"; ?>