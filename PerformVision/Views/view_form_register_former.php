<?php require "view_begin.php";
require_once "./Utils/functions.php" ;  

$_SESSION['themes'] = $themes ; 
$_SESSION['public'] = $public ; 
$_SESSION['levels'] = $levels ;
?>

<h1> S'inscrire </h1>

<form id="former-form" action="?controller=register_former&action=register_former" method="POST" enctype="multipart/form-data">
    
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="text" name="phone" placeholder="Téléphone"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="text" name="linkedin" placeholder="Lien de votre page Linkedin"/> </label> </p>
    <p> <label> <input required="" type="file" name="cv" class="lienbtn"/> </label> </p>
     <button type="button" onclick="ajouterExperience()" required="" class="lienbtn">Ajouter une expérience</button>

<!-- Conteneur pour les expériences -->
<div id="experiencesContainer"></div>
<br>

    <p> <label> <input required="" type="radio" name="date_signature" value="<?= currentTime() ?>"/> Signature</label> </p>
    <p> <label> <input required="" type="submit" name="submit" value="S'inscrire"> </label> </p>
    <script>
        var experienceCounter = 1;

        function ajouterExperience() {
            var experiencesContainer = document.getElementById('experiencesContainer');

            // Crée un nouvel élément div pour le menu déroulant
            var newExperienceDiv = document.createElement('div');
            newExperienceDiv.className = 'experienceDropdown';

            // Ajoute le HTML du menu déroulant au nouvel élément div
           
            newExperienceDiv.innerHTML = `
            <h1>Informations sur l'Expérience ${experienceCounter}</h1>

                <div class="exp">
                    <label for="theme${experienceCounter}" class="titre-exp">Expérience :</label>
                    <select name="theme${experienceCounter}" class="exp-select">
                        <?php
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
                </div>
                </br>

                <div class="exp">
                    <label for="expertise${experienceCounter}" class="titre-exp">Expertise Professionnelle :</label>
                    <select name="expertise${experienceCounter}" class="exp-select">
                    <?php
                    foreach ($levels as $id => $col) {
                        echo '<option value="' . e($id) . '">' . e($col['libelle']). '</option>';
                    }
                    ?>
                    </select>
                </div>
                </br>
                <div class="exp">
                    <label for="dureeExpertise${experienceCounter}" class="titre-exp">Durée de l'expertise :</label>
                    <input type="number" name="dureeExpertise${experienceCounter}" placeholder="Saisissez le nombre d'années d'expertise" required="">
                </div>
                </br>
                <div class="exp">
                    <label for="commentaireExpertise${experienceCounter}" class="exp titre-exp">Commentaire :</label>
                    </br>
                    <textarea name="commentaireExpertise${experienceCounter}" placeholder="Ajoutez un commentaire"></textarea>
                </div>
                </br>
                <div class="exp">
                    <label for="expePeda${experienceCounter}" class="exp titre-exp" >Experience Padagogique :</label>
                    </br>
                    <select name="expePeda${experienceCounter}" class="exp-select">
                    <?php
                    foreach ($public as $id => $val) {
                        echo '<option value="' . e($id) . '">' . e($val['libellep']). '</option>';
                    }
                    ?>
                    </select>
                </div>
                </br>
                <div class="exp">
                    <label for="VolumeHMoyenSession${experienceCounter}" class="titre-exp">Volume horaire d'une session :</label></br>
                    <input type="time" name="VolumeHMoyenSession${experienceCounter}" placeholder="Saisissez le nombre d'années d'expertise" required="" step=1>
                </div>
                <div class="exp">
                    <label for="nbSession${experienceCounter}" class="titre-exp">Nombre de sessions :</label></br>
                    <input type="number" name="nbSession${experienceCounter}" placeholder="Saisissez le nombre de sessions" required="">
                </div>
                <div class="exp">
                    </br>
                    <label for="commentaireExpePeda${experienceCounter}" class="exp-select titre-exp">Commentaire :</label>
                    </br>
                    <textarea name="commentaireExpePeda${experienceCounter}" placeholder="Ajoutez un commentaire"></textarea>
                </div>
            `;

            // Ajoute le nouvel élément div au conteneur
            experiencesContainer.appendChild(newExperienceDiv);
            experienceCounter++;
        }
    </script>
</form>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    var_dump($_POST) ; 
    $experienceIndex = 1;
    while (isset($_POST['theme' . $experienceIndex])) {
        $themeKey = 'theme' . $experienceIndex;
        $expertiseKey = 'expertise' . $experienceIndex;
        $dureeExpertiseKey = 'dureeExpertise' . $experienceIndex;
        $commentaireExpertiseKey = 'commentaireExpertise' . $experienceIndex;
        $expePedaKey = 'expePeda' . $experienceIndex;
        $VolumeHMoyenSessionKey = 'VolumeHMoyenSession' . $experienceIndex;
        $nbSessionKey = 'nbSession' . $experienceIndex;
        $commentaireExpePedaKey = 'commentaireExpePeda' . $experienceIndex;

        if (
            isset($_POST[$themeKey]) && isset($_POST[$expertiseKey]) &&
            isset($_POST[$dureeExpertiseKey]) && isset($_POST[$commentaireExpertiseKey]) &&
            isset($_POST[$expePedaKey]) && isset($_POST[$VolumeHMoyenSessionKey]) &&
            isset($_POST[$nbSessionKey]) && isset($_POST[$commentaireExpePedaKey])
        ) {
            // Traitement de chaque expérience et ajout à $infos
            $theme = $_POST[$themeKey];
            $expertise = $_POST[$expertiseKey];
            $dureeExpertise = $_POST[$dureeExpertiseKey];
            $commentaireExpertise = $_POST[$commentaireExpertiseKey];
            $expePeda = $_POST[$expePedaKey];
            $VolumeHMoyenSession = $_POST[$VolumeHMoyenSessionKey];
            $nbSession = $_POST[$nbSessionKey];
            $commentaireExpePeda = $_POST[$commentaireExpePedaKey];

            // Effectuez ici vos vérifications et traitements spécifiques
/*
            // Ajoutez les données au tableau $infos
            $_SESSION[$themeKey] = $themes[$theme]['theme'];
            $_SESSION[$expertiseKey] = $levels[$expertise]['libelle'];
            $_SESSION[$expePedaKey] = $public[$expePeda]['libellep'];
            */
        }
        

        $experienceIndex++;
    } 
    
}
require "view_end.php";?>
