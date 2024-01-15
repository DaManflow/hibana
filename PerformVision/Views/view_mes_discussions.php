<?php require "view_begin.php";?>

<h1> Mes Discussions </h1>

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
    foreach($list_discussions_customers as $cle => $val) {
        echo "<tr><td> <a href=?controller=message_former&action=list_messages_former&id=" . $val['id_client'] . ">" . $val['nom'] ." ".$val['prenom'] . " " . $val['mail'] . "</a></td></tr> </br>";
    }
}



?>
<?php require "view_end.php" ; ?>