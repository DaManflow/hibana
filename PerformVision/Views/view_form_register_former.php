
<?php require "view_begin.php";
require_once "./Utils/functions.php" ;

?>

<h1> S'incrire </h1>

<form id="former-form" action="?controller=register_former&action=register_former" method="POST" enctype="multipart/form-data">
    
    <p> <label> <input required="" type="text" name="name" placeholder="Nom"/> </label> </p>
    <p> <label> <input required="" type="text" name="surname" placeholder="Prénom"/> </label> </p>
    <p> <label> <input required="" type="text" name="email" placeholder="Email"/> </label> </p>
    <p> <label> <input required="" type="text" name="phone" placeholder="Téléphone"/> </label> </p>
    <p> <label> <input required="" type="password" name="password" placeholder="Mot De Passe"/> </label> </p>
    <p> <label> <input required="" type="text" name="linkedin" placeholder="Lien de votre page Linkedin"/> </label> </p>
    <p> <label> <input required="" type="file" name="cv"/> </label> </p>
     <button type="button" onclick="ajouterExperience()" required="">Ajouter une expérience</button>

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
            <br>
            <br>
                <label for="theme${experienceCounter}">Expérience :</label>
                <select name="theme${experienceCounter}">
                    <?php

                    foreach ($themes as $row) {
                        if ($currentCategory !== $row['categorie']) {
                            if ($currentCategory !== null) {
                                echo '</optgroup>';
                            }
                            echo '<optgroup label="' . e($row['categorie']) . '">';
                            $currentCategory = $row['categorie'];
                        }
                        echo '<option value="' . e($row['id_theme']) . '">' . e($row['sous_categorie']) . ' : ' . e($row['theme']) . '</option>';
                }
                    ?>
                </select>
</br>
                <label for="expertise${experienceCounter}">Expertise Professionnelle :</label>
                <select name="expertise${experienceCounter}">
                <?php
                foreach ($levels as $col) {
                    echo '<option value="' . e($col['idn']) . '">' . e($col['libelle']). '</option>' ;
                }
                ?>
                </select>
                <label for="dureeExpertise${experienceCounter}">Durée de l'expertise :</label>
                <input type="number" name="dureeExpertise${experienceCounter}" placeholder="Saisissez le nombre d'années d'expertise" required="">

                <label for="commentaireExpertise${experienceCounter}">Commentaire :</label>
                <textarea name="commentaireExpertise${experienceCounter}" placeholder="Ajoutez un commentaire"></textarea>
                </br>
                <label for="expePeda${experienceCounter}">Experience Padagogique :</label>
                <select name="expePeda${experienceCounter}">
                <?php
                foreach ($public as $val) {
                    echo '<option value="' . e($val['idp']) . '">' . e($val['libellep']). '</option>' ;
                }
                ?>
                </select>
                <label for="VolumeHMoyenSession${experienceCounter}">Volume horaire d'une session :</label>
                <input type="time" name="VolumeHMoyenSession${experienceCounter}" placeholder="Saisissez le nombre d'années d'expertise" required="" step=1>

                <label for="nbSession${experienceCounter}">Nombre de sessions :</label>
                <input type="number" name="nbSession${experienceCounter}" placeholder="Saisissez le nombre de sessions" required="">

                <label for="commentaireExpePeda${experienceCounter}">Commentaire :</label>
                <textarea name="commentaireExpePeda${experienceCounter}" placeholder="Ajoutez un commentaire"></textarea>
            `;

            // Ajoute le nouvel élément div au conteneur
            experiencesContainer.appendChild(newExperienceDiv);
            experienceCounter++;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    
    // Store values from experiences (adjust the variable names accordingly)
   
}


    </script>
</form>
<?php 
require "view_end.php";?>