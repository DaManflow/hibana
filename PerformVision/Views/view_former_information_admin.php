<?php require "view_begin.php";

include "view_header_admin.php";

?>


<table>
    
    <table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Téléphone</th>
        <th>CV</th>
        <th>Promouvoir</th>

    </tr>
    <tr>
    <?php
    
         foreach($infos as $cle => $val) {
            echo "<td>" . $val['id_utilisateur'] . "</td>" . "<td>" . $val['nom'] . "</td>" . "<td>" .$val['prenom'] . "</td>" . "<td>" . $val['mail'] . "</td>" . "<td>" . $val['telephone'] . "<td> <a href=" . dirname($val['cv']) . '/' . rawurlencode(basename($val['cv'])) . ">" . "CV" . "</a>" . "</td>" . "<td>" . "<a href=?controller=promote&action=promote&start=" . $val['id_utilisateur'] . ">" . "Promouvoir" . "</td>" ;
        }
            
        ?>
    </tr>
</table>






<?php require "view_end.php"; ?>
