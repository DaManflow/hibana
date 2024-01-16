<?php 

include "./tcpdf2/tcpdf.php";

/**
 * Fonction échappant les caractères html dans $message
 * @param string $message chaîne à échapper
 * @return string chaîne échappée
 */
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function currentTime() {
    date_default_timezone_set('Europe/Paris');
    // Récupérer l'heure actuelle
    $heureActuelle = date('Y-m-d H:i:s');

    // Retourner l'heure actuelle
    return $heureActuelle;
}


function data_message() {

    $infos = [];

    if (isset($_POST['message'])) {
        $msg = trim($_POST['message']);
        if (!empty($msg)) {
            $infos['message'] = e($msg);
        } else {
            $infos['message'] = "false";
        }
    }

    $infos['date_msg'] = $_POST['date_msg'];
    $infos['id_former'] = $_POST['id_former'];

    return $infos;

}



function check_data_customer() {
    $infos = [];

    // Vérification du nom
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        if (!empty($name) && ctype_alpha($name)) {
            $infos['name'] = e($name);
        } else {
            $infos['name'] = "false";
        }
    }

    // Vérification du prénom
    if (isset($_POST['surname'])) {
        $surname = trim($_POST['surname']);
        if (!empty($surname) && ctype_alpha($surname)) {
            $infos['surname'] = e($surname);
        } else {
            $infos['surname'] = "false";
        }
    }

    // Vérification de l'e-mail
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $infos['email'] = e($email);
        } else {
            $infos['email'] = "false";
        }
    }

    if (isset($_POST['phone'])) {
        $phone = trim($_POST['phone']);
        if (!empty($phone)) {
            $infos['phone'] = e($phone);
        } else {
            $infos['phone'] = "false";
        }
    }

    if (isset($_POST['company'])) {
        $company = trim($_POST['company']);
        if (!empty($company)) {
            $infos['company'] = e($company);
        } else {
            $infos['company'] = "false";
        }
    }

    $infos['role'] = "client";
 
    // Vérification du mot de passe au moins une majuscule une minuscule un caractère spécial et au moins huit caractères
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password) && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $infos['password'] = e(crypt_biblio($password));
        } else {
            $infos['password'] = "false";
        }
    }
// le client est non affranchi par défaut 
    $infos['estaffranchi'] = 'false';

    
    return $infos;
}

function check_data_former() {
    $infos = [];

    // Vérification du nom
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        if (!empty($name) && ctype_alpha($name)) {
            $infos['name'] = e($name);
        } else {
            $infos['name'] = "false";
        }
    }

    // Vérification du prénom
    if (isset($_POST['surname'])) {
        $surname = trim($_POST['surname']);
        if (!empty($surname) && ctype_alpha($surname)) {
            $infos['surname'] = e($surname);
        } else {
            $infos['surname'] = "false";
        }
    }

    // Vérification de l'e-mail
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $infos['email'] = e($email);
        } else {
            $infos['email'] = "false";
        }
    }

    if (isset($_POST['phone'])) {
        $phone = trim($_POST['phone']);
        if (!empty($phone) && preg_match('/^[0-9]{10}$/', $phone)) {
            $infos['phone'] = e($phone);
        } else {
            $infos['phone'] = "false";
        }
    }

    $infos['role'] = "formateur";

    // Vérification du mot de passe
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password) && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $infos['password'] = e(crypt_biblio($password));
        } else {
            $infos['password'] = "false";
        }
    }

    $infos['estaffranchi'] = "false";

    // Vérification du LinkedIn
    if (isset($_POST['linkedin'])) {
        $linkedin = trim($_POST['linkedin']);
        if (!empty($linkedin)) {
            $infos['linkedin'] = e($linkedin);
        } else {
            $infos['linkedin'] = "false";
        }
    }

    // Vérification du CV 
    if (isset($_FILES['cv'])) {
        $cv = $_FILES['cv'];
        if (!empty($cv)) {

            if ($cv['type'] != "application/pdf") {
                $cv['type'] = "false";
                
            }

            $infos['cv'] = $cv;
            $cv['name'] = e($cv['name']);
        } else {

            $infos['cv'] = "false";
        }
    }

    if (isset($_POST['date_signature'])) {
        $date_signature = trim($_POST['date_signature']);
        if (!empty($date_signature)) {
            $infos['date_signature'] = e($date_signature);
        } else {
            $infos['date_signature'] = "false";
        }
    }
    //inserer les experiences 
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

            // Ajoutez les données au tableau $infos
            $infos[$themeKey] = e($theme);
            $infos[$expertiseKey] = e($expertise);
            $infos[$dureeExpertiseKey] = e($dureeExpertise);
            $infos[$commentaireExpertiseKey] = e($commentaireExpertise);
            $infos[$expePedaKey] = e($expePeda);
            $infos[$VolumeHMoyenSessionKey] = e($VolumeHMoyenSession);
            $infos[$nbSessionKey] = e($nbSession);
            $infos[$commentaireExpePedaKey] = e($commentaireExpePeda);
        }

        $experienceIndex++;
    }
    //signature 
    /*
    if (isset($_POST['url_signature'])) {
        $date_signature = $_POST['url_signature'];
        if (!empty($date_signature)) {
            $infos['url_signature'] = e($url_signature);
        } else {
            $infos['url_signature'] = "false";
        }
    }
    */

    return $infos;
}


