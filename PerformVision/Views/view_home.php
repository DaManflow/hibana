<?php require_once "view_begin.php";

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
}

<<<<<<< HEAD
?>
<div class="debut">
    <div class="partie-gauche">PerformVision Training & Consulting</div>
    <div class="partie-droite">
        <ul class="ul1">
        <li class="formations"><a href="/hibana-main/PerformVision/?controller=list&action=last" id="link">Formations</a></li>
        <li class="conseils"><a href="/hibana-main/PerformVision/?controller=list&action=last" id="link">Conseils</a></li>
        <li class="autres">Autres ▽
            <ul class="dropdown">
            <ul><a href="#" id="link">Activité 1</a></ul>
            <ul><a href="#" id="link">Activité 2</a></ul>
            <ul><a href="#" id="link">Activité 3</a></ul>
            </ul>
        </li>
            <a class="connect" href="/hibana-main/PerformVision/?controller=login&action=login">
                <button>
                    <i class="fa-regular fa-circle-user"></i><span class="aut">Se connecter</span>
                </button>
            </a>
        </ul>
    </div>
</div>
=======
$authtxt="Se connecter";
>>>>>>> f8eb0ca6341fc5f5f33aaaafc38e1ee1128afe74

require "view_accueil.php"

?>
