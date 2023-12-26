<?php require_once "view_begin.php";

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: ?controller=home_former&action=home_former");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

?>

<div class="framenavbg"></div>
<div class="framenav">

    <a class="AccButton" href="?" title="Retour à l'accueil">
        <p class="Accueil">PerformVision Training & Consulting</p>
    </a>

    <div class="navi">
        <div><a class="link" href="?controller=former_list&action=former_pagination" title="Formateurs">Formateurs</a></div>
        <div><a class="link" href="#Conseils" title="Conseils">Conseils</a></div>

        <div class="autres">
            <button class="btn">Autres ▽</button>
            <div class="menuautres">
                <a class="link" href="un">Activité 1</a>
                <a class="link" href="de">Activité 2</a>
                <a class="link" href="tr">Activité 3</a>
            </div>
        </div>
        <div><a class="naviconnexion" href="?controller=login&action=login" title="Se connecter">Se connecter</a></div>
    </div>
</div>

<div class="color"></div>
<div class="div1"></div>
<div class="divmain">
    <h2>Bienvenue chez</h2>
    <h1>PerformVision Training & Consulting</h1>
    <a class="btndecouvrir" href="?controller=&action=formateur" title="Aller à la page formateurs">Découvrir les formateurs</a>
    <div class="divwhite">
        <div class="titrebg"><p>Découvrez les formations <span>qui vous correspondent</span></p></div>
        <div class="divimg"></div>
    </div>
</div>

<div class="footer"></div>
<?php require_once "view_end.php"; ?>
