<?php 


/**
 * Fonction échappant les caractères html dans $message
 * @param string $message chaîne à échapper
 * @return string chaîne échappée
 */
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function check_data_customer() {
    $infos = [];

    // Vérification du nom
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        if (!empty($name) && ctype_alpha($name)) {
            $infos['name'] = $name;
        } else {
            return [false, "Le nom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques."];
        }
    }

    // Vérification du prénom
    if (isset($_POST['surname'])) {
        $surname = trim($_POST['surname']);
        if (!empty($surname) && ctype_alpha($surname)) {
            $infos['surname'] = $surname;
        } else {
            return [false, "Le prénom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques."];
        }
    }

    // Vérification de l'e-mail
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $infos['email'] = $email;
        } else {
            return [false, 'Adresse email non conforme !!'];
        }
    }

    $infos['role'] = "client";
 
    // Vérification du mot de passe au moins une majuscule une minuscule un caractère spécial et au moins huit caractères
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password) && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $infos['password'] = crypt_biblio($password);
        } else {
            return [false, 'Mot de passe non conforme !!'];
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
            $infos['name'] = $name;
        } else {
            return [false, "Le nom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques."];
        }
    }

    // Vérification du prénom
    if (isset($_POST['surname'])) {
        $surname = trim($_POST['surname']);
        if (!empty($surname) && ctype_alpha($surname)) {
            $infos['surname'] = $surname;
        } else {
            return [false, "Le prénom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques."];
        }
    }

    // Vérification de l'e-mail
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $infos['email'] = $email;
        } else {
            return [false, 'Adresse email non conforme !!'];
        }
    }

    $infos['role'] = "formateur";

    // Vérification du mot de passe
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password) && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $infos['password'] = crypt_biblio($password);
        } else {
            return [false, 'Mot de passe non conforme !!'];
        }
        }

    $infos['estaffranchi'] = "false";

    // Vérification du LinkedIn
    if (isset($_POST['linkedin'])) {
        $linkedin = trim($_POST['linkedin']);
        if (!empty($linkedin)) {
            $infos['linkedin'] = $linkedin;
        } else {
            return [false, ''];
        }
    }

    // Vérification du CV 
    if (isset($_FILES['cv'])) {
        $cv = $_FILES['cv'];
        if (!empty($cv)) {
            $infos['cv'] = $cv;
        } else {
            return [false, ''];
        }
    }

    return $infos;
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
//deuxieme essai :(
    //en premier generer la cle rsa 
    function generateRSAKeys($bitLength){
        //generer cdeux nombres premiers aléatoirements 
        $p= generatePrime($bitLength) ;
        $q= generatePrime($bitLength) ;
        // le n et le fi , calcul basique
        $n= $p*$q ;
        $fi = ($p-1)*($q-1) ;
        //le fonction findCoprime trouve un nombre premier avec fi avec la méthode Euler
        $e= findCoprime($fi) ;
        //calculer l'inverse de $e modulo fi
        $d=modInverse($e,$fi) ;
        //retourner les valeurs tableau composé
        return [
            'publicKey' => compact('e', 'n'),
            'privateKey' => compact('d', 'n')
        ];
    }
    //en deux le chiffrement 
    function encryptRSA($str , $publicKey){
        //convertir le message en entier , 
        return numberToString(modPow(stringToNumber($str),$publicKey['e'] , $publicKey['n'])) ;
    }
    //en trois dechiffrement 
    function decryptRSA($encryptedMessage, $privateKey) {
        return numberToString(modPow(stringToNumber($encryptedMessage), $privateKey['d'], $privateKey['n']));
    }

    //ensuite c'et le code des fonctions de math qui sont pas disponibles sur php qui sont pas nécessaires daprès moi a comprendre a part si vous voulez vous casser la tête
    //gmp bibliothèque maths
    function generatePrime($bitLength) {
        do {
            $randomNumber = gmp_random_bits($bitLength);
        } while (!gmp_prob_prime($randomNumber, 50));
    
        return gmp_strval($randomNumber);
    }
    function modPow($base, $exponent, $modulus) {
        $result = gmp_powm($base, $exponent, $modulus);
        return gmp_intval($result);
    }
    function modInverse($a, $m) {
        return gmp_intval(gmp_invert($a, $m));
    }
    function stringToNumber($string) {
        $result = '0';
        $length = strlen($string);
    
        for ($i = 0; $i < $length; $i++) {
            $result = bcmul($result, '256');
            $result = bcadd($result, sprintf('%03d', ord($string[$i])));
        }
    
        return $result;
    }
    
    function numberToString($number) {
        $result = '';
    
        while (strlen($number) > 0) {
            $byte = substr($number, -3);  // Récupère les trois derniers chiffres
            $result = chr((int)$byte) . $result;  // Convertit en caractère ASCII et ajoute au résultat
            $number = substr($number, 0, -3);  // Retire les trois derniers chiffres
        }
    
        return $result;
    }
    function findCoprime($phi) {
        $e = gmp_init(65537); // Une valeur couramment utilisée pour e (peut être modifié)
        $phi = intval($phi);
        while (gmp_cmp(gmp_gcd($e, gmp_init($phi)), 1) != 0) {
            $e = gmp_add($e, 1);
        }
    
        return gmp_strval($e);
    }

