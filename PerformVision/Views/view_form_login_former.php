<?php require "view_begin.php"; 



include "view_header_user.php";


?>

<body class="bodyform">

<h1> Se connecter </h1>

<form action="?controller=login_former&action=connectUser" method="POST">
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="Se connecter"> </label> </p>
</form>

Vous n'êtes pas encore inscrit ?  <a class="lienbtn" href="?controller=register_former&action=form_register_former">Inscrivez-Vous</a>
<br><br>

<?php require "view_end.php"; ?>