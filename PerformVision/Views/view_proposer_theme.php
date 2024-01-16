<?php require "view_begin.php"; ?>
<p> Les thèmes existants : </p>
<select name="theme" class="exp-select">
        <?php
        $currentCategory = null; 

        foreach ($themes as $id_theme => $themeData) {

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
                    <form  method ="POST" action="?controller=create_theme&action=create_theme">
                    <textarea type="text" name="theme_contenu" placeholder="Proposer un nouveau thème" required=""></textarea>
                    <p> Lier le thème à une catégorie existante </p>
                    <select name="sous_categorie" class="exp-select">
    <?php
    $currentCategory = null;

    foreach ($categories as $id_categorie => $categorieData) {
        $categorie_mere = $categorieData['categorie_mere'];
        $sous_categorie = $categorieData['categorie'];

        if ($currentCategory !== $categorie_mere) {
            if ($currentCategory !== null) {
                echo '</optgroup>';
            }

            if ($sous_categorie) {
                echo '<optgroup label="' . e($categorie_mere) . '">';
            } else {
                echo '<optgroup label="' . e($categorie_mere) . '" disabled style="font-weight:bold;">';
            }

            $currentCategory = $categorie_mere;
        }

        echo '<option value="' . e($id_categorie) . '">' . e($sous_categorie) . '</option>';
    }

    if ($currentCategory !== null) {
        echo '</optgroup>';
    }
    ?>
</select>
                    <p> <label> <input required="" type="submit" name="submit" value="Proposer le thème"> </label> </p>
                            </form>
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                                echo "Votre thème a été soumis avec succès, attendez qu'il soit validé par un modérateur" ; 
                            }
                            ?>

<?php require "view_end.php"; ?>