/*
// Fonction pour générer une paire de clés RSA
function generateRSAKeys($bitLength) {
    $p = generatePrime($bitLength);
    $q = generatePrime($bitLength);

    $n = $p * $q;
    $phi = ($p - 1) * ($q - 1);

    $e = findCoprime($phi);
    $d = modInverse($e, $phi);

    return [
        'publicKey' => compact('e', 'n'),
        'privateKey' => compact('d', 'n')
    ];
}

function encryptRSA($message, $publicKey) {
    return numberToString(modPow(stringToNumber($message), $publicKey['e'], $publicKey['n']));
}

function decryptRSA($encryptedMessage, $privateKey) {
    return numberToString(modPow(stringToNumber($encryptedMessage), $privateKey['d'], $privateKey['n']));
}

function generatePrime($bitLength) {
    // Utilisez une boucle pour générer un nombre premier
    do {
        $randomNumber = random_int(0, intval(bcpow(2, $bitLength)));
    } while (!gmp_prob_prime(gmp_init($randomNumber, 10), 50)); // Utilisez la bibliothèque GMP pour tester la primalité

    return $randomNumber;
}

function findCoprime($phi) {
    $e = gmp_init(65537);

    while (gmp_cmp(gmp_gcd($e, gmp_init($phi)), 1) != 0) {
        $e = gmp_add($e, 1);
    }

    return intval(gmp_strval($e));
}

function gcd($a, $b) {
    while (gmp_cmp($b, 0) != 0) {
        $temp = $b;
        $b = gmp_mod($a, $b);
        $a = $temp;
    }

    return $a;
}

function modInverse($a, $m) {
    $m0 = $m;
    $x0 = 0;
    $x1 = 1;

    while ($a > 1) {
        $q = intdiv($a, $m);
        $t = $m;

        $m = $a % $m;
        $a = $t;
        $t = $x0;

        $x0 = $x1 - $q * $x0;
        $x1 = $t;
    }

    if ($x1 < 0) {
        $x1 += $m0;
    }

    return $x1;
}

function modPow($base, $exponent, $modulus) {
    $result = '1';

    $base = bcmod($base, $modulus);

    while (bccomp($exponent, '0') > 0) {
        if (bcmod($exponent, '2') == '1') {
            $result = bcmul($result, $base);
            $result = bcmod($result, $modulus);
        }

        $exponent = bcdiv($exponent, '2');
        $base = bcmul($base, $base);
        $base = bcmod($base, $modulus);
    }

    return intval($result);
}

function stringToNumber($string) {
    $result = '0';
    $length = strlen($string);

    for ($i = 0; $i < $length; $i++) {
        $result = bcmul($result, '256');
        $result = bcadd($result, ord($string[$i]));
    }

    return $result;
}

function numberToString($number) {
    $result = '';

    while ($number > 0) {
        $byte = bcmod($number, '256');
        $result = chr((int)$byte) . $result;
        $number = bcdiv($number, '256', 0);
    }

    return $result;
}*/
/*
$keys = generateRSAKeys(256);
$publicKey = $keys['publicKey'];
$privateKey = $keys['privateKey'];

$message = "Bonjour, ceci est un exemple de message.";

$encryptedMessage = encryptRSA($message, $publicKey);
echo "Message chiffré : " . $encryptedMessage . PHP_EOL;

$decryptedMessage = decryptRSA($encryptedMessage, $privateKey);
echo "Message déchiffré : " . $decryptedMessage . PHP_EOL;
*/
        ?>
        
        

