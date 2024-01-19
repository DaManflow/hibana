<?php require "view_begin.php";

if (!isset($_SESSION['idutilisateur'])) {
    include "view_header_user.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'client') {
    include "view_header_customer.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'moderateur') {
    include "view_header_moderator.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'administrateur') {
    include "view_header_admin.php";
}
if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == 'formateur') {
    include "view_header_former.php";
}



?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conseils et Formateurs</title>
    <style>

        header {
            background-color: #34495e; /* Bleu */
            color: #fff;
            text-align: center;
            padding: 1em 0;
        }

        section {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ecf0f1; /* Bleu clair */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        select, button {
            padding: 10px;
            margin: 10px 0;
            color : black;
        }

        ul {
            list-style: none;
            padding: 0;
            color : black;
        }

        .li {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #fff; /* Blanc */
        }

        button {
            background-color: #28394d; /* Bleu */
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9; /* Bleu plus foncé au survol */
        }

        p {
            text-align: justify;
            color : black;
        }
        label {
            color : black;
        }
    </style>
</head>
<body>

    <header>
        <h1>Conseils et Formateurs</h1>
    </header>

    <section>
        <p>Bienvenue sur notre site dédié aux conseils et aux formateurs. Vous avez la possibilité de découvrir des informations utiles sur différents thèmes en sélectionnant un thème dans la liste présente dans la page d'acceuil, en cliquant sur "Rechercher des formateurs".</p>

        <p> Voici une petite illustration :</p>

        <label for="themes">Sélectionnez un thème :</label>
        <select id="themes">
            <option value="theme1">Thème 1</option>
            <option value="theme2">Thème 2</option>
            <option value="theme3">Thème 3</option>
        </select>

        <p>Une fois que vous avez choisi un thème, vous pouvez consulter la liste des formateurs associés à ce thème.</p>

        <ul id="formateurs-list">
            <li class='li'>
                <h2>Nom du Formateur 1</h2>
                <button>Envoyer un message</button>
            </li>
            <li class='li'>
                <h2>Nom du Formateur 2</h2>
                <button>Envoyer un message</button>
            </li>
            <!-- Ajoutez d'autres éléments de liste au besoin -->
        </ul>

        <p>N'hésitez pas à entrer en contact avec les formateurs en utilisant le bouton "Envoyer un message" pour poser des questions, demander des conseils ou discuter de vos besoins spécifiques.</p>
    </section>


</body>
</html>
