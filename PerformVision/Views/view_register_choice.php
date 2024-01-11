<?php   require "view_begin.php";?>


<body class="bodyform">

<h1>S'inscrire</h1>


<div class="divchoice">
<p>Vous voulez proposer vos formations?</p>
<p> <a class="lienbtn" href="?controller=register_former&action=form_register_former">S'inscrire en tant que formateur</a> </p>
<p>Vous cherchez une formation?</p>
<p> <a class="lienbtn" href="?controller=register_customer&action=form_register_customer">S'inscrire en tant que client</a> </p>
</div>

<?php
require "view_end.php"; ?>