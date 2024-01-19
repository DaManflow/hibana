<?php require_once "view_begin.php";

include "view_header_admin.php";

?>


<table>

    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Rôle</th>

    </tr>
    <tr>
    
        <?php
            foreach($printab as $cle => $val) {
                echo "<tr><td>" . $val['id_utilisateur'] . "</td>" . "<td>" . $val['nom'] . "</td>" . "<td>" . $val['prenom'] . "</td>" . "<td>" . $val['mail'] . "<td>" . $val['role'] . "</td></tr>";
            }
        ?>
        </tr>
</table>

<style>
    .icone { width: 16px; }
    .listePages { width : 400px; margin : auto; padding-top : 20px; text-align: center; }
    .listePages p { color : blue; padding: 0px; margin:0px;}
    a.lienStart { text-decoration: none; display: inline-block; width : 25px; font-size: smaller; color : blue;}
    a.active { color : red;}
</style>


<?php


echo '<a href="?controller=est_affranchi_false_list_admin&action=est_affranchi_false_pagination_admin&start='.($page - 1).'"><img src="./Content/images/previous-icon.png" class="icone" /></a>';

        for($i = 1; $i <= $pages; $i++){
            if($page!=$i){
                echo "<a class='lienStart' href='?controller=est_affranchi_false_list_admin&action=est_affranchi_false_pagination_admin&start=$i'>$i</a>&nbsp;";
            }else{
                echo "<a class='active'>$i</a>";
            }
        
            
        }
        echo '<a href="?controller=est_affranchi_false_list_admin&action=est_affranchi_false_pagination_admin&start='.($page + 1).'"><img src="./Content/images/next-icon.png" class="icone" /></a>';

?>






<?php require "view_end.php"; ?>