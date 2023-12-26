<?php require "view_begin.php";

if (!$_SESSION['idutilisateur']) {
    header("Location: ?controller=login&action=login");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: ?controller=home_former&action=home_former");
}




?>


<table>
    
    <table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>CV</th>
    </tr>
    <tr>
    <?php
    
         foreach($infos as $cle => $val) {
            echo "<td>" . $val['nom'] . "</td>" . "<td>" .$val['prenom'] . "</td>" . "<td>" . $val['mail'] . "</td>" . "<td>" . $val['telephone'] . "<td> <a href=" . dirname($val['cv']) . '/' . rawurlencode(basename($val['cv'])) . ">" . "CV" . "</a>" . "</td>";
        }
            
        ?>
    </tr>
</table>






<?php require "view_end.php"; ?>