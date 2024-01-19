<?php require "view_begin.php"; ?>


<h1> 
    <?= e($title) ?> 
</h1>

<p>   
    <?= e($message) ?>
</p>
<br>
<p> Voulez vous faire un nouveau message ? <br><br>
    <a class="lienbtn" href="?controller=list_former_pagination_customer&action=former_pagination_message_customer"><i class="fa-solid fa-pen"></i> Nouveau message </a> </p>



<?php require "view_end.php"; ?>
