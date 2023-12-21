<?php require "view_begin.php";?>


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
            echo "<td>" . $val['nom'] . "</td>" . "<td>" .$val['prenom'] . "</td>" . "<td>" . $val['mail'] . "</td>" . "<td>" ."<a href=" . $val['chemin_acces'] . ">" . "CV" ."</a>" . "</td>";
        }
            
        ?>
    </tr>
</table>






<?php require "view_end.php"; ?>