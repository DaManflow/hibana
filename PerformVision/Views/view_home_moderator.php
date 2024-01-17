<?php require_once "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    header("Location: /hibana-main/PerformVision/?controller=home&action=home");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
}







?>
<div class="debut">
    <div class="partie-gauche">PerformVision Training & Consulting</div>
    <div class="partie-droite">
        <ul class="ul1">
        <li class="formations"><a href="/hibana-main/PerformVision/?controller=member_choice_moderator&action=member_choice">Membres</a></li>
        <li class="conseils">Conseils</li>
        <li class="autres">Autres        
        <ul class="dropdown">
            <li>Activité 1</li>
            <li>Activité 2</li>
            <li>Activité 3</li>
        </ul>
</li>
<li class="connect"><a href="/hibana-main/PerformVision/?controller=message_former&action=mes_discussions"><button><span class="aut">Mes discussions</span></button></a></li>
<li class="connect"><a href="/hibana-main/PerformVision/?controller=discussion_list&action=discussion_list"><button><span class="aut">Modérer les discussions</span></button></a></li>
        <li class="connect"><a href="/hibana-main/PerformVision/?controller=profil_former&action=profil_former"><button><i class="fa-regular fa-circle-user"></i><span class="aut">Mon profil</span></button></a></li>
</ul>
    </div>
</div>

<div class="titles">
    <h2 class="h2">Bienvenue chez</h2>
    <h1 class="h1">PerformVision Formations</h1>
</br>
</div>
<div class="reste">
<div class="centre">
    <div class="conteneur1">
    <div class="img1">
        <img src="/hibana-main/PerformVision/Content/images/ProgrammeurQuiFaitDuC.jpg"/>
    </div>
    </div>
        <div class="conteneur2">
            <div class="img2">
                <img src="/hibana-main/PerformVision/Content/images/HommeQuiEstHeureuxDeTravailler.jpg"/>
        </div>
        <div class="text">
            Que vous soyez en autodidacte, salarié(e) ou en reconvresion professionnelle,<span> PerformVision</span> vous propose<span> la formation qu'il vous faut</span>
        </div>
        </div>
    <div class="conteneur3">
        <div class="img3">
            <img src="/hibana-main/PerformVision/Content/images/HommeQuiEstHeureuxDeTravailler.jpg"/>
        </div>
    <div class="text2">
        Devenez <span>développeur informatique</span><br/>Suivez des cours auprès de formateurs <span>expérimentés</span>, apprenez le python, C, C++, Java, SQL et bien d'autres !
    </div> 
</div>
</div>
</div>
<footer>
    <div class="partie1">
        <div class="partie1-gauche">
            <h4>Nous contacter</h4>
            <a href="#">06 22 22 22 22</a>
            <a href="#">hibana.sae103@gmail.com</a>
        </div>
        <!--
        <div class="partie1-droite">
            <h4>Nos réseaux</h4>
            <ul>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            </ul>
        </div>
    -->
    </div>
    <div class="partie2">
        <h1>PerformVision Formations</h1>
        <p class="droits">
            ©2023 Tout droits résevés
        </p>
    </div>
</footer>
<?php require_once "view_end.php"; ?>

