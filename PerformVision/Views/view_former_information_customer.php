<?php require "view_begin.php";

if (!$_SESSION['idutilisateur']) {
    header("Location: /SAES301/hibana/PerformVision/?controller=login&action=login");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /SAES301/hibana/PerformVision/?controller=home_former&action=home_former");
}

?>


<table>
    
    <table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Téléphone</th>
    </tr>
    <tr>
    <?php
    
         foreach($infos as $cle => $val) {
            echo "<td>" . $val['nom'] . "</td>" . "<td>" .$val['prenom'] . "</td>" . "<td>" . $val['mail'] . "</td>" . "<td>" . $val['telephone'] . "</td>";
        }
            
        ?>
    </tr>
</table>






<?php require "view_end.php"; ?>