function check_data_user() {

    $infos = [];

    // Vérification de l'e-mail
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $infos['email'] = e($email);
        } else {
            $infos['email'] = "false";
        }
    }

    // Vérification du mot de passe
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password) && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $infos['password'] = e(crypt_biblio($password));
        } else {
            $infos['password'] = "false";
        }
    }

    return $infos;



}
//le tableau theme , niveau, public 
/*
$m = Model::getModel();
        $data = [
            "themes"=>$m->seeThemes(),
            "levels"=>$m->seeLevel(),
            "public"=>$m->seePublic(),

        ];
$themes = $data('themes') ; 
$levels = $data('levels') ; 
$public = $data('public') ; */
//generer le pdf 
function generatePDF($id_formateur, $name, $surname, $email, $phone, $linkedin, $signature) {
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(100, 10,'Génération du PDF ', 0, 1);
    $pdf->Cell(100, 10, 'Vos informations personnelles ', 0, 1);

    $pdf->MultiCell(100, 20, 'Nom: '. $name);
    $pdf->MultiCell(100, 20,'Prénom: '. $surname);
    $pdf->MultiCell(100, 20,'Email: '. $email);
    $pdf->MultiCell(100, 20,'Téléphone: '. $phone);
    $pdf->MultiCell(100, 20,'Linkedin: ' . $linkedin);

    $pdf->Cell(100, 10, 'Vos Formations : ', 0, 1);
    for ($i = 1; isset($_POST['theme' . $i]); $i++) {
        $categorie = $_SESSION['themes'][$_POST['theme' . $i]]['categorie'];
        $sous_categorie = $_SESSION['themes'][$_POST['theme' . $i]]['sous_categorie'];
        $theme = $_SESSION['themes'][$_POST['theme' . $i]]['theme'];
        $expertise = $_SESSION['levels'][$_POST['expertise' . $i]]['libelle'];
        $duree = $_POST['dureeExpertise' . $i];
        $commentaire = $_POST['commentaireExpertise' . $i];
        $expePeda = $_SESSION['public'][$_POST['expePeda' . $i]]['libellep'];
        $volumeHMoyenSession = $_POST['VolumeHMoyenSession' . $i];
        $nbSession = $_POST['nbSession' . $i];
        $commentaireExpePeda = $_POST['commentaireExpePeda' . $i];
    
        // Ajouter les informations d'expérience au PDF
        $pdf->MultiCell(100, 20, "Categorie : $categorie\nSous-catégorie : $sous_categorie\nThème : $theme\nExpertise : $expertise\nDurée : $duree\nCommentaire : $commentaire\nExpérience pédagogique : $expePeda\nVolume horaire moyen de session : $volumeHMoyenSession\nNombre de sessions : $nbSession\nCommentaire : $commentaireExpePeda");
        $pdf->Ln(6);
    }
    $pdf->MultiCell(100, 20,'Signature: '. $signature);

    $pdfContent = $pdf->Output($name. '_'.$surname.'_declaration.pdf', 'S');

    return $pdfContent;


}



/**
 * Récupère sous forme de tableau les numéros de pages à afficher dans un affichage avec pagination
 * @param int $page_active page qui va être affichée
 * @param int $nb_total_pages nombre total de pages de résultats
 * @return array Contient les numéros de page qui seront affichés
 */
