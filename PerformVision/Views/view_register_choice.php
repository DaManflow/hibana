<?php   require "view_begin.php";

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
    header("Location: /SAES301/hibana/PerformVision/?controller=home_customer&action=home_customer");
}

if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
    header("Location: /SAES301/hibana/PerformVision/?controller=home_former&action=home_former");
}



?>



<p> <a href="/SAES301/hibana/PerformVision/?controller=register_former&action=form_register_former"> S'inscrire en tant que formateur</a> </p>
<p> <a href="/SAES301/hibana/PerformVision/?controller=register_customer&action=form_register_customer"> S'inscrire en tant que client</a> </p>



<?php   


require "view_end.php"; ?>