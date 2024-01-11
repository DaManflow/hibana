<?php require "view_begin.php";
require_once "./Utils/functions.php" ;
var_dump($tous);
?>

<h1> S'incrire </h1>

<form id="former-form" action="" method="POST" enctype="multipart/form-data">
    
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="text" name="phone" placeholder="Téléphone"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="text" name="linkedin" placeholder="Lien de votre page Linkedin"/> </label> </p>
    <p> <label> <input required="" type="file" name="cv"/> </label> </p>
    <p> <label> <input required="" type="radio" name="date_signature" value="<?= currentTime() ?>"/> Signature</label> </p>
        <label>Sélectionnez une catégorie :</label>
        <label for="noms">Choisissez un nom :</label>
  <select id="noms" name="noms">

  
    <?php foreach($categoriesMeres as $cle => $val): ?>

        <optgroup label="<?php echo $val ?>">

        <optgroup label="Noms en gras">
            <option value="nom1">Nom en gras 1</option>
            <option value="nom2">Nom en gras 2</option>
      </optgroup>
    </optgroup>
    <optgroup label="Autres noms">
      <option value="nom3">Nom 3</option>
      <option value="nom4">Nom 4</option>
    </optgroup>
    <?php endforeach; ?>
  </select>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>
</form>
<?php require "view_end.php";?>