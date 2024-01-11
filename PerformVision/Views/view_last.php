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

    <p>Choisissez un</p>

    <div>
        <form id="formulaire" action="" method="post">
            <select id="categorie" name="categorie">
                <!-- Affiche une liste déroulante des catégories -->
                <option value="0"> Toutes les catégories </option>
                <?php foreach(array_keys($categories) as $c):?>
                    <option class="option" value=<?= $c ?>> <?= $c ?> </option>
                <?php endforeach;?>
            </select>


            <select id="souscategorie" name="souscategorie">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="0"> Toutes les sous-catégories </option>
                <?php foreach(array_keys($categories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($categories[$c] as $sc=>$tabsc):?>
                            <option class="option" value=<?= $sc ?>> <?= $sc ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>
<!--chercher une balise invisible pour refaire passer la categorie en post dans le formulaire-->

            <select id="theme" name="theme">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="0"> Touts les thèmes </option>
                <?php foreach(array_keys($categories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($categories[$c] as $sc=>$tabsc):?>
                            <optgroup label=<?= $sc ?>>
                                <?php foreach ($tabsc as $t):?>
                                    <option class="option" value=<?= $t['nomt'] ?>><?= $t['nomt'] ?></option>
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

<script>
    /*selects.forEach(v=>{
        v.addEventListener('click', function () {

        })
    });*/


    //let selects = document.querySelectorAll('select');

    let form = document.querySelector('form');
    isOpen = [0, 0, 0]

    form.addEventListener('click', function (event) {
        console.log(event.target.options);
    })

    /*selects.forEach(v=>{
        v.addEventListener('click', function () {
            isOpen += 1; // si isOpen est à 0, il n'y a pas eu de click sur les select. Si c'est 1 alors on a cliqué sur un select et si c'est 2 alors ca fait l'action
            if(isOpen == 2) {
                console.log(this.options[this.options.selectedIndex]);
                isOpen =0;
            }
        })
    });*/


    console.log('feur')

</script>


<?php require "view_end.php"; ?>