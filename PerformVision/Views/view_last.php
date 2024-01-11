<p>TEST</p>

<?php

require "view_begin.php";

echo var_dump($filtre);


// Créer un tableau des catégories avec comme valeurs ses sous-catégories avec comme valeurs de celle-ci les thèmes associés

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



// Créer un tableau des formateurs avec un tableau pour chaque compétence

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
                <option value="" disabled> Categories :</option>
                <option value="0"> Toutes les catégories </option>
                <?php foreach(array_keys($categories) as $c):?>
                    <option class="option" value=<?= $c ?>> <?= $c ?> </option>
                <?php endforeach;?>
            </select>


            <select id="souscategorie" name="souscategorie">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="" disabled> Sous-categories :</option>
                <option value="0"> Toutes les sous-catégories </option>
                <?php foreach(array_keys($categories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($categories[$c] as $sc=>$tabsc):?>
                            <option class="option" value=<?= $sc ?>> <?= $sc ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>


            <select id="theme" name="theme">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="" disabled> Themes :</option>
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


            <!-- Renvoi dans le formulaire la valeur de l'ancien filtre de chaque type si il existe-->

            <?php if (isset($filtre['categorie'])) :?>
            <input type="hidden" name="filtrecategorie" value=<?= $filtre['categorie'] ?>>
            <?php endif ?>

            <?php if (isset($filtre['souscategorie'])) :?>
                <input type="hidden" name="filtresouscategorie" value=<?= $filtre['souscategorie'] ?>>
            <?php endif ?>

            <?php if (isset($filtre['theme'])) :?>
                <input type="hidden" name="filtretheme" value=<?= $filtre['theme'] ?>>
            <?php endif ?>


        </form>

        <ul>

        </ul>

    </div>


    <p> AFFICHER LES FORMATEURS ICI !!!!</p>

</center>

<script>

    let isOpen = 1;
    let locker = -1;
    let derselect = -1;

    const formulaire = document.getElementById("formulaire");
    let selects = document.querySelectorAll('select');

    selects.forEach(v=>{
        v.addEventListener('click', function () {
            if(this.name === "categorie"){
                locker = 0;
            }else if(this.name === "souscategorie"){
                locker = 1;
            }else{
                locker = 2;
            }

            // si isOpen est à 0, il y a eu de click sur un des select. Si c'est 1 alors on a cliqué sur une option d'un select

            if(derselect === locker){
                isOpen -= 1
                if(isOpen === 0) {
                    const input = document.createElement("input");
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'locker');
                    input.setAttribute('value', this.name); // cette input renvoie le select qui a été touché
                    formulaire.appendChild(input);
                    formulaire.submit();
                    isOpen = 1;
                }
            }else{
                isOpen = 1;
            }
            derselect = locker;

        })
    });


    console.log('feur')

</script>


<?php require "view_end.php"; ?>