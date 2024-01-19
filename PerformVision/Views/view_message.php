<?php require "view_begin.php";


if (!isset($_SESSION['idutilisateur'])) {
    include "view_header_user.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'client') {
    include "view_header_customer.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'moderateur') {
    include "view_header_moderator.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'administrateur') {
    include "view_header_admin.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'formateur') {
    include "view_header_former.php";
}

?>



<h1> 
    <?= e($title) ?> 
</h1>

<p>   
    <?= e($message) ?>
</p>



<?php require "view_end.php"; ?>
