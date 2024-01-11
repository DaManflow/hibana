<?php require "view_begin.php";
require_once "./Utils/functions.php" ;
?>

<h1> S'incrire </h1>

<form id="former-form" action="?controller=register_former&action=register_former" method="POST" enctype="multipart/form-data">
    
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="text" name="phone" placeholder="Téléphone"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="text" name="linkedin" placeholder="Lien de votre page Linkedin"/> </label> </p>
    <p> <label> <input required="" type="file" name="cv"/> </label> </p>
    <p> <label> <input required="" type="radio" name="date_signature" value="<?= currentTime() ?>"/> Signature</label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>
</form>
<?php require "view_end.php";?>