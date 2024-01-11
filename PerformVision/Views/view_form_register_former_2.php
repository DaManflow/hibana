<?php require "view_begin.php";
require_once "./Utils/functions.php" ;
var_dump($_POST);

?>

<h1> S'incrire </h1>

<form id="former-form" action="?controller=register_redirection&action=register_redirection" method="POST" enctype="multipart/form-data">
    <p> <label> <input required="" type="text" name="name" placeholder="Nom" value="<?= $_POST['name']?>"/></label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom" value="<?= $_POST['surname']?>"/></label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email" value="<?= $_POST['email']?>"/></label> </p>
    <p> <label> <input required="" type="text" name="phone" placeholder="Téléphone" value="<?= $_POST['phone']?>" /></label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe" value="<?= $_POST['password']?>"/></label> </p>
    <p> <label> <input required="" type="text" name="linkedin" placeholder="Lien de votre page Linkedin" value="<?= $_POST['linkedin']?>"/></label> </p>
    <p> <label> <input required="" type="file" name="cv"/> </label> </p>
    <p> <label> <input required="" type="radio" name="date_signature" value="<?= currentTime() ?>"/> Signature</label> </p>
    <p>
        <label>Sélectionnez une catégorie :</label>
        <select name="categorie" id="categorie">
        <option value="<?= $_POST['categorie'] ?>"><?= $_POST['nom_categorie']?></option>
        </select>
        <label> <input required="" type="submit" name="submit_categorie" value="Valider"> </label>
    </p>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>
</form>
<?php require "view_end.php";?>