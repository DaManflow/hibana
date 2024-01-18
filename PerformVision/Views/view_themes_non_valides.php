<?php require "view_begin.php";?>
<style>
    table {
        width : 100% ; 
    }
    </style>
<?php 
echo '<div class="themes"><table>' ; 
foreach ($themesNonValides as $theme) {
    echo '<tr><p><td>' . $theme['nomt'] . '</td><td> <button onclick="devalider(' . $theme['idt'] . ')"> Valider</button>      <button> Refuser </button></td></p></tr>';
} 
echo '</table></div>' ; ?>
<?php require "view_end.php" ; ?>