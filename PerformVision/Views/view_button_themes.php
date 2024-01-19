<?php require "view_begin.php" ?>
<style>
    .theme {
        display : flex ; 
        align-items : center ; 
        justify-content : center ;  
    }
    </style>

<body class="bodyform">

<h1>Les thèmes proposés</h1>

<div class='theme'>
<div class="divchoice">
<p> <a class="lienbtn" href="?controller=list_themes&action=themes_valides">Thèmes validés</a> </p>
<p> <a class="lienbtn" href="?controller=list_themes&action=themes_non_valides">Thèmes non-validés</a> </p>
</div>
</div>
<?php require "view_end.php" ?>