<?php require "view_begin.php";?>
<style>
    table {
        width: 50% ; 
    }
    button {
        width : 100% ; 
    }
    </style>
<?php 
echo '<div class="themes"><table>' ; 
foreach ($themesValides as $theme) {
    echo '<tr><p><td>' . $theme['nomt'] . '</td><td><a href="?controller=list_themes&action=supprimer_theme&idt=' . $theme['idt'] . '"> <button> Supprimer</button></a></td></p></tr>';
} 
echo '</table></div>' ; ?>

<?php require "view_end.php" ; ?>