<?php   require "view_begin.php";

if (isset($_SESSION['idutilisateur'])) {
    header("Location: ?controller=home_customer&action=home_customer");
}

?>

<h1> S'incrire </h1>

<form action="?controller=register_customer&action=register_customer" method="POST">
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>
    


</form>



<?php   


require "view_end.php"; ?>