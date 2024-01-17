<?php require "view_begin.php";?>

<h1> Listes des messages </h1>

<?php 



if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    foreach($list_discussions_formers as $cle => $val) {
        echo "<tr><td> <a href=?controller=message_customer&action=list_messages_customer&id=" . $val['id_formateur'] . ">" . $val['nom'] ." ".$val['prenom'] . " " . $val['mail'] . "</a></td></tr> </br>";
    }
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    foreach($list_discussions_customers as $cle => $val) {
        echo "<tr><td> <a href=?controller=message_former&action=list_messages_former&id=" . $val['id_client'] . ">" . $val['nom'] ." ".$val['prenom'] . " " . $val['mail'] . "</a></td></tr> </br>";
    }
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
    foreach($list_discussions_customers as $cle => $val) {
        echo "<tr><td> <a href=?controller=message_former&action=list_messages_former&id=" . $val['id_client'] . ">" . $val['nom'] ." ".$val['prenom'] . " " . $val['mail'] . "</a></td></tr> </br>";
    }
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {



    foreach($message_list as $cle => $val) {
        if ($val['id_utilisateur'] == $val['id_client']) {
            echo "<tr><td>" . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " à " . $val['message_date_heure'] . "</br>";
        }
        elseif ($val['id_utilisateur'] == $val['id_formateur']) {
            echo "<tr><td>" . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " à " . $val['message_date_heure'] . "</br>";
        }

        
        if ($val['message_validem'] == false && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['client_affranchi'] == false || $val['formateur_affranchi'] == false)  {
            echo "<a href=?controller=validem_true&action=validem_true&id=" . $val['id_message'] . ">" . " Valider" . "</a></td></tr> </br>";
        }
            
        
        elseif ($val['message_validem'] == true && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['client_affranchi'] == false || $val['formateur_affranchi'] == false) {
            echo "<a href=?controller=validem_false&action=validem_false&id=" . $val['id_message'] . ">" . " Dé-valider" . "</a></td></tr> </br>";
        }
    }
    
}



?>
<?php require "view_end.php" ; ?>