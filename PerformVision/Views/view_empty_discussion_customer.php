<?php require "view_begin.php"; ?>


<h1> 
    <?= e($title) ?> 
</h1>

<p>   
    <?= e($message) ?>
</p>

<p> Voulez vous faire un nouveau message ? <a href="?controller=list_former_pagination_customer&action=former_pagination_message_customer">+ Nouveau message </a> </p>



<?php require "view_end.php"; ?>
