<p>TEST</p>

<?php

require "view_begin.php";

$categories =[];
$der_mere = $listCategories[0]['idc_mere'];
foreach ($listCategories as $c){
    if($c['idc_mere'] == $der_mere) {
        $categories[$der_mere][$c['nomc']] = [];
    }else{
        $der_mere = $c['idc_mere'];
        $categories[$der_mere][$c['nomc']] = [];
    }

    $der_meret = $c['nomc'];
    foreach ($themes as $t){ // on peut opti
        if($t['nomc'] == $der_meret){
            $categories[$der_mere][$der_meret][$t['nomt']] = $t;
        }
    }
}


$formateur = [];
foreach ($formateurs as $f){
    if(!(key_exists($f['id_formateur'], $formateur))) {
        $formateur[$f['id_formateur']] = [$f['nom'], $f['prenom']];
        $formateur[$f['id_formateur']][3] = [$f['volumehmoyensession'], $f['nbsessioneffectuee'], $f['nomt']];
    }
    else{
        $formateur[$f['id_formateur']][2][] = [$f['volumehmoyensession'], $f['nbsessioneffectuee'], $f['nomt']];
    }
}
?>
<center>
    <script>
        document.querySelectorAll('p').addEventListener('click', function(){console.log('C');})
    </script>

    <p> Découvrez Nos Formateurs </p>
    <div>
        <form id="formulaire" action="" method="post">
            <select id="categorie" name="categorie">  <!-- Affiche une liste déroulante des catégories -->
                <?php foreach(array_keys($categories) as $c):?>
                    <option value=<?= $c ?>> <?= $c ?> </option>
                <?php endforeach;?>
            </select>

            <select id="souscategorie" name="souscategorie"> <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <?php foreach(array_keys($categories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($categories[$c] as $sc=>$tabsc):?>
                            <option value=<?= $sc ?>> <?= $sc ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>

            <select id="theme" name="theme"> <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <?php foreach(array_keys($categories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($categories[$c] as $sc=>$tabsc):?>
                            <optgroup label=<?= $sc ?>>
                                <?php foreach ($tabsc as $t):?>
                                    <option value=<?= $t['nomt'] ?>><?= $t['nomt'] ?></option>
                                <?php endforeach ?>
                            </optoption>
                        <?php endforeach ?>
                    </optgroup>
                <?php endforeach ?>
            </select>

            <button type="submit">Valider</button>

        </form>
    </div>

    <p> AFFICHER LES FORMATEURS ICI !!!!</p>
</center>
<?php require "view_end.php"; ?>