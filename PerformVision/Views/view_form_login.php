<?php require "view_begin.php";


if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: ?controller=home_customer&action=home_customer");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: ?controller=home_former&action=home_former");
}


?>

<h1> Se connecter </h1>

<form action="?controller=login&action=connectUser" method="POST">

    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="Se connecter"> </label> </p>
    


</form>

Vous n'êtes pas encore inscrit ?<a href="?controller=choice&action=register_choice"> Inscrivez-Vous</a>





<?php require "view_end.php"; ?>