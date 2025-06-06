<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
    include "view_header_moderator.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
    include "view_header_admin.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    include "view_header_former.php";
}



?>
<style>
    .profil {
       margin-top : 50px ;  
    }
    </style>
<div class="profil">
<h1> Mon profil </h1>
<ul>
<li> Nom : <?=$_SESSION['name'] ?> </li>
<li> Prénom : <?=$_SESSION['surname'] ?> </li>
<li> Adresse mail : <?=$_SESSION['email'] ?> </li>
<li> Téléphone : <?=$_SESSION['phone'] ?> </li>
<li> Linkedin : <?=$_SESSION['linkedin'] ?> </li>
<li> Date de signature éléctronique : <?=$_SESSION['date_signature'] ?> </li>
<li> Mon CV : <a href="<?=$_SESSION['cv'] ?>"><button>Consulter</button></li></a>
<li> Ma déclaration : <a href="<?=$_SESSION['declaration'] ?>" download="<?=$_SESSION['name']?>_<?=$_SESSION['surname']?>_declaration.pdf"><button>Télécharger</button></li></a>


</ul>
<a href="?controller=logout&action=logout"><button class="button">Deconnexion</button></a>

</div>



<?php require_once "view_end.php"; ?>