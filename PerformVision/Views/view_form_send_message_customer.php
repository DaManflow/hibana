<?php require "view_begin.php";
?>

<h1> Envoyer un message à <?= $infos[0]['nom'] . " " .  $infos[0]['prenom'] . " " . $infos[0]['mail'] ?></h1>

<form action="?controller=message_customer&action=send_message" method="POST">
    
    <p> <label> <input type="hidden" name="date_msg" value="<?= currentTime() ?>" /></label> </p>
    <p> <label> <input type="hidden" name="id_former" value="<?= $_GET["id"]?>" /></label> </p>
    <p> <label> <textarea name="message" placeholder="Ecrivez votre message" required=""></textarea> </label> </p>

    <p> <label> <input required="" type="submit" name="submit" value="Envoyer"> </label> </p>



</form>



<?php   


require "view_end.php"; ?>