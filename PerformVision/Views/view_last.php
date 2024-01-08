<p>TEST</p>

<?php

if(isset($_POST['categorie'])){
    echo $_POST['categorie'];
}

if(isset($_POST['souscategorie'])){
    echo $_POST['souscategorie'];
}

if(isset($_POST['theme'])){
    echo $_POST['theme'];
}

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
        $formateur[$f['id_formateur']][2][$f['idt']][] = $f['volumehmoyensession'];
        $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nbsessioneffectuee'];
        $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nomt'];
    }
    else{
        $formateur[$f['id_formateur']][2][$f['idt']][] = $f['volumehmoyensession'];
        $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nbsessioneffectuee'];
        $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nomt'];
    }
}
?>
<center>

    <p> Découvrez Nos Formateurs </p>
    <div>
        <form id="formulaire" action="" method="post">
            <select id="categorie" name="categorie" multiple="">  <!-- Affiche une liste déroulante des catégories -->
                <option value="0"> Toutes les catégories </option>
                <?php foreach(array_keys($categories) as $c):?>
                    <option value=<?= $c ?>> <?= $c ?> </option>
                <?php endforeach;?>
            </select>

            <?php echo "avant";
            if(isset($_POST['categorie'])):
             echo "après"   ?>

            <select id="souscategorie" name="souscategorie"> <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="0"> Toutes les sous-catégories </option>
                <?php foreach(array_keys($categories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($categories[$c] as $sc=>$tabsc):?>
                            <option value=<?= $sc ?>> <?= $sc ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>

            <?php if(isset($_POST['souscategorie'])): ?>

            <select id="theme" name="theme"> <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="0"> Touts les thèmes </option>
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

            <?php endif; endif;?>

            <button type="submit">Valider</button>



        </form>
    </div>

    <p> AFFICHER LES FORMATEURS ICI !!!!</p>
</center>
<?php require "view_end.php"; ?>