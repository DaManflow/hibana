<p>TEST</p>

<?php

require "view_begin.php";

//echo var_dump($listSousCategories);
//echo var_dump($filtre);

// Créer un tableau des catégories avec comme valeurs ses sous-catégories avec comme valeurs de celle-ci les thèmes associés

// Ce tableau peut bien sûr être placé dans controller_list pour optimiser (mais des questions se posent comme 'Est-ce que générer un tableau en entier à partir d'une requête consomme moins que faire une requête pour chaque itération boucle ?')

$sousCategories = [];
$der_mere = $listSousCategories[0]['nomc_mere'];
foreach ($listSousCategories as $sc){
    if($sc['nomc_mere'] != $der_mere) {
        $der_mere = $sc['nomc_mere'];
    }
    $sousCategories[$der_mere][$sc['nomc']] = [];
    $der_meret = $sc['nomc'];
    foreach ($themes as $t){
        if($t['nomc'] == $der_meret){
            $sousCategories[$der_mere][$der_meret][$t['nomt']] = $t;
        }
    }
}
//echo var_dump($experiences);
//echo var_dump($sousCategories);

// Créer un tableau des formateurs avec un tableau pour chaque compétence
//
//$formateur = [];
//foreach ($formateurs as $f){
//    if(!(key_exists($f['id_formateur'], $formateur))) {
//        $formateur[$f['id_formateur']] = [$f['nom'], $f['prenom']];
//    }
//    $formateur[$f['id_formateur']][2][$f['idt']][] = $f['volumehmoyensession'];
//    $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nbsessioneffectuee'];
//    $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nomt'];
//}

?>

<center>

    <p> Découvrez Nos Formations </p>

    <div>
        <form id="formulaire" action="" method="post">
            <select id="categorie" name="categorie">
                <!-- Affiche une liste déroulante des catégories -->
                <option value="" disabled> Categories :</option>
                <?php foreach($listCategories as $c): ?>
                    <option class="option" value="<?= e($c['nomc']) ?>"> <?= e($c['nomc']) ?> </option>
                <?php endforeach;?>
            </select>


            <select id="souscategorie" name="souscategorie">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="" disabled> Sous-categories :</option>
                <?php foreach(array_keys($sousCategories) as $c): ?>
                    <optgroup label="<?= e($c) ?>">
                        <?php foreach($sousCategories[$c] as $sc=>$tabsc):?>
                            <option class="option <?= e(implode("_", explode(" ", $c))) ?>" value="<?= e($sc) ?>"> <?= e($sc) ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>


            <select id="theme" name="theme">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="" disabled> Themes :</option>
                <?php foreach(array_keys($sousCategories) as $c): ?>
                <optgroup label="<?= e($c) ?>">
                    <?php foreach($sousCategories[$c] as $sc=>$tabsc):?>
                        <optgroup label="<?= e($sc) ?>">
                        <?php foreach ($tabsc as $t):?>
                            <option class="option <?= e(implode("_", explode(" ", $c))) ?> <?= e(implode("_", explode(" ", $sc))) ?>" value="<?= e($t['nomt']) ?>"><?= $t['nomt'] ?></option>
                        <?php endforeach ?>
                        </optoption>
                    <?php endforeach ?>
                    </optgroup>
                <?php endforeach ?>
            </select>


            <!-- Renvoi dans le formulaire la valeur de l'ancien filtre de chaque type si il existe-->

            <?php if (isset($filtre['categorie'])) :
                $tabstring = serialize($filtre['categorie'])
                ?>
            <input type="hidden" name="filtrecategorie" value="<?= e($tabstring) ?>">
            <?php endif ?>

            <?php if (isset($filtre['souscategorie'])) :
                $tabstring = serialize($filtre['souscategorie'])
                ?>
                <input type="hidden" name="filtresouscategorie" value="<?= e($tabstring) ?>">
            <?php endif ?>

            <?php if (isset($filtre['theme'])) :
                $tabstring = serialize($filtre['theme'])
                ?>
                <input type="hidden" name="filtretheme" value="<?= e($tabstring) ?>">
            <?php endif ?>


        </form>

        <!-- liste qui permet de supprimer des valeurs du filtre -->

        <ul id="filtre">
            <label>Catégories</label>
            <!-- Mettre les Categories choisies -->
            <br>
            <?php if (isset($filtre['categorie'])) :
                foreach ($filtre['categorie'] as $val): ?>
                    <li class="lifiltre categorie 0" style="margin: 10px; list-style-type: none; border-radius: 10px;display:inline-block">
                        <div style="display:inline-block">
                            <p class="valeur" style="display:inline-block; border: 1px solid darkslategrey;background-color: slategrey; padding: 10px"><?= e($val) ?></p>
                            <p class="croix" style="color: red; display:inline-block">X</p>
                        </div>
                    </li>
                <?php endforeach; endif ?>
            <br>
            <label>Sous-catégories</label>
            <!-- Mettre les Sous-categories choisies -->

            <br>
            <?php if (isset($filtre['souscategorie'])) :
                foreach ($filtre['souscategorie'] as $cle => $cat):
                    foreach ($cat as $souscat) :?>


                        <li class="lifiltre souscategorie <?= e(implode('_', explode(' ', $cle))) ?>" style="margin: 10px; list-style-type: none; border-radius: 10px;display:inline-block">
                            <div>
                                <p class="valeur" style="display:inline-block; border: 1px solid darkslategrey;background-color: slategrey; padding: 10px"><?= $cle ?> : <?= $souscat ?></p>
                                <p class="croix" style="color: red; display:inline-block">X</p>
                            </div>
                        </li>
                    <?php endforeach;endforeach; endif ?>
            <br>
            <label>Thèmes</label>
            <!-- Mettre les Thèmes choisis -->
            <br>
            <?php if (isset($filtre['theme'])) :
                foreach ($filtre['theme'] as $cle => $sc):
                    foreach ($sc as $th) :?>
                        <li class="lifiltre theme <?= e(implode('_', explode(' ', $cle))) ?>" style="margin: 10px; list-style-type: none; border-radius: 10px;display:inline-block">
                            <div style="">
                                <p class="valeur" style="display:inline-block; border: 1px solid darkslategrey;background-color: slategrey; padding: 10px"><?= e($cle) ?> : <?= $th ?></p>
                                <p class="croix" style="color: red; display:inline-block">X</p>
                            </div>
                        </li>
                    <?php endforeach;endforeach; endif ?>
            <br>
            <br>
            <br>
            <br>
        </ul>

    </div>


    <p> Experiences des formateurs </p>

    <?php if(count($experiences) == 0): ?>
        <p>Il n'y a pas d'expérience associé à votre requête</p>
    <?php endif ?>

    <?php foreach ($experiences as $e): ?>
        <div style="border: solid 2px grey">
            <?php foreach ($e as $cle => $info):
                if($cle == 'idt'){
                    continue;
                } ?>

                <p><?= e($cle) ?> : <?= e($info) ?></p>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>
