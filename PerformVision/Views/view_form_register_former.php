<?php   require "view_begin.php";

if (isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home_former&action=home_former");
}

?>

<h1> S'incrire </h1>

<form action="?controller=register_former&action=register_former" method="POST" enctype="multipart/form-data">
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="text" name="linkedin" placeholder="Lien de votre page Linkedin"/> </label> </p>
    <p> <label> <input required="" type="file" name="cv"/> </label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>
</form>



<?php   



require "view_end.php"; ?>