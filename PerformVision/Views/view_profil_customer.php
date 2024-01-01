<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: /hibana-main/PerformVision/?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
}

?>

<div class="profil">
<h1> Mon profil </h1>
<ul>
<li> Nom : <?=$_SESSION['name'] ?> </li>
<li> Prénom : <?=$_SESSION['surname'] ?> </li>
<li> Adresse mail : <?=$_SESSION['email'] ?> </li>
<li> Téléphone : <?=$_SESSION['phone'] ?> </li>
<li> Société : <?=$_SESSION['company'] ?> </li>
</ul>


<a href="/hibana-main/PerformVision/?controller=logout&action=logout"><button class="button">Deconnexion</button></a>

</div>



<?php require_once "view_end.php"; ?>