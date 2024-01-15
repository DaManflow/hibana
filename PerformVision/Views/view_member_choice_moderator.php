<?php require "view_begin.php";?>


<body class="bodyform">

<h1>Liste des membres du site</h1>


<div class="divchoice">
<p>Quelle liste consultée ?</p>
<p> <a class="lienbtn" href="?controller=moderator_list&action=moderator_pagination">Modérateurs</a> </p>
<p> <a class="lienbtn" href="?controller=former_list_moderator&action=former_pagination_moderator">Formateurs</a> </p>
<p> <a class="lienbtn" href="?controller=customer_list&action=customer_pagination">clients</a> </p>
<p> <a class="lienbtn" href="?controller=est_affranchi_true_list_moderator&action=est_affranchi_true_pagination_moderator">Membres affranchie</a> </p>
<p> <a class="lienbtn" href="?controller=est_affranchi_false_list_moderator&action=est_affranchi_false_pagination_moderator">Membres non-affranchie</a> </p>
</div>

<?php
require "view_end.php"; ?>