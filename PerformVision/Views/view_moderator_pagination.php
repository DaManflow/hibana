<?php require_once "view_begin.php";?>


<table>
    
        <?php

        

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
            include "view_header_admin.php";
            foreach($printab as $cle => $val) {
                echo "<tr><td> <a href=?controller=moderator_list&action=moderator_information_admin&id=" . $val['id_utilisateur'] . ">" . $val['nom'] . " " . $val['prenom'] . " " . $val['mail'] .  "</a></td></tr>";
            }
        }
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
            include "view_header_moderator.php";
            foreach($printab as $cle => $val) {
                echo "<tr><td> <a href=?controller=moderator_list&action=moderator_information_moderator&id=" . $val['id_utilisateur'] . ">" . $val['nom'] . " " . $val['prenom'] . " " . $val['mail'] . "</a></td></tr>";
            }
        }

        

        ?>
</table>

<style>
    .icone { width: 16px; }
    .listePages { width : 400px; margin : auto; padding-top : 20px; text-align: center; }
    .listePages p { color : blue; padding: 0px; margin:0px;}
    a.lienStart { text-decoration: none; display: inline-block; width : 25px; font-size: smaller; color : blue;}
    a.active { color : red;}
</style>


<?php


echo '<a href="?controller=moderator_list&action=moderator_pagination&start='.($page - 1).'"><img src="./Content/images/previous-icon.png" class="icone" /></a>';

        for($i = 1; $i <= $pages; $i++){
            if($page!=$i){
                echo "<a class='lienStart' href='?controller=moderator_list&action=moderator_pagination&start=$i'>$i</a>&nbsp;";
            }else{
                echo "<a class='active'>$i</a>";
            }
        
            
        }
        echo '<a href="?controller=moderator_list&action=moderator_pagination&start='.($page + 1).'"><img src="./Content/images/next-icon.png" class="icone" /></a>';

?>






<?php require "view_end.php"; ?>