function liste_pages($page_active, $nb_total_pages)
{
    $debut = max($page_active - 5, 1);
    if ($debut === 1) {
        $fin = min(10, $nb_total_pages);
    } else {
        $fin = min($page_active + 4, $nb_total_pages);
    }

    $pages = [];
    for ($i = $debut; $i <= $fin; $i++) {
        $pages[] = $i;
    }
    return $pages;
}
//Chiffrer et déchiffrer à l'aide de bibliothèque Openssl 
function crypt_biblio($str) {
    $publicKey = openssl_pkey_get_public(file_get_contents("./Crypt/clef.hibana"));
    openssl_public_encrypt($str,$crypted, $publicKey);
    return base64_encode($crypted);
}

function decrypt_biblio($str) {
    $privateKey = openssl_pkey_get_private(file_get_contents("./Crypt/clef.hibana.private"));
    openssl_private_decrypt(base64_decode($str), $decrypted, $privateKey);
    return $decrypted;
}
//RSA : génération des  clés et ensuite chiffrer et déchiffrer le message 
//troisieme essai pour le coup 
function generateRSAKeys($bitLength) {
    $p = generatePrime($bitLength);
    $q = generatePrime($bitLength);
//multiplication , substraction
    $n = gmp_mul($p, $q);
    $phi = gmp_mul(gmp_sub($p, 1), gmp_sub($q, 1));

    $e = findCoprime($phi);
    $d = modInverse($e, $phi);
//renvoyer les valeurs 
    return [
        'publicKey' => compact('e', 'n'),
        'privateKey' => compact('d', 'n'),
        'autres'=> compact('p' , 'q' , 'phi')
    ];
}
//générer des nombres premiers 
function generatePrime($bitLength) {
    do {
        $randomNumber = gmp_random_bits($bitLength);
    } while (!gmp_prob_prime($randomNumber, 50));

    return gmp_strval($randomNumber);
}
//trouver un nombre premier $e avec $phi 
function findCoprime($phi) {
    $e = gmp_init(5); //valeur par défaut 
    $phi = gmp_intval($phi);
    
    while (gmp_cmp(gmp_gcd($e, gmp_init($phi)), 1) != 0) {
        $e = gmp_add($e, 1);
    }

    return gmp_strval($e);
}
//inverse modulaire
function modInverse($a, $m) {
    return gmp_intval(gmp_invert($a, $m));
}
function crypt_manuel($message) {
    $e = gmp_init(5);
    $n = gmp_init("3890858955378152207");
    $blocks = convertMessageToBlocks($message);
    $encryptedBlocks = [];

    foreach ($blocks as $block) {
        $encryptedBlock = gmp_powm($block, $e, $n);
        $encryptedBlocks[] = $encryptedBlock;
    }
    return convertBlocksToPassword($encryptedBlocks) ; 
}

function convertMessageToBlocks($message) {
    $blocks = [];
    for ($i = 0; $i < strlen($message); $i++) {
        $blocks[] = gmp_init(ord($message[$i])); 
    }
    return $blocks;
}

// Fonction pour convertir des blocs de nombres en message
function convertBlocksToMessage($blocks) {
    $message = '';
    foreach ($blocks as $block) {
    // Afficher la valeur numérique du bloc déchiffré
        $message .= chr(gmp_intval($block)); 
    }
     // Nouvelle ligne pour la clarté dans l'affichage
    return $message;
}
function convertBlocksToPassword($blocks){
    $message = '';
    foreach ($blocks as $block) {
    // Afficher la valeur numérique du bloc déchiffré
        $message .= gmp_intval($block).' '; 
    }
     // Nouvelle ligne pour la clarté dans l'affichage
    return trim($message);
}

// Fonction pour déchiffrer un message chiffré
function decrypt_manuel($encryptedMessage) {
    $d = gmp_init("3112687161145476077");
    $n = gmp_init("3890858955378152207");
    // Convertir la chaîne de caractères en blocs de nombres
    $encryptedBlocks = convertPasswordToBlocks($encryptedMessage);

    $decryptedBlocks = [];

    // Déchiffrer chaque bloc
    foreach ($encryptedBlocks as $block) {
        $decryptedBlock = gmp_powm($block, $d, $n);
        $decryptedBlocks[] = $decryptedBlock;
    }

    // Retourner le message déchiffré
    return convertBlocksToMessage($decryptedBlocks);
}

// Fonction pour convertir une chaîne de caractères en blocs de nombres
function convertPasswordToBlocks($password) {
    $blocks = [];
    $numbers = explode(' ', trim($password));

    foreach ($numbers as $number) {
        $blocks[] = gmp_init($number);
    }

    return $blocks;
}
?>