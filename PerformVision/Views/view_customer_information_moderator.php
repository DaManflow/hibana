<?php require "view_begin.php";?>


<table>
    
    <table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Téléphone</th>
        <th>Société</th>

    </tr>
    <tr>
    <?php
    
         foreach($infos as $cle => $val) {
            echo "</td>" . "<td>" . $val['nom'] . "</td>" . "<td>" .$val['prenom'] . "</td>" . "<td>" . $val['mail'] . "</td>" . "<td>" . $val['telephone'] . "</td>" . "<td>" . $val['societe'] . "</td>";
            if ($val['est_affranchi'] == false) {
                echo "<td>" . "<a href=?controller=free&action=free&start=" . $val['id_utilisateur'] . ">" . "Affranchir" . "</td>" ;
            }
            else {
                echo "<td>" . "<a href=?controller=unfree&action=unfree&start=" . $val['id_utilisateur'] . ">" . "De-affranchir" . "</td>" ;
            }
        }
            
        ?>
    </tr>
</table>






<?php require "view_end.php"; ?>
