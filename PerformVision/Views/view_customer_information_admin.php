<?php require "view_begin.php";?>


<table>
    
    <table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Téléphone</th>
        <th>Société</th>

    </tr>
    <tr>
    <?php
    
         foreach($infos as $cle => $val) {
            echo "<td>" . $val['id_utilisateur'] . "</td>" . "<td>" . $val['nom'] . "</td>" . "<td>" .$val['prenom'] . "</td>" . "<td>" . $val['mail'] . "</td>" . "<td>" . $val['telephone'] . "</td>" . "<td>" . $val['societe'] . "</td>";
        }
            
        ?>
    </tr>
</table>






<?php require "view_end.php"; ?>
