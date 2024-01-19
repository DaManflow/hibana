<?php require "view_begin.php";?>

<h1> Listes des messages </h1>

<?php 



if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
    include "view_header_moderator.php";


    foreach($message_list as $cle => $val) {
        if ($val['message_validem'] == false && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['id_utilisateur'] == $val['id_client'] && $val['client_affranchi'] == false) {
            echo "<tr><td>" . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " à " . $val['message_date_heure'] . "<a href=?controller=validem_true&action=validem_true&id=" . $val['id_message'] . ">" . " Valider" . "</a></td></tr></br>";
        }
        elseif ($val['message_validem'] == true && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['id_utilisateur'] == $val['id_client'] && $val['client_affranchi'] == false) {
            echo "<tr><td>" . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " à " . $val['message_date_heure'] . "<a href=?controller=validem_false&action=validem_false&id=" . $val['id_message'] . ">" . " Dé-valider" . "</a></td></tr></br>";
        }
        elseif ($val['message_validem'] == true && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['id_utilisateur'] == $val['id_client'] && $val['client_affranchi'] == true) {
            echo "<tr><td>" . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " à " . $val['message_date_heure'] . "</br>";
        }
        elseif ($val['message_validem'] == false && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['id_utilisateur'] == $val['id_formateur'] && $val['formateur_affranchi'] == false) {
            echo "<tr><td>" . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " à " . $val['message_date_heure'] . "<a href=?controller=validem_true&action=validem_true&id=" . $val['id_message'] . ">" . " Valider" . "</a></td></tr></br>";
        }
        elseif ($val['message_validem'] == true && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['id_utilisateur'] == $val['id_formateur'] && $val['formateur_affranchi'] == false) {
            echo "<tr><td>" . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " à " . $val['message_date_heure'] . "<a href=?controller=validem_false&action=validem_false&id=" . $val['id_message'] . ">" . " Dé-valider" . "</a></td></tr></br>";
        }
        elseif ($val['message_validem'] == true && $val['id_utilisateur'] != $_SESSION['idutilisateur'] && $val['id_utilisateur'] == $val['id_formateur'] && $val['formateur_affranchi'] == true) {
            echo "<tr><td>" . $val['formateur_nom'] . " " . $val['formateur_prenom'] . " " . $val['formateur_mail'] . " a envoyé : " . $val['message_texte'] . " à " . $val['client_nom'] . " " . $val['client_prenom'] . " " . $val['client_mail'] . " à " . $val['message_date_heure'] . "</br>";
        }
        
        
        
            
        
        
    }
    
}



?>
<?php require "view_end.php" ; ?>