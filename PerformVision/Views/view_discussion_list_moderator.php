<?php require "view_begin.php";?>

<h1> Listes des discussions </h1>

<?php 

include "view_header_moderator.php";



if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
    foreach($discussion_list as $cle => $val) {
        echo "<tr><td> <a href=?controller=message_list&action=message_list&id=" . $val['id_discussion'] . ">" . $val['formateur_nom'] ." ".$val['formateur_prenom'] . " " . $val['formateur_mail'] . " a une discussion avec " . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . "</td></tr> </br>";
    }
    
}



?>
<?php require "view_end.php" ; ?>