<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

?>
<?php $infos=$_SESSION ; ?>
<h1> Mon profil </h1>
<p> Nom : <?=$infos['name'] ?> </p>
<p> Prénom : <?=$infos['surname'] ?> </p>
<p> Adresse mail : <?=$infos['email'] ?> </p>
<p> Téléphone : <?=$infos['phone'] ?> </p>
<p> Linkedin : <?=$infos['linkedin'] ?> </p>
<p> Date de signature éléctronique : <?=$infos['date_signature'] ?> </p>
<p> Télécharger mon CV : <a href="<?=$infos['cv'] ?>" download><button>Télécharger</button></p>




<a href="?controller=logout&action=logout"><button>Deconnexion</button></a>





<?php require_once "view_end.php"; ?>