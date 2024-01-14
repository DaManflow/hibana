<p>TEST</p>

<?php

require "view_begin.php";

// echo var_dump($listSousCategories);
 echo var_dump($filtre);

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

//echo var_dump($sousCategories);

// Créer un tableau des formateurs avec un tableau pour chaque compétence

$formateur = [];
foreach ($formateurs as $f){
    if(!(key_exists($f['id_formateur'], $formateur))) {
        $formateur[$f['id_formateur']] = [$f['nom'], $f['prenom']];
    }
    $formateur[$f['id_formateur']][2][$f['idt']][] = $f['volumehmoyensession'];
    $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nbsessioneffectuee'];
    $formateur[$f['id_formateur']][2][$f['idt']][] = $f['nomt'];
}


?>

<center>

    <p> Découvrez Nos Formateurs </p>

    <div>
        <form id="formulaire" action="" method="post">
            <select id="categorie" name="categorie">
                <!-- Affiche une liste déroulante des catégories -->
                <option value="" disabled> Categories :</option>
                <option value="0"> Toutes les catégories </option>
                <?php foreach($listCategories as $c): ?>
                    <option class="option" value=<?= $c['nomc'] ?>> <?= $c['nomc'] ?> </option>
                <?php endforeach;?>
            </select>


            <select id="souscategorie" name="souscategorie">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="" disabled> Sous-categories :</option>
                <option value="0"> Toutes les sous-catégories </option>
                <?php foreach(array_keys($sousCategories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($sousCategories[$c] as $sc=>$tabsc):?>
                            <option class="option" value=<?= $sc ?>> <?= $sc ?> </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endforeach;?>
            </select>


            <select id="theme" name="theme">
                <!-- Affiche une liste déroulante des sous catégories en fonction des catégories -->
                <option value="" disabled> Themes :</option>
                <option value="0"> Touts les thèmes </option>
                <?php foreach(array_keys($sousCategories) as $c): ?>
                    <optgroup label=<?= $c ?>>
                        <?php foreach($sousCategories[$c] as $sc=>$tabsc):?>
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
            <input type="hidden" name="filtrecategorie" value=<?= serialize($filtre['categorie']) ?>>
            <?php endif ?>

            <?php if (isset($filtre['souscategorie'])) :?>
                <input type="hidden" name="filtresouscategorie" value=<?= serialize($filtre['souscategorie']) ?>>
            <?php endif ?>

            <?php if (isset($filtre['theme'])) :?>
                <input type="hidden" name="filtretheme" value=<?= serialize($filtre['theme']) ?>>
            <?php endif ?>


        </form>


        <!-- liste qui permet de supprimer des valeurs du filtre -->

        <ul id="filtre">
        <label>Catégories</label>
            <!-- Mettre les Categories choisies -->

            <?php if (isset($filtre['categorie'])) :
                foreach ($filtre['categorie'] as $val): ?>
                    <li class="lifiltre categorie" style="margin: 10px; list-style-type: none;border: 1px solid darkslategrey;background-color: slategrey; border-radius: 10px;">
                        <div>
                            <p class="valeur" style="display:inline-block"><?= $val ?></p>
                            <p class="croix" style="color: red; display:inline-block">X</p>
                        </div>
                    </li>
            <?php endforeach; endif ?>

        <label>Sous-catégories</label>
            <!-- Mettre les Sous-categories choisies -->

        <label>Thèmes</label>
            <!-- Mettre les Thèmes choisis -->

        </ul>

    </div>


    <p> AFFICHER LES FORMATEURS ICI !!!!</p>

</center>

<script>

    function create_input(nom, valeur) {
        const formulaire = document.getElementById("formulaire");
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
            console.log(this.options[this.options.selectedIndex].value);
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
                    /*const input = document.createElement("input");
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'addlocker');
                    input.setAttribute('value', this.name);
                    formulaire.appendChild(input);*/

                    create_input('addlocker', this.name);// cette input renvoie le select qui a été touché
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
            console.log(this.className);
            console.log(this.classList[1]);
            if(event.target.classList.contains('croix')){
                /*const input = document.createElement("input");
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'deletelocker');
                input.setAttribute('value', this.querySelector('.valeur').textContent + "_" + this.className[1]);
                formulaire.appendChild(input);*/
                create_input('deletelocker', this.querySelector('.valeur').textContent + "" + this.classList[1]);  // Valeur dans la liste du filtre visuel + le type (ex = 'programmation_categorie')
                this.remove();
                formulaire.submit();
            }
        })
    })

</script>


<?php require "view_end.php"; ?>