</center>

<script>

    const formulaire = document.getElementById("formulaire");
    function create_input(nom, valeur) {

        const input = document.createElement("input");
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', nom);
        input.setAttribute('value', valeur);
        formulaire.appendChild(input)
    }

    // Algorithme pour renvoyer le formulaire à chaque clique sur un select

    let isOpen = 1;
    let locker = -1;
    let derselect = -1;


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

            // si isOpen est à 1, il y a eu un click sur un des select. Si c'est 0 alors on a cliqué sur une option d'un select

            if(derselect === locker){
                isOpen -= 1
                if(isOpen === 0) {

                    if(locker === 1){
                        create_input('addLockerCat', this.options[this.options.selectedIndex].classList[1]);
                    }else if(locker === 2){
                        create_input('addLockerCat', this.options[this.options.selectedIndex].classList[1]);
                        create_input('addLockerSousCat', this.options[this.options.selectedIndex].classList[2]);
                    }
                    console.log(this.options[this.options.selectedIndex].classList[1]);
                    console.log(this.options[this.options.selectedIndex].classList[2]);
                    create_input('addLockerName', this.name);// cette input renvoie le select qui a été touché
                    formulaire.submit();
                    isOpen = 1;
                }
            }else{
                isOpen = 1;
            }
            derselect = locker;

        })
    });


    lis = document.querySelectorAll('.lifiltre');
    console.log(lis);
    lis.forEach(v=>{
        v.addEventListener('click', function (event) {
            if(event.target.classList.contains('croix')){
                create_input('deleteLockerValue', this.querySelector('.valeur').textContent);  // Valeur dans la liste du filtre visuel
                create_input('deleteLockerKind', this.classList[1]) // Type
                create_input('deleteLockerSubval', this.classList[2])
                console.log(this.classList[2])
                formulaire.submit();
            }
        })
    })


</script>


<?php require "view_end.php"; ?>