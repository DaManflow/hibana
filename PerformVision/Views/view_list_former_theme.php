<?php require_once "view_begin.php";?>

<h1>Liste des formateurs</h1>

<table>
    
        <?php


        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            
            foreach($former_list as $cle => $val) {
                echo "<tr><td>" . $val['nom'] . " " . $val['prenom'] . "<a href=?controller=message_customer&action=envoyer_message_customer&id=" . $val['id_utilisateur'] . ">" . " " . "Envoyer un message" . "</td></tr>";
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








<?php require "view_end.php"; ?>