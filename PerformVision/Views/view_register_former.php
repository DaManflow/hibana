<?php   require "view_begin.php";
require_once "../Models/Model.php" ?>

<h1> S'incrire </h1>

<form action="" method="POST" enctype="multipart/form-data">
    <p> <label> <input type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input type="text" name="linkedin" placeholder="Lien de votre page Linkedin"/> </label> </p>
    <p> <label> <input type="file" name="cv"/> </label> </p>
    <p> <label> <input type="submit" name="submit" value="S'inscrire"> </label> </p>
    


</form>



<?php   



require "view_end.php"; ?>