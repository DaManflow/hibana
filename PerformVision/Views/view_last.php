<p>TEST</p>
<?php

require "view_begin.php";

echo var_dump($listCategories);
$categories =[];
foreach($listCategories as $c){// CHANGER LA REQUETE DES CATEGORIES EN TRIANT PAR CATEGORIE ET METTRE LES SOUS CATEGORIES !!!!!!!!!!!!
    $der_mere = 0;
    if($c["idc_mere"] == null){ // On cherche si c'est une catégorie
        $categories[] = $c;
        $der_mere = $c["idc"];
    }else{                      // Sinon cela veut dire que c'est une sous-catégorie et on l'ajoute à la catégorie correspondante
        $categories[$der_mere][] = $c;
    }
}

$themes = $tc["theme"];
?>

    <p> Découvrez Nos Formateurs </p>
    <div>
        <form action="">
            <select id="Categorie">  <!-- Affiche une liste déroulante des catégories -->
                <?php foreach($categories as $c):?>
                    <option value=<?= $c["nomc"] ?>> <?= $c["nomc"] ?> </option>
                <?php endforeach;?>
            </select>

            <select id="SousCategorie"> <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <?php foreach($categories as $c): ?>
                    <optgroup label=<?= $c["nomc"]?>>
                        <?php
                        foreach($sousCategories[$c["idc"]] as $sc):?>
                            <option value=<?= $sc["nomc"] ?>> <?= $sc["nomc"] ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>


        </form>
    </div>

<?php require "view_end.php"; ?>