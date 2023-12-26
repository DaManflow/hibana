<?php require "view_begin.php";

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: /SAES301/hibana/PerformVision/?controller=home_customer&action=home_customer");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /SAES301/hibana/PerformVision/?controller=home_former&action=home_former");
}


?>

<h1> S'incrire </h1>

<form action="/SAES301/hibana/PerformVision/?controller=register_customer&action=register_customer" method="POST">
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="text" name="phone" placeholder="Téléphone"/> </label> </p>
    <p> <label> <input required="" type="text" name="company" placeholder="Société"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>



</form>



<?php   


require "view_end.php"; ?>