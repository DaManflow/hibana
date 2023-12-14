<?php   require "view_begin.php";
require_once "../Models/Model.php" ?>

<h1> S'incrire </h1>

<form action="" method="POST">
    <p> <label> <input type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input type="submit" name="submit" value="S'inscrire"> </label> </p>
    


</form>



<?php   

if (isset($_POST['submit'])) {
    $m = Model::getModel();
    $m->createUser();
    
}

require "view_end.php"; ?>