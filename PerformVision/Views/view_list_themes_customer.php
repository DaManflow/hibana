<?php require "view_begin.php";


?>

<h1>Voici La listes des thèmes</h1>

<table>
<select name="theme" class="exp-select" id="themeSelect">
    <option value="" selected disabled>Sélectionnez un thème</option>
    <?php
    $currentCategory = null;

    foreach ($list_themes as $id_theme => $themeData) {
        $categorie = $themeData['categorie'];
        $sous_categorie = $themeData['sous_categorie'];
        $theme = $themeData['theme'];

        if ($currentCategory !== $categorie) {
            if ($currentCategory !== null) {
                echo '</optgroup>';
            }
            echo '<optgroup label="' . e($categorie) . '">';
            $currentCategory = $categorie;
        }

        echo '<option value="' . e($id_theme) . '">' . e($sous_categorie) . ' : ' . e($theme) . '</option>';
    }

    if ($currentCategory !== null) {
        echo '</optgroup>';
    }
    ?>
</select>

</table>

<script>
    document.getElementById('themeSelect').addEventListener('change', function () {
        var selectedValue = this.value;

        if (selectedValue !== '') {
            // Rediriger vers l'URL fixe
            window.location.href = "?controller=list_former_theme&action=list_former_theme&id=" + encodeURIComponent(selectedValue);
        }
    });
</script>






<?php require "view_end.php" ; ?>