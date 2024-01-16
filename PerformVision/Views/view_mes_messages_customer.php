<?php require "view_begin.php"; ?>

<h1>Mes Messages</h1>

<?php 

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    foreach ($messages as $cle => $val) {
        echo "<tr><td>";
        
        // Vérifiez si l'utilisateur actuel a envoyé le message
        if ($val['id_utilisateur'] == $_SESSION['idutilisateur']) {
            echo "Moi : ";
        }
        else {
            echo $val['nom'] . " " . $val['prenom'] . " alias " . $val['mail'] . " vous a envoyé : ";
        }

        echo $val['texte'] . "</td><td>" . " à " . $val['date_heure'] . "</td></tr></br>";
    }
}

?>
<form action="?controller=message_customer&action=send_message" method="POST">
    
    <p> <label> <input type="hidden" name="date_msg" value="<?= currentTime() ?>" /></label> </p>
    <p> <label> <input type="hidden" name="id_former" value="<?= $_GET["id"] ?>" /></label> </p>
    <p> <label> <textarea name="message" placeholder="Ecrivez un nouveau message" required=""></textarea> </label> </p>

    <p> <label> <input required="" type="submit" name="submit" value="Envoyer"> </label> </p>

</form>
<?php require "view_end.php"; ?>
