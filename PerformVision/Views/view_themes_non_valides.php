<?php require "view_begin.php";?>
<style>
    table {
        width : 100% ; 
    }
    </style>
<?php 
echo '<div class="themes"><table>' ; 

foreach ($themesNonValides as $theme) {
    echo '<tr><td>' . $theme['nomt'] . '</td><td><a href="?controller=list_themes&action=valider_theme&idt=' . $theme['idt'] . '"><button>Valider</button></a><a href="?controller=list_themes&action=supprimer_theme&idt=' . $theme['idt'] . '"><button>Refuser</button></a></td></tr>';

} 
echo '</table></div>' ; ?>
<?php require "view_end.php" ; ?>